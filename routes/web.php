<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth.custom')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard')
        ->middleware('admin');
        
    Route::get('/warga/dashboard', [DashboardController::class, 'warga'])
        ->name('warga.dashboard')
        ->middleware('warga');
        
    Route::get('/laporan/counts', [DashboardController::class, 'getLaporanCounts']);
    Route::get('/laporan/{id}', [LaporanController::class, 'show']);
    Route::get('/laporan/filter/{status}', [LaporanController::class, 'filter']);
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::post('/laporan/{id}/status', [LaporanController::class, 'updateStatus'])
        ->name('laporan.updateStatus')
        ->middleware('admin');
});
