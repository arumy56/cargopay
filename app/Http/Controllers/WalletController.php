<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kesWallet = $user->kesWallet;
        $usdWallet = $user->usdWallet;

        return view('wallets.index', compact('kesWallet', 'usdWallet'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|in:KES,USD',
            'wallet_name' => 'nullable|string|max:255',
            'mpesa_number' => 'nullable|string|regex:/^\+?254[0-9]{9}$/',
            'bank_account' => 'nullable|string|max:255',
            'initial_balance' => 'nullable|numeric|min:0',
            
        ]);

        // Check if wallet already exists for this currency
        $existing = Wallet::where('user_id', Auth::id())
            ->where('currency', $validated['currency'])
            ->first();

        if ($existing) {
            $existing->update([
                'wallet_name' => $validated['wallet_name'] ?? $existing->wallet_name,
                'mpesa_number' => $validated['mpesa_number'] ?? $existing->mpesa_number,
                'bank_account' => $validated['bank_account'] ?? $existing->bank_account,
                'balance' => $validated['initial_balance'] ?? $existing->balance,
            ]);

            return redirect()->route('wallets.index')
                ->with('success', "{$validated['currency']} wallet updated successfully!");
        }

        // FIX: Use ?? null to safely handle missing optional fields
        Wallet::create([
            'user_id' => Auth::id(),
            'currency' => $validated['currency'],
            'wallet_name' => $validated['wallet_name'] ?? null,
            'mpesa_number' => $validated['mpesa_number'] ?? null,
            'bank_account' => $validated['bank_account'] ?? null,
            'balance' => $validated['initial_balance'] ?? 0.00,
            'is_active' => true,
        ]);

        return redirect()->route('wallets.index')
            ->with('success', "{$validated['currency']} wallet created successfully!");
    }

    public function update(Request $request, Wallet $wallet)
    {
        $this->authorizeOwnership($wallet);

        $validated = $request->validate([
            'wallet_name' => 'nullable|string|max:255',
            'mpesa_number' => 'nullable|string|regex:/^\+?254[0-9]{9}$/',
            'bank_account' => 'nullable|string|max:255',
        ]);

        // FIX: Use ?? to preserve existing data if a field is left blank in the edit form
        $wallet->update([
            'wallet_name' => $validated['wallet_name'] ?? $wallet->wallet_name,
            'mpesa_number' => $validated['mpesa_number'] ?? $wallet->mpesa_number,
            'bank_account' => $validated['bank_account'] ?? $wallet->bank_account,
        ]);

        return redirect()->route('wallets.index')
            ->with('success', "{$wallet->currency} wallet updated successfully!");
    }

    public function toggle(Wallet $wallet)
    {
        $this->authorizeOwnership($wallet);

        $wallet->update(['is_active' => !$wallet->is_active]);

        $status = $wallet->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('wallets.index')
            ->with('success', "{$wallet->currency} wallet {$status}.");
    }

    private function authorizeOwnership(Wallet $wallet)
    {
        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'This wallet does not belong to your account.');
        }
    }
}