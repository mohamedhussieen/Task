<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSuccessful extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Thank you for registering.')
            ->action('Login', url('/login'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }
}
