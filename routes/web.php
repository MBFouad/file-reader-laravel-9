<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'reset' => false]);

Route::middleware('auth.custom')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('file/reader', [App\Http\Controllers\FileController::class, 'reader'])->name('file.reader');
});

