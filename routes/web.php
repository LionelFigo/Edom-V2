<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminDosenController;
use App\Http\Controllers\AdminMataKuliahController;
use App\Http\Controllers\AdminPertanyaanController;
use App\Http\Controllers\MahasiswaEvaluasiController;
use App\Http\Controllers\AdminHasilEvaluasiController;
use App\Http\Controllers\DosenEvaluasiController;
use App\Http\Controllers\DosenSaranController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Route Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::prefix('dosen')->name('dosen.')->group(function () {
            Route::get('/', [AdminDosenController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminDosenController::class, 'create'])->name('create');
            Route::post('/', [AdminDosenController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminDosenController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminDosenController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminDosenController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('mata-kuliah')->name('mata_kuliah.')->group(function () {
            Route::get('/', [AdminMataKuliahController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminMataKuliahController::class, 'create'])->name('create');
            Route::post('/', [AdminMataKuliahController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminMataKuliahController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminMataKuliahController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminMataKuliahController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pertanyaan')->name('pertanyaan.')->group(function () {
            Route::get('/', [AdminPertanyaanController::class, 'index'])->name('index');
            Route::get('/tambah', [AdminPertanyaanController::class, 'create'])->name('create');
            Route::post('/', [AdminPertanyaanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminPertanyaanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPertanyaanController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPertanyaanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('hasil-evaluasi')->name('hasil.')->group(function () {
            Route::get('/', [AdminHasilEvaluasiController::class, 'index'])->name('index');
            Route::get('/{dosen_mk_id}', [AdminHasilEvaluasiController::class, 'show'])->name('show');
        });

        });

    // Route Dosen
    Route::middleware(['role:dosen'])->prefix('dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
        
        Route::prefix('dosen/evaluasi')->name('dosen.evaluasi.')->group(function () {
            Route::get('/', [DosenEvaluasiController::class, 'index'])->name('index');
            Route::get('/{dosen_mk_id}', [DosenEvaluasiController::class, 'show'])->name('show');
        });

        Route::get('dosen/saran', [DosenSaranController::class, 'index'])->name('dosen.saran');
    });

    // Route Mahasiswa
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');
        Route::get('/panduan', [MahasiswaController::class, 'panduan'])->name('panduan');

        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/dashboard', [MahasiswaEvaluasiController::class, 'index'])->name('dashboard');
            Route::get('/panduan', function () { return view('mahasiswa.panduan'); })->name('panduan');
            
           
            Route::get('/evaluasi/{dosen_mk_id}', [MahasiswaEvaluasiController::class, 'show'])->name('evaluasi.show');
            Route::post('/evaluasi/{dosen_mk_id}', [MahasiswaEvaluasiController::class, 'store'])->name('evaluasi.store');
        });
    });

    // Route Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
