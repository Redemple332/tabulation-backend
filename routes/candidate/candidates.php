<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Candidate\CandidateController;


Route::controller(CandidateController::class)->prefix('catecandidatesgories')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('candidates.restore');
    Route::get('/options', 'getOptions')->name('candidates.option');
});
Route::apiResource('candidates', CandidateController::class);
