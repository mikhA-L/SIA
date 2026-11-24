<?php

use App\Http\Controllers\Admin\KrsController as AdminKrsController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MasaNilaiController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Dosen\NilaiController as DosenNilaiController;
use App\Http\Controllers\Mahasiswa\NilaiController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman awal: arahkan sesuai status login dan peran.
Route::get('/', function () {
    return Auth::check()
        ? redirect(Auth::user()->homePath())
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class)->except('show');
    Route::resource('mata-kuliah', MataKuliahController::class)->except('show');
    Route::resource('dosen', DosenController::class)->except('show');
    Route::get('masa-nilai', [MasaNilaiController::class, 'index'])->name('masa-nilai.index');
    Route::put('masa-nilai', [MasaNilaiController::class, 'update'])->name('masa-nilai.update');
    Route::get('krs', [AdminKrsController::class, 'index'])->name('krs.index');
    Route::get('krs/{pengajuan}', [AdminKrsController::class, 'show'])->name('krs.show');
    Route::put('krs/{pengajuan}', [AdminKrsController::class, 'update'])->name('krs.update');
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/nilai', [DosenNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/{mataKuliah}', [DosenNilaiController::class, 'show'])->name('nilai.show');
    Route::post('/nilai/{mataKuliah}', [DosenNilaiController::class, 'store'])->name('nilai.store');
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])->name('krs.destroy');
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/krs/ajukan', [KrsController::class, 'ajukan'])->name('krs.ajukan');
});

Route::middleware('auth')->group(function () {
    Route::get('/akun/password', [PasswordController::class, 'edit'])->name('akun.password.edit');
    Route::put('/akun/password', [PasswordController::class, 'update'])->name('akun.password.update');
});

Route::middleware(['auth', 'role:admin'])->get('/admin', fn () => view('dashboard.admin'))->name('admin.home');
Route::middleware(['auth', 'role:dosen'])->get('/dosen', fn () => view('dashboard.dosen'))->name('dosen.home');
Route::middleware(['auth', 'role:mahasiswa'])->get('/mahasiswa', fn () => view('dashboard.mahasiswa'))->name('mahasiswa.home');
