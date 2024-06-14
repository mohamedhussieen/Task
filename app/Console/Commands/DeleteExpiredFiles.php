<?php

namespace App\Console\Commands;

use App\Models\JobApplication;
use Illuminate\Console\Command; // Adjust the model namespace as per your application
use Illuminate\Support\Facades\Storage;

class DeleteExpiredCVs extends Command
{
    protected $signature = 'cvs:delete-expired';
    protected $description = 'Delete expired CV files from job applications';

    public function handle()
    {
        $expiredApplications = JobApplication::whereNotNull('cv')
            ->whereDate('expiry_date', '<=', now())
            ->get();

        foreach ($expiredApplications as $application) {
            $cvPath = $application->cv;

            if (Storage::exists($cvPath)) {
                Storage::delete($cvPath);
            }

            $application->cv = null;
            $application->save();
        }

        $this->info('Expired CVs from job applications deleted successfully.');
    }
}
