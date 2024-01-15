<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sponsor\SponsorController;

Route::controller(SponsorController::class)->prefix('sponsors')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('sponsors.restore');
    Route::get('/options', 'getOptions')->name('sponsors.option');
});
Route::apiResource('sponsors', SponsorController::class);
