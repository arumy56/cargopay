<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $fillable = [
        'user_id',
        'currency',
        'balance',
        'wallet_name',
        'mpesa_number',
        'bank_account',
        'is_active'

    ];

     protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];


     public function user()
    {
        return $this->belongsTo(Newuser::class, 'user_id');
    }


    public function getFormattedBalanceAttribute(): string
    {
        if ($this->currency === 'KES') {
            return 'KES ' . number_format($this->balance, 2);
        } elseif ($this->currency === 'USD') {
            return '$' . number_format($this->balance, 2);
        }
        return $this->currency . ' ' . number_format($this->balance, 2);
    }

     public function getCurrencySymbolAttribute(): string
    {
        return match($this->currency) {
            'KES' => 'KSh',
            'USD' => '$',
            default => $this->currency,
        };
    }

}
