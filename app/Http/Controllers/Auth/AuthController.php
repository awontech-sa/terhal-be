<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Resources\AuthResources\LoginResource;
use App\Http\Resources\AuthResources\LogoutResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    // Inject AuthService and apply middleware
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('permission:log out', ['only' => ['logout']]);
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|max:15'
        ]);

        $result = $this->authService->sendPhoneOtp($data['phone']);
        return response()->json(['data' => $result], 200);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $result = $this->authService->register($data);
        return response()->json(['message' => $result], 201);
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

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $result = $this->authService->login($data);

        if (isset($result['message'])) {
            return response()->json(['message' => $result['message']], 401);
        }
        return new LoginResource((object) $result);
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout($request->user());
        return new LogoutResource((object) $result);
    }

    public function validateToken()
    {
        $this->authService->validateToken();
    }
}
