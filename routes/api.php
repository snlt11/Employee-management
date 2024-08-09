<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/auth-user',[AuthController::class,'authUser'])->name('AuthUser');
    Route::get('/logout',[AuthController::class,'logout'])->name('UserLogout');
});

Route::post('/register',[AuthController::class,'register'])->name('UserRegister');
Route::post('/login',[AuthController::class,'login'])->name('UserLogin');
