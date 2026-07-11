<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaporPdfController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BankSoalController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');


Route::get('/pre-school', function () {
    return view('pages.pre-school');
});

Route::get('/rapor/{siswa}/{semester}/pdf', [RaporPdfController::class, 'download'])->name('rapor.pdf');

Route::post('/admin/tour/complete', [TourController::class, 'complete'])
    ->middleware('auth')
    ->name('tour.complete');

// ── Bank Soal ──────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/bank-soal/template', [BankSoalController::class, 'downloadTemplate'])
        ->name('bank-soal.template');

    Route::get('/bank-soal/paket/{paket}/pdf', [BankSoalController::class, 'cetakSoal'])
        ->name('bank-soal.paket.pdf');

    Route::get('/bank-soal/paket/{paket}/kunci', [BankSoalController::class, 'cetakKunci'])
        ->name('bank-soal.paket.kunci');
});

