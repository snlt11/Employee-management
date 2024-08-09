<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  Hash::make($request->password),
            ]);
            if(!$user) {
                return ResponseHelper::errorResponse(
                    message: 'Failed to register user',
                );
            }
            $accessToken = $user->createToken('authToken')->accessToken;
            return ResponseHelper::successResponse(
                message: 'User registered successfully',
                data: [
                    'user' => $user,
                    'token' => 'Bearer '.$accessToken,
                ],
                statusCode: 201,
            );
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelper::errorResponse(
                message: 'An error occurred while registering the user',
                statusCode: 500,
            );
        }

    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $attempt = auth()->attempt($credentials);
            if (!$attempt) {
                return ResponseHelper::errorResponse(
                    message: 'Invalid credentials',
                    statusCode: 401,
                );
            }
            $user = auth()->user();
            $accessToken = $user->createToken('authToken')->accessToken;
            return ResponseHelper::successResponse(
                message: 'User logged in successfully',
                data: [
                    'user' => $user,
                    'token' => 'Bearer '.$accessToken,
                ],
                statusCode: 200,
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelper::errorResponse(
                message: 'An error occurred while logging in the user',
                statusCode: 500,
            );
        }
    }

    public function authUser(Request $request): JsonResponse
    {
        if(!auth()->user()){
            return ResponseHelper::errorResponse(
                message: 'User not authenticated',
                statusCode: 401,
            );
        }
        return ResponseHelper::successResponse(
            message: 'User details',
            data: auth()->user(),
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return ResponseHelper::successResponse(
            message: 'User logged out successfully',
        );
    }

}
