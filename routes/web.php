<?php

use App\Exports\User\UserExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

Route::get('/test-pdf', function () {
    $pdf = Pdf::loadView('pdf.test');
    return $pdf->download('test-pdf.pdf');
});

Route::get('/test-excel-export', function () {
    return Excel::download(new UserExport, 'users.xlsx');
});

Route::get('/test-excel-import', function () {
    return view('welcome');
});
