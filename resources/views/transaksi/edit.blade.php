@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square"></i>
                    Edit Transaksi
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $transaksi->kode_transaksi }}"
                               readonly>
                    </div>

                    {{-- Pilih Anggota --}}
                    <div class="mb-3">
                        <label for="anggota_id" class="form-label">
                            Pilih Anggota <span class="text-danger">*</span>
                        </label>
                        <select name="anggota_id"
                                id="anggota_id"
                                class="form-select @error('anggota_id') is-invalid @enderror">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}"
                                    {{ old('anggota_id', $transaksi->anggota_id) == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->kode_anggota }} - {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Buku --}}
                    <div class="mb-3">
                        <label for="buku_id" class="form-label">
                            Pilih Buku <span class="text-danger">*</span>
                        </label>
                        <select name="buku_id"
                                id="buku_id"
                                class="form-select @error('buku_id') is-invalid @enderror">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}"
                                    {{ old('buku_id', $transaksi->buku_id) == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} - (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Pinjam --}}
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">
                            Tanggal Pinjam <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_pinjam"
                               id="tanggal_pinjam"
                               class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                               value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}">
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Kembali --}}
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">
                            Tanggal Kembali
                        </label>
                        <input type="date"
                               name="tanggal_kembali"
                               id="tanggal_kembali"
                               class="form-control @error('tanggal_kembali') is-invalid @enderror"
                               value="{{ old('tanggal_kembali', $transaksi->tanggal_kembali->format('Y-m-d')) }}"
                               min="{{ $transaksi->tanggal_pinjam->format('Y-m-d') }}">
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Ubah tanggal kembali jika diperlukan.</small>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan"
                                  id="keterangan"
                                  rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info Status --}}
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Status saat ini:</strong>
                        {{ $transaksi->status }}
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
