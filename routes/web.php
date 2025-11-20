<?php

use App\Exports\User\UserExport;
use App\Http\Controllers\Category\CategoryController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Score\ScoreController;
use App\Exports\Score\ScoreReportExport;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    if (file_exists(public_path() . '/index.php')) {
        return "Backend service last update was on " . date('Y-m-d H:i:s', filectime(public_path() . '/index.php'));
    }
    return "Backend service works!!";
});

Route::get('/test-pdf', function () {
    $pdf = Pdf::loadView('pdf.test');
    return $pdf->download('test-pdf.pdf');
});

Route::get('/test-excel-export', function () {
    // return Excel::download(new ScoreReportExport, 'score_report.xlsx');
    return Excel::download(new UserExport, 'users.xlsx');
});

Route::get('/test-excel-import', function () {
    return view('welcome');
});


Route::controller(ScoreController::class)->prefix('scores')->group(function () {
    Route::get('/over-all', 'overAllExport')->name('scores.over-all.export');

});
