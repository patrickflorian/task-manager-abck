<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/forgot-password', ForgotPasswordController::class);
    Route::get('/current-time', function () {
       return \Date::now();
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::apiResource('/tasks', \App\Http\Controllers\Api\TaskController::class)->middleware('auth:sanctum');
    });
});
