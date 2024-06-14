<?php

use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/vacancies', [VacancyController::class, 'index']);
Route::post('/verify-email', [VerificationController::class, 'verifyEmail']);
Route::post('admin/register', [AdminRegisterController::class, 'register']);
Route::middleware('auth:api')->group(function () {
    Route::post('jobs/apply', [JobApplicationController::class, 'store']);
});
Route::middleware('auth:admin')->group(function () {
    Route::post('admin/vacancies', [VacancyController::class, 'store']);
});
Route::get('jobs', [JobController::class, 'index']);

Route::post('admin/login', [AdminLoginController::class, 'login']);

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
