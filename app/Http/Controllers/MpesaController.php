<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MpesaController extends Controller
{
    // 1. Initiate STK Push (Deposit)
    public function stkPush(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:1',
            'phone_number' => 'required|string|min:10|max:16',
        ]);

        $wallet = Wallet::findOrFail($request->wallet_id);
        
        if ($wallet->user_id !== Auth::id() || $wallet->currency !== 'KES') {
            abort(403, 'Invalid wallet.');
        }

        // Sanitize phone
        $phone = str_replace(['+', ' ', '-'], '', $request->phone_number);
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }

        if (!preg_match('/^254[0-9]{9}$/', $phone)) {
            return back()->withErrors(['phone_number' => 'Invalid phone format. Use 254712345678 or 0712345678']);
        }

        $reference = 'KargoPay-' . Str::random(6);
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);

        // Get access token
        $auth = base64_encode(env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET'));
        
        $tokenResponse = \Http::withHeaders([
            'Authorization' => 'Basic ' . $auth
        ])->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        if (!$tokenResponse->successful()) {
            Log::error('M-Pesa token failed: ' . $tokenResponse->body());
            return back()->withErrors(['error' => 'Failed to connect to M-Pesa.']);
        }

        $accessToken = $tokenResponse->json('access_token');

        // Save transaction as pending
        $transaction = MpesaTransaction::create([
            'user_id' => Auth::id(),
            'wallet_id' => $wallet->id,
            'phone_number' => $phone,
            'amount' => $request->amount,
            'reference' => $reference,
            'status' => 'pending',
        ]);

        // Send STK Push
        $stkResponse = \Http::withToken($accessToken)->post(
            'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            [
                'BusinessShortCode' => env('MPESA_SHORTCODE'),
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) $request->amount,
                'PartyA' => $phone,
                'PartyB' => env('MPESA_SHORTCODE'),
                'PhoneNumber' => $phone,
                'CallBackURL' => env('MPESA_CALLBACK_URL'),
                'AccountReference' => $reference,
                'TransactionDesc' => 'KargoPay Wallet Top-up',
            ]
        );

        $responseData = $stkResponse->json();
        Log::info('STK Push Response: ', $responseData);

        if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '0') {
            $transaction->update([
                'merchant_request_id' => $responseData['MerchantRequestID'] ?? null,
                'checkout_request_id' => $responseData['CheckoutRequestID'] ?? null,
                'response_description' => $responseData['CustomerMessage'] ?? 'Success',
            ]);

            return back()->with('success', 'STK Push sent! Enter your M-Pesa PIN.');
        }

        $transaction->update([
            'status' => 'failed',
            'response_description' => $responseData['errorMessage'] ?? json_encode($responseData),
        ]);

        return back()->withErrors(['error' => $responseData['errorMessage'] ?? 'STK Push failed.']);
    }

    // 2. Handle Safaricom Callback
    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info('M-Pesa Callback Received: ', $data);

        $callback = $data['Body']['stkCallback'] ?? null;

        if (!$callback) {
            return response()->json(['message' => 'Invalid callback'], 400);
        }

        $resultCode = $callback['ResultCode'];
        $checkoutRequestId = $callback['CheckoutRequestID'] ?? null;

        $transaction = MpesaTransaction::where('checkout_request_id', $checkoutRequestId)
            ->orWhere('merchant_request_id', $callback['MerchantRequestID'] ?? null)
            ->first();

        if (!$transaction) {
            Log::warning('Callback: Transaction not found for CheckoutRequestID: ' . $checkoutRequestId);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($resultCode == 0) {
            // 🛡️ CRITICAL FIX: Prevent double-crediting if checkStatus already processed it
            if ($transaction->status === 'completed') {
                return response()->json(['message' => 'Already processed'], 200);
            }

            // Success
            $metadata = $callback['CallbackMetadata']['Item'] ?? [];
            $receiptNumber = null;
            $amount = $transaction->amount;

            foreach ($metadata as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $receiptNumber = $item['Value'];
                }
                if ($item['Name'] === 'Amount') {
                    $amount = $item['Value'];
                }
            }

            $transaction->update([
                'status' => 'completed',
                'mpesa_receipt_number' => $receiptNumber,
                'response_description' => 'Success',
            ]);

            $transaction->wallet->increment('balance', $amount);

            Log::info('Payment successful. Wallet credited. Receipt: ' . $receiptNumber);
        } else {
            // Failed
            $resultDesc = $callback['ResultDesc'] ?? 'Failed';
            $transaction->update([
                'status' => $resultCode == 1032 ? 'canceled' : 'failed',
                'response_description' => $resultDesc,
            ]);
            Log::info('Payment failed: ' . $resultDesc);
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }

    // 3. Check Status (Fallback if callback missed)
    public function checkStatus($transactionId)
    {
        $transaction = MpesaTransaction::findOrFail($transactionId);
        
        // 🛡️ CRITICAL FIX: Stop immediately if already processed
        if ($transaction->status !== 'pending') {
            return response()->json([
                'status' => $transaction->status,
                'message' => 'Already processed.',
            ]);
        }

        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);
        
        $auth = base64_encode(env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET'));
        
        $tokenResponse = \Http::withHeaders([
            'Authorization' => 'Basic ' . $auth
        ])->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        $accessToken = $tokenResponse->json('access_token');

        $queryResponse = \Http::withToken($accessToken)->post(
            'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query',
            [
                'BusinessShortCode' => env('MPESA_SHORTCODE'),
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $transaction->checkout_request_id,
            ]
        );

        $result = $queryResponse->json();

        if (isset($result['ResultCode'])) {
            if ($result['ResultCode'] == '0') {
                
                // 🛡️ Re-fetch transaction from DB to ensure callback didn't just update it
                $transaction->refresh();
                if ($transaction->status === 'completed') {
                     return response()->json([
                        'status' => 'completed',
                        'message' => 'Already processed by callback.',
                    ]);
                }

                $transaction->update([
                    'status' => 'completed',
                    'response_description' => $result['ResultDesc'] ?? 'Success',
                ]);
                $transaction->wallet->increment('balance', $transaction->amount);
                
                return response()->json([
                    'status' => 'completed',
                    'message' => 'Payment confirmed! Wallet credited.',
                    'new_balance' => $transaction->wallet->fresh()->balance,
                ]);
            } else {
                $transaction->update([
                    'status' => 'failed',
                    'response_description' => $result['ResultDesc'] ?? 'Failed',
                ]);
                
                return response()->json([
                    'status' => 'failed',
                    'message' => $result['ResultDesc'] ?? 'Payment failed.',
                ]);
            }
        }

        return response()->json([
            'status' => 'pending',
            'message' => 'Still processing. Try again in 30 seconds.',
        ]);
    }
}