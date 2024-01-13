<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Permission\PermissionController;

Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('permissions.restore');
    Route::get('/options', 'getOptions')->name('permissions.option');
});

Route::apiResource('permissions', PermissionController::class);


