<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    // Redirect root ke login jika belum login
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk membuat user default (hapus setelah selesai development)
Route::get('/create-users', [AuthController::class, 'createDefaultUsers']);

// Protected Routes (Perlu Login)
Route::middleware(['auth'])->group(function () {
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Redirect root ke dashboard jika sudah login
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Routes untuk Admin dan Staff
    Route::middleware(['role:admin,staff'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Obat Routes
        Route::resource('obat', ObatController::class);
        Route::get('/obat-data/{id}', [ObatController::class, 'getObatData'])->name('obat.data');

        // Transaksi Routes (kecuali delete)
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

        // Export Routes
        Route::get('/transaksi/export-pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.export.pdf');
        Route::get('/transaksi/export-excel', [TransaksiController::class, 'exportExcel'])->name('transaksi.export.excel');
    });

    // Routes khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        
        // Kategori Routes - Hanya Admin yang bisa kelola kategori
        Route::resource('kategori', KategoriController::class);
        
        // Hapus transaksi - Hanya Admin
        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });
});