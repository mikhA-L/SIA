<?php

use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MataKuliahController;
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
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])->name('krs.destroy');
});

Route::middleware(['auth', 'role:admin'])->get('/admin', fn () => view('dashboard.admin'))->name('admin.home');
Route::middleware(['auth', 'role:dosen'])->get('/dosen', fn () => view('dashboard.dosen'))->name('dosen.home');
Route::middleware(['auth', 'role:mahasiswa'])->get('/mahasiswa', fn () => view('dashboard.mahasiswa'))->name('mahasiswa.home');

require __DIR__.'/demo.php';