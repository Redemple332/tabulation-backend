<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login')->name('login');


    Route::post('/forgot-password', [AuthController::class, 'setPasswordResetToken'])->name('user.forgot_password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('user.reset_password');

    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('user.logout');
    Route::get('/auth_user', 'authUser')->middleware('auth:sanctum')->name('user.auth_show');
    Route::put('/profile', 'updateProfile')->middleware('auth:sanctum')->name('profile.update');
});
