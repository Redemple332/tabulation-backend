<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Score\ScoreController;

Route::controller(ScoreController::class)->prefix('scores')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('scores.restore');
    Route::get('/options', 'getOptions')->name('scores.option');
    Route::post('/submit-score-judge', 'submitScoreJudge')->name('scores.submitScoreJudge');
});
Route::apiResource('scores', ScoreController::class);
