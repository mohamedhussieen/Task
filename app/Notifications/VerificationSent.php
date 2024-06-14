<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationSent extends Notification
{
    use Queueable;

    protected $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->line('Your verification code is: ' . $this->verificationCode)
            ->line('If you did not create an account, no further action is required.');
    }

    public function toArray($notifiable)
    {
        return [
            'verification_code' => $this->verificationCode, // Optionally store verification code in database notification
        ];
    }
}
