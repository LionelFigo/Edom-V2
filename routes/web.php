<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route dengan proteksi Auth
Route::middleware(['auth', 'verified'])->group(function () {

    // 2. Route Admin (Hanya bisa diakses user dengan role admin)
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Tambahkan route admin lainnya di sini
    });

    // 3. Route Dosen (Hanya bisa diakses user dengan role dosen)
    Route::middleware(['role:dosen'])->prefix('dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
        // Tambahkan route dosen lainnya di sini
    });

    // 4. Route Mahasiswa (Hanya bisa diakses user dengan role mahasiswa)
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');
        // Tambahkan route mahasiswa lainnya di sini
    });

    // 5. Route Profil (Bisa diakses semua role yang sudah login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
