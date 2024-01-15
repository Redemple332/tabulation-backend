<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Score\ScoreController;

Route::controller(ScoreController::class)->prefix('scores')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('scores.restore');
    Route::get('/options', 'getOptions')->name('scores.option');
});
Route::apiResource('scores', ScoreController::class);
