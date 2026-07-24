<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\DataWilayahController;
use App\Http\Controllers\UsahaEsdmController;
use App\Http\Controllers\MineralController;
use App\Http\Controllers\EnergiController;
use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\PotensiPadController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Logout (auth required)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul 3: Data Wilayah
    Route::resource('kabupaten', KabupatenController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::resource('desa', DesaController::class);
    Route::resource('wilayah', DataWilayahController::class);

    // Modul 4: Data Usaha ESDM
    Route::resource('usaha', UsahaEsdmController::class);

    // Modul 5: Data Mineral dan Pertambangan
    Route::resource('mineral', MineralController::class);

    // Modul 6: Data Energi dan Ketenagalistrikan
    Route::resource('energi', EnergiController::class);

    // Modul 7: Pengawasan
    Route::resource('pengawasan', PengawasanController::class);

    // Modul 8: Potensi PAD
    Route::resource('pad', PotensiPadController::class);

    // Modul 9: Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Modul 10: Manajemen Pengguna
    Route::resource('users', UserController::class);
});
