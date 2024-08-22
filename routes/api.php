<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::get('/whoami', [AuthController::class, 'authUser'])->name('AuthUser');
    Route::resource('employees', EmployeeController::class);
});
Route::post('/login', [AuthController::class, 'login'])->name('UserLogin');
Route::post('/register', [AuthController::class, 'register'])->name('UserRegister');
