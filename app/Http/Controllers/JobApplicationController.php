<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use App\Models\Admin;
use App\Models\JobApplication;
use App\Notifications\JobApplicationSubmittedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function store(JobApplicationRequest $request)
    {
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs');
        }

        $expiryDate = Carbon::now()->addMonths(3);
        $userId = Auth::id();
        $cvUrl = asset('storage/' . $cvPath);

        $jobApplication = JobApplication::create([
            'vacancy_id' => $request->vacancy_id,
            'user_id' => $userId,
            'cover_letter' => $request->cover_letter,
            'cv' => $cvUrl,
            'expiry_date' => $expiryDate,
        ]);

        $admins = Admin::get();

        foreach ($admins as $admin) {
            $admin->notify(new JobApplicationSubmittedNotification($jobApplication));
        }
        return response()->json($jobApplication, 201);
    }
}
