<?php

use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RaporPdfController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/pre-school', function () {
    return view('pages.pre-school');
});

// Rapor berisi data pendidikan yang sensitif: wajib login, dan controller
// memeriksa apakah user berhak atas siswa tersebut.
// Semester hanya dikenal sebagai '1' atau '2' (lihat ManageClassRapor/InputSiswaRapor),
// jadi nilai lain langsung 404 dan tidak pernah menyentuh query.
Route::get('/rapor/{siswa}/{semester}/pdf', [RaporPdfController::class, 'download'])
    ->middleware('auth:web,guru')
    ->whereIn('semester', ['1', '2'])
    ->name('rapor.pdf');

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
