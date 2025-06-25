<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Http\Requests\AuthRequests\SendOtpRequest;
use App\Mail\ResetPasswordOTP;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendOTP(SendOtpRequest $request)
    {
        $data = $request->validated();
        $otp = rand(10000, 99999);

        $email = $request->email;
        $phone = $request->phone;

        if ($data['email'] != null) {
            PasswordReset::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp],
                ['expires_at' => now()->addMinutes(10)],
                ['phone' => $phone]
            );
            Mail::to($email)->send(new ResetPasswordOTP($otp));
        }

        if ($data['phone'] != null) {
            PasswordReset::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp],
                ['expires_at' => now()->addMinutes(10)],
                ['phone' => $phone]
            );
            $this->smsService->sms($phone, $otp);
        }

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();

        $email = $request->email;
        $phone = $request->phone;
        $passwordReset = null;

        if ($data['email'] != null) {
            $passwordReset = PasswordReset::where('email', $request->email)->where('otp', $request->otp)->first();
        }

        if ($data['phone'] != null) {
            $passwordReset = PasswordReset::where('phone', $request->phone)->where('otp', $request->otp)->first();
        }

        // check if otp is invalid or expired
        if (!$passwordReset || $passwordReset->expires_at < now()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // update user password
        if ($data['email'] != null) {
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        }

        if ($data['phone'] != null) {
            User::where('phone', $request->phone)->update(['password' => Hash::make($request->password)]);
        }

        // delete password reset record
        if ($data['email'] != null) {
            PasswordReset::where('email', $request->email)->delete();
        }

        if ($data['phone'] != null) {
            PasswordReset::where('phone', $request->phone)->delete();
        }


        return response()->json(['message' => 'Password reset successfully.']);
    }
}
