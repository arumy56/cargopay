<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subusers extends Model
{
    //
    protected $fillable = [
        'firstname',
        'secondname',
        'email',
        'password',
        'roles',
        'is_active'
    ];

    public function scopeGetActive($query){
        return $query->where('is_active', true);
    }
}
