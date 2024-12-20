<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

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

    public function register(array $data)
    {
        $user = User::create([
            'user_type_id' => $data['user_type_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'age' => $data['age'],
            'gender' => $data['gender'],
        ]);

        // Assign role based on user_type_id
        $role = $this->roleMapping[$data['user_type_id']];
        if ($role) {
            $user->assignRole($role);
        }
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
        if (!encrypt($password, $user->password)) {
            return ['message' => 'The provided password is incorrect'];
        }

        return $this->generateTokenResponse($user);
    }

    protected function loginWithSMS($user, $data)
    {
        if (!isset($data['otp'])) {
            // Generate OTP
            $otp = rand(100000, 999999);
            Cache::put('otp_' . $user->phone, $otp, now()->addMinutes(5));

            // HERE implement send the OTP via SMS using another service

            return ['message' => 'OTP sent to your phone'];
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

        return ['access_token' => $token, 'token_type' => 'Bearer'];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}
