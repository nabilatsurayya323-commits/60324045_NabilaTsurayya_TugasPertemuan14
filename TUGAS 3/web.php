<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
 
// Public routes (tanpa auth)
Route::get('/', function () {
    return redirect()->route('login');
});
 
// Protected routes (dengan auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // route lainnya...
});
 
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    Route::get('/buku/export', [BukuController::class, 'export'])
    ->name('buku.export');

    // Buku - Custom Routes
    Route::get('/buku/export', [BukuController::class, 'export'])
        ->name('buku.export');

    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
        ->name('buku.kategori');

    Route::get('/buku/search', [BukuController::class, 'search'])
        ->name('buku.search');

    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
        ->name('buku.bulk-delete');

    // Buku - CRUD
    Route::resource('buku', BukuController::class);
 
    // Anggota - CRUD
    // Anggota - Custom Routes
    Route::get('/anggota/export', [AnggotaController::class, 'export'])
    ->name('anggota.export');
    
    Route::get('/anggota/search', [AnggotaController::class, 'search'])
    ->name('anggota.search');
    Route::resource('anggota', AnggotaController::class);

    // Laporan Transaksi
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])
        ->name('transaksi.laporan');

    Route::get('/transaksi/laporan/pdf', [TransaksiController::class, 'exportPdf'])
        ->name('transaksi.laporan.pdf');
 
    // Transaksi - CRUD + Custom routes
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');

});
 
require __DIR__.'/auth.php';