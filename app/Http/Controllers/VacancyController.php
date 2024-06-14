<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyRequest;
use App\Models\Vacancy;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::all();
        return response()->json($vacancies);
    }

    public function store(StoreVacancyRequest $request)
    {
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('vacancy_files');
        }

        $vacancy = Vacancy::create([
            'title' => $request->title,
            'company' => $request->company,
            'description' => $request->description,
            'location' => $request->location,
            'closing_date' => $request->closing_date,
            'salary' => $request->salary,
            'posted_date' => now(),
        ]);

        return response()->json($vacancy, 201);
    }
}
