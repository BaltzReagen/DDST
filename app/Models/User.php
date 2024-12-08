<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable; // This needs to be extended
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable // Now extending Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'username',
        'password',
        'isGuest',
        'email',
        'google_id',
        'rememberToken',
    ];

    protected $hidden = [
        'password', // Hide sensitive fields
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function isGoogleUser()
    {
        return !is_null($this->google_id);
    }

    public function canResetPassword()
    {
        return !$this->isGoogleUser() && !$this->isGuest;
    }
}
