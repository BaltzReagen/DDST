<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Kata Laluan')
            ->line('Anda menerima emel ini kerana kami menerima permintaan reset kata laluan untuk akaun anda.')
            ->action('Reset Kata Laluan', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset()
            ], false)))
            ->line('Pautan reset kata laluan ini akan tamat tempoh dalam ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' minit.')
            ->line('Jika anda tidak meminta reset kata laluan, tiada tindakan diperlukan.');
    }
}