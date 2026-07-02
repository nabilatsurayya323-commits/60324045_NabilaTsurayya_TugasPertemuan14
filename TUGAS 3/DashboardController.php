<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Buku
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // Statistik Anggota
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'nonaktif')->count();

        // Data Terbaru
        $bukuTerbaru = Buku::latest()->take(5)->get();
        $anggotaTerbaru = Anggota::latest()->take(5)->get();

        // Data Buku Terlambat
        $today = Carbon::today();

        $transaksiTerlambat = Transaksi::with(['anggota', 'buku'])
        ->where('status', 'Dipinjam')
        ->whereDate('tanggal_kembali', '<', $today)
        ->get();

        $jumlahTerlambat = $transaksiTerlambat->count();

        return view('dashboard', compact(
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif',
            'bukuTerbaru',
            'anggotaTerbaru',
            'transaksiTerlambat',
            'jumlahTerlambat'
        ));
    }
}