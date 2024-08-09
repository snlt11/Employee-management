<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::resource('employees', EmployeeController::class)->middleware('auth:api');
    Route::get('/whoami', [AuthController::class, 'authUser'])->name('AuthUser')->middleware('auth:api');
    Route::post('/register', [AuthController::class, 'register'])->name('UserRegister');
    Route::post('/login', [AuthController::class, 'login'])->name('UserLogin');
});




