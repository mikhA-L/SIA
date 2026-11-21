<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MataKuliahController;

Route::get('/', function () {
    return redirect()->route('mata-kuliah.index');
});

Route::resource('mata-kuliah', MataKuliahController::class);