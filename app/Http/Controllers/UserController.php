<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
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

            return response()->json(['message' => 'تم جلب بيانات المستخدم بنجاح', 'data' => $userExist], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();

        $userExist = User::find($user->id);

        if (!$userExist) {
            return response()->json(['message' => 'المستخدم غير مسجل'], 404);
        }

        $userExist->update($validatedData);
        $userExist->save();

        return response()->json(['message' => 'تم تحديث البيانات بنجاح', 'data' => $user], 200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $userExist = User::find($user->id);
        if (! $userExist) {
            return response()->json(['message' => 'المستخدم غير مسجل'], 404);
        }

        if (!Hash::check($request->old_password, $$userExist->password)) {
            return response()->json(['message' => 'كلمة المرور القديمة غير صحيحة'], 422);
        }

        if ($request->old_password === $request->new_password) {
            return response()->json(['message' => 'كلمة المرور الجديدة يجب أن تكون مختلفة عن القديمة'], 422);
        }

        $userExist->password = Hash::make($request->new_password);
        $userExist->save();

        return response()->json(['message' => 'تم تحديث كلمة المرور بنجاح'], 200);
    }
}
