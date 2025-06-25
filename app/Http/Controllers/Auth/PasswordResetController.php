<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Http\Requests\AuthRequests\SendOtpRequest;
use App\Mail\ResetPasswordOTP;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AuthService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    protected $smsService;
    protected $authService;

    public function __construct(SmsService $smsService, AuthService $authService)
    {
        $this->authService = $authService;
        $this->smsService = $smsService;
    }

    public function sendOTP(SendOtpRequest $request)
    {
        $data = $request->validated();
        $otp = rand(10000, 99999);

        $email = $request->email;
        $phone = $request->phone;

        if (isset($data['email'])) {
            PasswordReset::updateOrCreate(
                ['email' => $email],
                ['otp' => $otp],
                ['expires_at' => now()->addMinutes(10)],
                ['phone' => $phone]
            );
            Mail::to($email)->send(new ResetPasswordOTP($otp));
        }

        if (isset($data['phone'])) {
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

        if (isset($data['email'])) {
            $passwordReset = PasswordReset::where('email', $request->email)->where('otp', $request->otp)->first();
        }

        if (isset($data['phone'])) {
            $passwordReset = PasswordReset::where('phone', $request->phone)->where('otp', $request->otp)->first();
        }

        // check if otp is invalid or expired
        if (!$passwordReset || $passwordReset->expires_at < now()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // update user password
        if (isset($data['email'])) {
            User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        }

        if (isset($data['phone'])) {
            User::where('phone', $request->phone)->update(['password' => Hash::make($request->password)]);
        }

        // delete password reset record
        if (isset($data['email'])) {
            PasswordReset::where('email', $request->email)->delete();
        }

        if (isset($data['phone'])) {
            PasswordReset::where('phone', $request->phone)->delete();
        }


        return response()->json(['message' => 'Password reset successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'integer',
            'phone' => 'required|string|max:15'
        ]);

        $result = $this->authService->verifyPhoneOtp($data['otp'], $data['phone']);
        return response()->json(['data' => $result]);
    }
}
