<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// PUBLIC ROUTES (Tanpa Login)
// =========================================================================
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================================================================
// PROTECTED ROUTES (Wajib Login / Auth)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ANGGOTA (Custom Routes + Resource) ---
    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    Route::resource('anggota', AnggotaController::class);

    // --- BUKU (Custom Routes + Resource) ---
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    Route::resource('buku', BukuController::class);

    // --- TRANSAKSI (Custom Routes + Resource) ---
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');

    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])
    ->name('transaksi.laporan');
    
    Route::get('/transaksi/laporan/pdf', [TransaksiController::class, 'exportPdf'])
    ->name('transaksi.laporan.pdf');

    Route::resource('transaksi', TransaksiController::class);

});

// =========================================================================
// AUTHENTICATION ROUTES (Bawaan Laravel Breeze)
// =========================================================================
require __DIR__.'/auth.php';