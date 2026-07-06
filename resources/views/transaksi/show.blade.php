@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<div class="container">

    <h2 class="mb-4">
        <i class="bi bi-file-text"></i>
        Detail Transaksi
    </h2>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Informasi Transaksi</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="250">Kode Transaksi</th>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>

                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $transaksi->anggota->nama }}</td>
                </tr>

                <tr>
                    <th>Judul Buku</th>
                    <td>{{ $transaksi->buku->judul }}</td>
                </tr>

                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Kembali</th>
                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                </tr>

                <tr>
                    <th>Tanggal Dikembalikan</th>
                    <td>
                        {{ $transaksi->tanggal_dikembalikan
                            ? $transaksi->tanggal_dikembalikan->format('d M Y')
                            : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($transaksi->status == 'Dipinjam')
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        @else
                            <span class="badge bg-success">Dikembalikan</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Denda</th>
                    <td>
                        <strong class="text-danger">
                            Rp {{ number_format($transaksi->denda,0,',','.') }}
                        </strong>
                    </td>
                </tr>

            </table>

            {{-- Reminder Terlambat --}}
            @if($transaksi->status == 'Dipinjam' && now()->gt($transaksi->tanggal_kembali))

                <div class="alert alert-danger">

                    <strong>Perhatian!</strong>

                    Buku ini sudah terlambat dikembalikan selama

                    <b>{{ $transaksi->tanggal_kembali->diffInDays(now()) }} hari</b>

                </div>

            @endif

            {{-- Informasi Setelah Dikembalikan --}}
            @if($transaksi->status == 'Dikembalikan')

                @if($transaksi->denda > 0)

                    <div class="alert alert-warning">

                        <i class="bi bi-exclamation-triangle"></i>

                        Buku terlambat dikembalikan.

                        <br>

                        Total Denda :
                        <strong>
                            Rp {{ number_format($transaksi->denda,0,',','.') }}
                        </strong>

                    </div>

                @else

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle"></i>

                        Buku berhasil dikembalikan tepat waktu.

                    </div>

                @endif

            @endif

            {{-- Tombol --}}
            <div class="mt-4 d-flex gap-2">

                <a href="{{ route('transaksi.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

                @if($transaksi->status == 'Dipinjam')

                    <a href="{{ route('transaksi.edit',$transaksi->id) }}"
                       class="btn btn-warning">

                        <i class="bi bi-pencil-square"></i>

                        Edit

                    </a>

                    <button
                        type="button"
                        class="btn btn-success"
                        id="btn-kembalikan">

                        <i class="bi bi-arrow-return-left"></i>

                        Kembalikan Buku

                    </button>

                    <form
                        id="form-kembalikan"
                        action="{{ route('transaksi.kembalikan',$transaksi->id) }}"
                        method="POST"
                        class="d-none">

                        @csrf
                        @method('PUT')

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.getElementById('btn-kembalikan')?.addEventListener('click', function () {

    Swal.fire({

        title: 'Konfirmasi Pengembalian',

        text: 'Apakah yakin ingin mengembalikan buku ini?',

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Ya',

        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            document.getElementById('form-kembalikan').submit();

        }

    });

});

</script>

@endpush