<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryController;


Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/restore/{id}', 'restore')->name('categories.restore');
    Route::get('/options', 'getOptions')->name('categories.option');
    Route::get('/scores', 'scores')->name('categories.scores');
    Route::get('/export', 'export')->name('categories.export');
});
Route::apiResource('categories', CategoryController::class);