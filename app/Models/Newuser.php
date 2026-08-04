<?php

namespace App\Models;
// use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Newuser extends Authenticatable implements MustVerifyEmail
{
    // 
    use Notifiable;
    protected $fillable = [
        'firstname',
        'secondname',
        'email',
        'password', 
        'role',
        'is_active',
        'organization_id'
    ];

     protected $hidden = [
        'password',
        
    ];

    public function isSuperuser():bool
    {
         return $this->role === 'superuser';
    }

    public function isSubuser():bool
    {
        // return $this->role == 'subuser';
        return $this->organization_id !== null;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function organization()
    {
        return $this->belongsTo(Newuser::class, 'organization_id');
    }

    public function subusers()
    {
        return $this->hasMany(Newuser::class, 'organization_id');
    }

    public function fullName(): string
{
    return $this->firstname . ' ' . $this->secondname;
}

public function billerAccount()
{
    return $this->hasOne(BillerAccount::class, 'user_id');
}

public function wallets()
{
    return $this->hasMany(Wallet::class, 'user_id');
}

public function kesWallet()
{
    return $this->hasOne(Wallet::class, 'user_id')->where('currency', 'KES');
}

public function usdWallet()
{
    return $this->hasOne(Wallet::class, 'user_id')->where('currency', 'USD');
}


}
