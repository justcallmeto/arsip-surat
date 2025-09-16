<?php

use App\Http\Controllers\ArsipSuratController;
use App\Http\Controllers\KategoriSuratController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ArsipSuratController::class, 'index'])->name('home');

Route::resource('arsip-surat', ArsipSuratController::class);
Route::get('arsip-surat/{arsipSurat}/download', [ArsipSuratController::class, 'download'])
     ->name('arsip-surat.download');

Route::resource('kategori-surat', KategoriSuratController::class);

Route::get('/about', function () {
    return view('about');
})->name('about');
