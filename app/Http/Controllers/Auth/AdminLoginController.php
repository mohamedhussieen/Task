<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('Laravel Password Grant Client')->accessToken;
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
