<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'wallet_id',
        'phone_number',
        'amount',
        'reference',
        'status',
        'mpesa_receipt_number',
        'response_description',
        'merchant_request_id',
        'checkout_request_id',
    ];
    protected $casts = [
        'amount' => 'decimal:2',

    ];


    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(Newuser::class, 'user_id');
    }
}
