@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container">

    <h2 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Dashboard Perpustakaan
    </h2>

    {{-- Statistik --}}
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Buku</h6>
                    <h2 class="text-primary">{{ $totalBuku }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Anggota</h6>
                    <h2 class="text-success">{{ $totalAnggota }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-info shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Transaksi</h6>
                    <h2 class="text-info">{{ $totalTransaksi }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body text-center">
                    <h6>Sedang Dipinjam</h6>
                    <h2 class="text-warning">{{ $sedangDipinjam }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-center">
                    <h6>Buku Terlambat</h6>
                    <h2 class="text-danger">{{ $bukuTerlambat }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-secondary shadow-sm">
                <div class="card-body text-center">
                    <h6>Buku Tersedia</h6>
                    <h2 class="text-secondary">{{ $bukuTersedia }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-dark shadow-sm">
                <div class="card-body text-center">
                    <h6>Transaksi Hari Ini</h6>
                    <h2>{{ $transaksiHariIni }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h6>Denda Bulan Ini</h6>
                    <h5 class="text-success">
                        Rp {{ number_format($dendaBulanIni,0,',','.') }}
                    </h5>
                </div>
            </div>
        </div>

    </div>

    {{-- Selamat Datang --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Selamat Datang
        </div>

        <div class="card-body">
            <h5>Halo, {{ Auth::user()->name }} 👋</h5>

            <p class="mb-0">
                Selamat datang di Sistem Informasi Perpustakaan.
                Gunakan menu di samping untuk mengelola Buku, Anggota dan Transaksi.
            </p>
        </div>
    </div>

    {{-- Widget Buku Terlambat --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-danger text-white">
            Buku Terlambat
        </div>

        <div class="card-body">

            @if($transaksiTerlambat->count())

                <ul class="list-group">

                    @foreach($transaksiTerlambat as $item)

                        <li class="list-group-item d-flex justify-content-between">

                            <div>
                                <strong>{{ $item->anggota->nama }}</strong>
                                <br>
                                {{ $item->buku->judul }}
                            </div>

                            <span class="badge bg-danger">
                                {{ $item->tanggal_kembali->diffInDays(now()) }}
                                Hari
                            </span>

                        </li>

                    @endforeach

                </ul>

            @else

                <div class="alert alert-success mb-0">
                    Tidak ada buku yang terlambat.
                </div>

            @endif

        </div>

    </div>

    {{-- Transaksi Terbaru --}}
    <div class="card shadow-sm">

        <div class="card-header bg-info text-white">
            Transaksi Terbaru
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>Kode</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($recentTransaksi as $trx)

                        <tr>

                            <td>{{ $trx->kode_transaksi }}</td>

                            <td>{{ $trx->anggota->nama }}</td>

                            <td>{{ $trx->buku->judul }}</td>

                            <td>{{ $trx->tanggal_pinjam->format('d-m-Y') }}</td>

                            <td>

                                @if($trx->status == 'Dipinjam')

                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">
                                Belum ada transaksi.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection