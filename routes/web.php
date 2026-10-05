<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // ganti dengan view beranda Anda
})->name('beranda');

Route::view('/testimoni', 'testimoni')->name('testimoni');
Route::view('/berita', 'berita')->name('berita');
Route::view('/mitra', 'mitra')->name('mitra');