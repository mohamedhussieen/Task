<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerificationSent;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // use SendsVerificationCode;

    public function register(RegisterRequest $request)
    {
        $verificationCode = rand(100000, 999999);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
        ]);

        // $user->notify(new RegistrationSuccessful);
        $user->notify(new VerificationSent($verificationCode));
        // event(new UserRegistered($user));
        // $verificationCode = rand(100000, 999999); // Generate a random 6-digit code
        // $this->sendVerificationCode($request->phone, $verificationCode);
        return response()->json(['message' => 'User successfully registered'], 201);
    }
}
