<?php

namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobApplicationSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function broadcastOn()
    {
        return ['admin-channel'];
    }

    public function broadcastAs()
    {
        return 'JobApplicationSubmitted';
    }
}
