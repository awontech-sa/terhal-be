<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequests\UpdateProfileRequest;
use App\Http\Resources\UserUpdateResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();

        return $data;
    }

    public function show()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'المستخدم غير مسجل'], 404);
            }

            $userExist = User::find($user->id);
            if (!$userExist) {
                return response()->json(['message' => 'المستخدم غير موجود في النظام'], 404);
            }

            return response()->json(['data' => $userExist], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user->update($validatedData);

        return response()->json(['message' => 'تم تحديث البيانات بنجاح', 'data' => new UserUpdateResource($user)], 200);
    }
}
