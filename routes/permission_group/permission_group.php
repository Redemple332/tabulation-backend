<?php

use App\Http\Controllers\Permission\PermissionGroupController;
use Illuminate\Support\Facades\Route;

Route::apiResource('permission-groups', PermissionGroupController::class);

Route::controller(PermissionGroupController::class)->prefix('permission-groups')->group(function() {
    Route::get('/restore/{id}', 'restore')->name('permission-groups.restore');
});