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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kabupaten', KabupatenController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('kecamatan', KecamatanController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('desa', DesaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('wilayah', DataWilayahController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('usaha', UsahaEsdmController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('mineral', MineralController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('energi', EnergiController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('pengawasan', PengawasanController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('pad', PotensiPadController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    });
});
