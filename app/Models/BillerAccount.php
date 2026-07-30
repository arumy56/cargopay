<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillerAccount extends Model
{
    //
    protected $fillable = [
        'user_id',
        'kra_pin',
        'biller_account',
        'is_completed'
    ];

     public function user()
    {
        return $this->belongsTo(Newuser::class, 'user_id');
    }
}
