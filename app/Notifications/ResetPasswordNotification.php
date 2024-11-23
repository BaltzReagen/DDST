<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
            ->action('Reset Kata Laluan', url('password/reset', $this->token))
            ->line('Jika anda tidak meminta reset kata laluan, tiada tindakan lanjut diperlukan.');
    }
}