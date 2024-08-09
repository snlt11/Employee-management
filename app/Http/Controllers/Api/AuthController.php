<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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
            if (!$user) {
                return response()->json(['error' => 'Failed to register user'], 500);
            }
            $accessToken = "Bearer " . $user->createToken('authToken')->accessToken;
            return response()->json([
                "message" => 'User registered successfully',
                "data" => [
                    'user' => $user,
                    'token' => $accessToken,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $attempt = auth()->attempt($credentials);
            if (!$attempt) {
                return response()->json([
                    "message" => 'Invalid credentials',
                ], 401);
            }
            $user = auth()->user();
            $accessToken = "Bearer " . $user->createToken('authToken')->accessToken;

            return response()->json([
                "message" => 'User logged in successfully',
                "data" => [
                    'user' => $user,
                    'token' => $accessToken,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function authUser(): JsonResponse
    {
        $currentUser = auth()->user();
        if (!$currentUser) {
            return response()->json([
                "message" => 'User not authenticated',
            ], 401);
        }
        return response()->json([
            "message" => "Current user retrieved successfully",
            "data" => auth()->user(),
        ], 200);
    }
}
