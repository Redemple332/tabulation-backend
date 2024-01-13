<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('users.restore');
    Route::get('/options', 'getOptions')->name('users.option');
});

Route::apiResource('users', UserController::class);

