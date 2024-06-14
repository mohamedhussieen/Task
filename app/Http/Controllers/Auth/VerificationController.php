<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->verification_code)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code.'], 422);
        }

        $user->update(['verified_at' => now(), 'verification_code' => null]);

        return response()->json(['message' => 'Email verified successfully.', 'user' => $user]);
    }
}
