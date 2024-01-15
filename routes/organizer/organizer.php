<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organizer\OrganizerController;

Route::controller(OrganizerController::class)->prefix('organizers')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('organizers.restore');
    Route::get('/options', 'getOptions')->name('organizers.option');
});
Route::apiResource('organizers', OrganizerController::class);
