<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Define a mapping between user_type_id and roles
    protected $roleMapping = [
        // 'user_type_id' => 'role_name'
        1 => 'زائر',        // Visitor
        2 => 'مدير',        // Admin
        3 => 'سائح',        // Tourist
        4 => 'متجر',        // Store
        5 => 'مرشد سياحي'  // tour-guide
    ];

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function register(array $data)
    {
        $user = User::create([
            'user_type_id' => $data['user_type_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => encrypt($data['password']),
            'status' => $data['status'],
            'age' => $data['age'],
            'gender' => $data['gender'],
        ]);

        // Assign role based on user_type_id
        $role = $this->roleMapping[$data['user_type_id']];
        if ($role) {
            $user->assignRole($role);
        }
        return $this->generateTokenResponse($user);
    }

    public function login(array $data)
    {
        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {
            return ['message' => 'There is no user with this phone number'];
        }

        if ($data['login_method'] === 'password') {
            return $this->loginWithPassword($user, $data['password']);
        }

        if ($data['login_method'] === 'otp') {
            return $this->loginWithSMS($user, $data);
        }

        return ['message' => 'Invalid login method'];
    }

    protected function loginWithPassword($user, $password)
    {
        if (!Hash::check($password, $user->password)) {
            return ['message' => 'The provided password is incorrect'];
        }

        return $this->generateTokenResponse($user);
    }

    protected function loginWithSMS($user, $data)
    {
        if (!isset($data['otp'])) {
            // Generate OTP
            $otp = rand(10000, 99999);
            // $otp = 11111;
            Cache::put('otp_' . $user->phone, $otp, now()->addMinutes(5));

            $this->smsService->sms($user->phone, $otp);
        } else {
            // Validate OTP
            $cachedOtp = Cache::get('otp_' . $user->phone);
            if ($data['otp'] != $cachedOtp) {
                return ['message' => 'Invalid OTP'];
            }

            return $this->generateTokenResponse($user);
        }
    }

    protected function generateTokenResponse($user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user, 'name' => $user];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }

    public function sendPhoneOtp(string $phone)
    {
        $otp = rand(10000, 99999);
        Cache::put('otp_' . $phone, $otp, now()->addMinute(5));

        $this->smsService->sms($phone, $otp);

        return response()->json([
            'message' => 'send otp successfully',
            'statusCode' => 200
        ], 201);
    }

    public function verifyPhoneOtp(int $otp, string $phone)
    {
        $cachedOtp = Cache::get('otp_' . $phone);

        if ($cachedOtp != $otp) {
            return response()->json([
                'message' => 'رقم التحقق خاطئ',
                'statusCode' => 400
            ], 400);
        }

        return response()->json([
            'message' => 'تم التحقق بنجاح',
            'statusCode' => 200
        ], 200);
    }
}
