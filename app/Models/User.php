<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable; // This needs to be extended
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable // Now extending Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'username',
        'password',
        'isGuest',
        'email',
    ];

    protected $hidden = [
        'password', // Hide sensitive fields
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
