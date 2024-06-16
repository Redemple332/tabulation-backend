<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Score\ScoreController;

Route::controller(ScoreController::class)->prefix('scores')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('scores.restore');
    Route::get('/options', 'getOptions')->name('scores.option');
    Route::post('/submit-score-judge', 'submitScoreJudge')->name('scores.submitScoreJudge');
    Route::get('/category', 'scoreByCategory')->name('scores.category');
    Route::get('/category', 'scoreByCategory')->name('scores.category');
    Route::get('/over-all', 'overAll')->name('scores.over-all');

});
Route::apiResource('scores', ScoreController::class);
