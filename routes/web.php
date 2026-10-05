<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('laporan', LaporanController::class);
    Route::post('/laporan/{laporan}/approve', [LaporanController::class, 'approve'])->name('laporan.approve');
    Route::post('/laporan/{laporan}/reject', [LaporanController::class, 'reject'])->name('laporan.reject');

    Route::get('/rekap-bulanan', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap-bulanan/download-pdf', [RekapController::class, 'downloadPdf'])->name('rekap.pdf');
});
