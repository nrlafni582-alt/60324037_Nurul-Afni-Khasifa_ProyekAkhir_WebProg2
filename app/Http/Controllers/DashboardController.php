<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // ===========================
        // Statistik Buku
        // ===========================
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        // ===========================
        // Statistik Anggota
        // ===========================
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'nonaktif')->count();

        // ===========================
        // Statistik Transaksi
        // ===========================
        $totalTransaksi = Transaksi::count();

        $sedangDipinjam = Transaksi::where('status', 'Dipinjam')
                                    ->count();

        $bukuTerlambat = Transaksi::where('status', 'Dipinjam')
                                    ->where('tanggal_kembali', '<', now())
                                    ->count();

        $dendaBulanIni = Transaksi::whereMonth('tanggal_dikembalikan', now()->month)
                                    ->sum('denda');

        $transaksiHariIni = Transaksi::whereDate('tanggal_pinjam', today())
                                        ->count();

        // ===========================
        // Data Terbaru
        // ===========================
        $bukuTerbaru = Buku::latest()
                            ->take(5)
                            ->get();

        $anggotaTerbaru = Anggota::latest()
                                    ->take(5)
                                    ->get();

        $recentTransaksi = Transaksi::with(['anggota', 'buku'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // ===========================
        // Buku Terlambat
        // ===========================
        $transaksiTerlambat = Transaksi::with(['anggota', 'buku'])
                                        ->where('status', 'Dipinjam')
                                        ->where('tanggal_kembali', '<', now())
                                        ->get();

        return view('dashboard', compact(
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',

            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif',

            'totalTransaksi',
            'sedangDipinjam',
            'bukuTerlambat',
            'dendaBulanIni',
            'transaksiHariIni',

            'bukuTerbaru',
            'anggotaTerbaru',
            'recentTransaksi',
            'transaksiTerlambat'
        ));
    }
}