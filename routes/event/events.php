<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Event\EventController;

Route::controller(EventController::class)->prefix('events')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('events.restore');
    Route::get('/options', 'getOptions')->name('events.option');
});
Route::apiResource('events', EventController::class);
