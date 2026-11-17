<?php

use App\Http\Controllers\Auth\LoginController;
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
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman per peran (isi akan bertambah seiring sprint).
Route::middleware(['auth', 'role:admin'])->get('/admin', fn () => view('dashboard.admin'))->name('admin.home');
Route::middleware(['auth', 'role:dosen'])->get('/dosen', fn () => view('dashboard.dosen'))->name('dosen.home');
Route::middleware(['auth', 'role:mahasiswa'])->get('/mahasiswa', fn () => view('dashboard.mahasiswa'))->name('mahasiswa.home');
