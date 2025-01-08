<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmEmailOTP;
use App\Models\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ConfirmEmailController extends Controller
{
    public function sendOTP()
    {
        $otp = rand(1000, 9999);

        // Send OTP to user
        $user = Auth::user();

        ConfirmEmail::create([
            'email' => $user->email,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new ConfirmEmailOTP($otp));

        // Return response with user email
        return response()->json(['message' => 'OTP sent to successfully.', 'email' => $user->email]);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();

        $confirmEmail = ConfirmEmail::where('email', $user->email)
            ->where('otp', $request->otp)
            ->where('expired_at', '>', now())
            ->first();

        if (!$confirmEmail) {
            return response()->json(['message' => 'Invalid or Expired OTP.'], 400);
        }

        $user->is_email_confirmed = true;
        $user->email_confirmed_at = now();
        $user->save();

        $confirmEmail->delete();

        return response()->json(['message' => 'Email verified successfully.']);
    }
}
