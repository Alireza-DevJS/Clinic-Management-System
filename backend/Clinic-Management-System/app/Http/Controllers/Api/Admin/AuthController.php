<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
       $data = $request->validated();

$user = User::where('email', $data['email'])->first();

if (!$user || !Hash::check($data['password'], $user->password)) {
    return $this->errorResponse(
        'ایمیل یا رمز عبور اشتباه است.',
        401
    );
}

if (!$user->isAdmin()) {
    return $this->errorResponse(
        'شما اجازه دسترسی به پنل مدیریت را ندارید.',
        403
    );
}

$user->tokens()->delete();

$token = $user->createToken('admin-panel')->plainTextToken;
        return $this->successResponse([
            'user'  => new UserResource($user),
            'token' => $token,
        ], 200, 'خوش آمدید! ورود با موفقیت انجام شد.');
    }

    public function logout()
    {
         auth()->user()->currentAccessToken()->delete();

        return $this->successResponse(
            null,
            200,
            'خروج با موفقیت انجام شد.'
        );
    }
}
