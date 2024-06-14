<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Job Application Submitted')
            ->line('A new job application has been submitted.')
            ->line('Applicant Name: ' . $this->jobApplication->user->name)
            ->line('Vacancy ID: ' . $this->jobApplication->vacancy_id)
            ->line('Cover Letter: ' . $this->jobApplication->cover_letter)
            ->line('CV: ' . $this->jobApplication->cv)
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->jobApplication->id,
            'user_id' => $this->jobApplication->user_id,
            'created_at' => $this->jobApplication->created_at,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->jobApplication->id,
            'user_id' => $this->jobApplication->user_id,
            'created_at' => $this->jobApplication->created_at,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'id' => $this->jobApplication->id,
            'user_id' => $this->jobApplication->user_id,
            'created_at' => $this->jobApplication->created_at,
        ];
    }
}
