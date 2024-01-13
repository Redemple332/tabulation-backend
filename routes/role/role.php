<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;


Route::controller(RoleController::class)->prefix('roles')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('roles.restore');
    Route::get('/options', 'getOptions')->name('roles.option');
    // Route::post('/permission', 'setRolePermission')->name('roles.permissions.set');
    Route::put('/permission/{id}', 'updateRolePermission')->name('roles.permissions.update');
});

Route::apiResource('roles', RoleController::class);
