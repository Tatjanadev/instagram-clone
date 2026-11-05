<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $token
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param  User  $notifiable
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
        // This retrieves the password-reset expiration time from config/auth.php
        $expiration = config('auth.passwords.users.expire');

        return (new MailMessage)
            ->subject('Reset your InstaNest password')
            ->markdown('emails.reset-password', [
                'firstName' => $notifiable->first_name,
                'resetUrl' => $url,
                'expiration' => $expiration,
            ]);
    }
}
