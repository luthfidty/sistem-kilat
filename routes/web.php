<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;

// 1. Jika user mengakses halaman awal (http://127.0.0.1:8000/), lempar ke /login
Route::get('/', function () {return redirect('/login');});

// 2. Route untuk pengunjung yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [SesiController::class, 'showLogin'])->name('login');
    Route::post('/proses-login', [SesiController::class, 'prosesLogin'])->name('login.post');
    
    Route::get('/register', [SesiController::class, 'getRegister'])->name('register');
    Route::post('/register', [SesiController::class, 'register']);
});

// 3. Route untuk pengguna yang SUDAH login
Route::middleware('auth')->group(function () {
    
    // Halaman Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // Sesuaikan dengan nama file blade dashboard Anda
    });

    Route::get('/tim-pemeriksa', [AdminController::class, 'dashboardTimPemeriksa'])->name('anggaran.tim-pemeriksa');
    Route::post('/tim-pemeriksa/simpan',[AdminController::class,'storeTimPemeriksa'])->name('storeTimPemeriksa');

    // Tombol logout
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
    
    // CRUD Manajemen Akun
    Route::resource('manajemen-akun', AdminController::class)->except(['create', 'show', 'edit']);

    // ==========================================
    // RUTE PPK TRANS (DILINDUNGI MIDDLEWARE)
    // ==========================================
    Route::middleware(['modul:PPK'])->prefix('ppk-trans')->group(function () {
        // Halaman Dashboard PPK (Rute Baru)
        Route::get('/dashboard', [AdminController::class, 'dashboardPpk'])->name('ppktrans.dashboard');

        // Halaman Matriks Utama
        Route::get('/input-matriks', [AdminController::class, 'inputMatriks'])->name('ppktrans.input');
        
        // Halaman Detail per Satker
        Route::get('/detail', [AdminController::class, 'detailPpk'])->name('ppktrans.detail');
        
        // Halaman Rekapitulasi Baru (Mingguan/Bulanan)
        Route::get('/rekap', [AdminController::class, 'rekapPpk'])->name('ppktrans.rekap');
    });

    // ==========================================
    // RUTE PEMT (DILINDUNGI MIDDLEWARE)
    // ==========================================
    Route::middleware(['modul:PEMT'])->prefix('pemt')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboardPemt'])->name('pemt.dashboard');
        Route::get('/input-matriks', [AdminController::class, 'inputMatriksPemt'])->name('pemt.input');
        Route::get('/detail', [AdminController::class, 'detailPemt'])->name('pemt.detail');
        Route::get('/rekap', [AdminController::class, 'rekapPemt'])->name('pemt.rekap');
    });
});