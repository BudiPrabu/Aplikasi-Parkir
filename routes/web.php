<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\LogController;

// Route Login
Route::get('/', function () { return view('auth.login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('user', UserController::class);
    Route::resource('tarif', TarifController::class);
    Route::resource('area', AreaParkirController::class);
    Route::resource('kendaraan', KendaraanController::class);
    Route::resource('log-aktivitas', LogController::class);
    Route::get('/admin/log-aktivitas', [LogController::class, 'index'])->name('log-aktivitas.index');
});

// Role khusus petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [TransaksiController::class, 'dashboard'])->name('petugas.dashboard');
    Route::post('/petugas/masuk', [TransaksiController::class, 'storeMasuk'])->name('transaksi.store_masuk');
    Route::get('/petugas/keluar', [TransaksiController::class, 'indexKeluar'])->name('transaksi.keluar');
    Route::post('/petugas/cari', [TransaksiController::class, 'cariKendaraan'])->name('transaksi.cari');
    Route::get('/petugas/bayar/{id}', [TransaksiController::class, 'halamanBayar'])->name('transaksi.halaman_bayar');
    Route::put('/petugas/bayar/{id}', [TransaksiController::class, 'simpanKeluar'])->name('transaksi.simpan_keluar');
    Route::get('/petugas/struk/{id}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.struk');
});

// Role khusus owner
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
});