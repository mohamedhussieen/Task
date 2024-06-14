<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $identifier = $request->identifier;
        $login_type = $request->login_type;

        $egyptMobileRegex = '/^(010|011|012|015)[0-9]{8}$/';
        $dubaiMobileRegex = '/^(050|052|054|055|056|058)[0-9]{7}$/';

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $login_type = 'email';
        } elseif (preg_match($egyptMobileRegex, $identifier)) {
            $login_type = 'phone';
        } elseif (preg_match($dubaiMobileRegex, $identifier)) {
            $login_type = 'phone';
        } else {
            $login_type = 'username';
        }

        if ($login_type == 'email') {
            $user = User::where('email', $request->identifier)->first();
        } elseif ($login_type == 'phone') {
            $user = User::where('phone', $request->identifier)->first();
        } else {
            $user = User::where('username', $request->identifier)->first();
        }

        if ($user) {
            if (!$user->verified_at) {
                return response()->json(['message' => 'Email address not verified.'], 403);
            }

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];

                return response($response, 200);
            } else {
                $response = ['message' => 'Invalid credentials'];

                return response($response, 422);
            }
        } else {
            $response = ['message' => 'Invalid credentials'];

            return response($response, 422);
        }
    }
}
