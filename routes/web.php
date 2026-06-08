<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaporPdfController;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');


Route::get('/pre-school', function () {
    return view('pages.pre-school');
});

Route::get('/rapor/{siswa}/{semester}/pdf', [RaporPdfController::class, 'download'])->name('rapor.pdf');
