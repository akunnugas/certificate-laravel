<?php

use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

Route::controller(CertificateController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/view-certificate', 'viewCertificate')->name('viewCertificate');
    Route::get('/download-certificate', 'downloadCertificate')->name('downloadCertificate');
});