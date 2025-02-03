<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AuthService
{
    private $api_url = 'http://46.151.210.31:8080/websmpp/websms';
    private $api_user;
    private $api_pass;
    private $api_sid;

    // Define a mapping between user_type_id and roles
    protected $roleMapping = [
        // 'user_type_id' => 'role_name'
        1 => 'زائر',        // Visitor
        2 => 'مدير',        // Admin
        3 => 'سائح',        // Tourist
        4 => 'متجر',        // Store
        5 => 'مرشد سياحي'  // tour-guide
    ];

    public function __construct()
    {
        $this->api_user = config('app.broadnet.ApiUser');
        $this->api_pass = config('app.broadnet.ApiPass');
        $this->api_sid = config('app.broadnet.ApiSid');
    }

    public function register(array $data)
    {
        if (isset($data['phone'])) {
            return $this->sendPhoneOtp($data['phone']);
        }
        // if (!isset($data['phone_otp'])) {
        //     // $otp = rand(10000, 99999);
        //     $otp = 11111;
        //     Cache::put('otp_' . $data['phone'], $otp, now()->addMinutes(5));

        //     // $url = "$this->api_url?user=$this->api_user&pass=$this->api_pass&sid=$this->api_sid&mno={$data['phone']}&type=4&text=رمز التحقق: $otp&respformat=json";
        //     // $response = Http::withHeaders([
        //     //     'Accept' => 'application/json',
        //     // ])->post($url);

        //     return [$otp];
        // } else {
        //     $cachedOtp = Cache::get('otp_' . $data['phone']);
        //     if ($data['phone_otp'] != $cachedOtp) {
        //         return ['message' => 'Invalid OTP'];
        //     } else {
        //         $user = User::create([
        //             'user_type_id' => $data['user_type_id'],
        //             'name' => $data['name'],
        //             'email' => $data['email'],
        //             'phone' => $data['phone'],
        //             'password' => encrypt($data['password']),
        //             'status' => $data['status'],
        //             'age' => $data['age'],
        //             'gender' => $data['gender'],
        //         ]);

        //         // Assign role based on user_type_id
        //         $role = $this->roleMapping[$data['user_type_id']];
        //         if ($role) {
        //             $user->assignRole($role);
        //         }
        //     }
        //     return $this->generateTokenResponse($user);
        // }
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
            $otp = rand(10000, 99999);
            Cache::put('otp_' . $user->phone, $otp, now()->addMinutes(5));

            // HERE implement send the OTP via SMS using another service
            $url = "$this->api_url?user=$this->api_user&pass=$this->api_pass&sid=$this->api_sid&mno=$user->phone&type=4&text=رمز التحقق: $otp&respformat=json";
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post($url);


            return ['message' => $response];
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

    public function sendPhoneOtp(string $phone)
    {
        // $otp = rand(10000, 99999);
        $otp = 11111;
        Cache::put('otp_' . $phone, $otp, now()->addMinute(5));

        // $url = "$this->api_url?user=$this->api_user&pass=$this->api_pass&sid=$this->api_sid&mno=$phone&type=4&text=رمز التحقق: $otp&respformat=json";
        // Http::withHeaders([
        //     'Accept' => 'application/json',
        // ])->post($url);

        return response()->json([
            'message' => 'send it otp successfully',
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
