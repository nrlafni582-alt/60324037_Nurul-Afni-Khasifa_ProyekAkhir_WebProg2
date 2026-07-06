@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')

<div class="container">

    <h2 class="mb-4">
        <i class="bi bi-file-earmark-text"></i>
        Laporan Transaksi
    </h2>

    <a href="{{ route('transaksi.laporan.pdf') }}"
   class="btn btn-danger mb-3">

    <i class="bi bi-file-earmark-pdf"></i>

    Export PDF

</a>

    <form method="GET" action="{{ route('transaksi.laporan') }}">

        <div class="row mb-3">

            <div class="col-md-3">
                <label>Dari</label>
                <input type="date"
                       name="dari"
                       class="form-control"
                       value="{{ request('dari') }}">
            </div>

            <div class="col-md-3">
                <label>Sampai</label>
                <input type="date"
                       name="sampai"
                       class="form-control"
                       value="{{ request('sampai') }}">
            </div>

            <div class="col-md-3">
                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="Semua">Semua</option>

                    <option value="Dipinjam"
                        {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>
                        Dipinjam
                    </option>

                    <option value="Dikembalikan"
                        {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                        Dikembalikan
                    </option>

                </select>

            </div>

            <div class="col-md-3">

                <label>Anggota</label>

                <select name="anggota_id" class="form-control">

                    <option value="">Semua Anggota</option>

                    @foreach($anggotas as $anggota)

                        <option value="{{ $anggota->id }}"
                            {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>

                            {{ $anggota->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <button class="btn btn-primary">
            <i class="bi bi-search"></i>
            Filter
        </button>

    </form>

    <hr>

    <div class="row mb-3">

        <div class="col-md-6">

            <div class="alert alert-primary">

                <strong>Total Transaksi :</strong>

                {{ $transaksis->count() }}

            </div>

        </div>

        <div class="col-md-6">

            <div class="alert alert-success">

                <strong>Total Denda :</strong>

                Rp {{ number_format($totalDenda,0,',','.') }}

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">

                        <tr>

                            <th>No</th>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Denda</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transaksis as $transaksi)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $transaksi->kode_transaksi }}</td>

                            <td>{{ $transaksi->anggota->nama }}</td>

                            <td>{{ $transaksi->buku->judul }}</td>

                            <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>

                            <td>

                                @if($transaksi->status == 'Dipinjam')

                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>

                                @endif

                            </td>

                            <td>

                                Rp {{ number_format($transaksi->denda,0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                Tidak ada data transaksi

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection