<?php

use App\Enums\MouStatus;
use App\Enums\RekrutmenStatus;
use App\Http\Controllers\ProfileController;
use App\Models\Mou;
use App\Models\Perusahaan;
use App\Models\ProgramKerjasama;
use App\Models\Rekrutmen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('beranda');

Route::view('/testimoni', 'testimoni')->name('testimoni');
Route::view('/berita', 'berita')->name('berita');
Route::view('/mitra', 'mitra')->name('mitra');

Route::get('/dashboard', function () {
    $user = Auth::user();

    $stats = $user->isAdmin() || $user->isStaff() ? [
        ['label' => 'Perusahaan Mitra', 'value' => Perusahaan::count(), 'icon' => 'fa-solid fa-building', 'color' => 'bg-primary/10 text-primary'],
        ['label' => 'MoU Aktif', 'value' => Mou::where('status', MouStatus::Active)->count(), 'icon' => 'fa-solid fa-file-signature', 'color' => 'bg-emerald-100 text-emerald-600'],
        ['label' => 'Program Kerjasama', 'value' => ProgramKerjasama::count(), 'icon' => 'fa-solid fa-gears', 'color' => 'bg-accent/15 text-accent-dark'],
        ['label' => 'Rekrutmen Terbuka', 'value' => Rekrutmen::where('status', RekrutmenStatus::Open)->count(), 'icon' => 'fa-solid fa-briefcase', 'color' => 'bg-indigo-100 text-indigo-600'],
    ] : [];

    return view('dashboard', ['stats' => $stats]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/pengguna', function () {
        return view('pengguna');
    })->name('pengguna.index');
});

require __DIR__.'/auth.php';
