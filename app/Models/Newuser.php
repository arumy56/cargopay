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
        'email_verified_at'
    ];

     protected $hidden = [
        'password',
        'remember_token',
    ];
}
