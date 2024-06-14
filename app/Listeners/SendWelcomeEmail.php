<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Notification;
use App\Notifications\RegistrationSuccessful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserRegistered $event)
    {
        $event->user->notify(new RegistrationSuccessful());

        Notification::create([
            'type' => 'App\Notifications\RegistrationSuccessful',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => $event->user->id,
            'data' => json_encode(['message' => 'Registration successful']),
        ]);
    }
}
