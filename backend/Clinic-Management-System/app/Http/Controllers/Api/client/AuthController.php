<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = $user->createToken('client')->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201,'ثبت‌نام با موفقیت انجام شد');
    }

    // ورود کاربر
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
        $user->tokens()->delete();
        $token = $user->createToken('client')->plainTextToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ],200,'ورود با موفقیت انجام شد');
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
