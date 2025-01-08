<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Http\Requests\AuthRequests\SendOtpRequest;
use App\Mail\ResetPasswordOTP;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function sendOTP(SendOtpRequest $request)
    {
        $otp = rand(1000, 9999);
        $email = $request->email;

        // save otp in password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(10)]
        );

        // send otp to user email
        Mail::to($email)->send(new ResetPasswordOTP($otp));

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        // get record from password_resets table by email and otp
        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        // check if otp is invalid or expired
        if (!$passwordReset || $passwordReset->expires_at < now()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // update user password
        User::where('email', $request->email)
            ->update(['password' => encrypt($request->password)]);

        // delete password reset record
        PasswordReset::where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
