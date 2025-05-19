<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'password',
        'avatar',
        'role',
        'sex'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarPathAttribute()
    {
        return $this->avatar
            ? asset('storage/avatars/' . $this->avatar)
            : asset('img/avatar_default.jpg');
    }

}



