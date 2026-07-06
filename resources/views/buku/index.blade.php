@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h1 class="mb-0">
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>

    <div class="d-flex gap-2">

        <a href="{{ route('buku.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i>
            Export CSV
        </a>

        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah Buku
        </a>

    </div>

</div>

{{-- 📊 STATISTIK --}}
<div class="row mb-4">

    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h6>Total Buku</h6>
                <h2>{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h6>Buku Tersedia</h6>
                <h2>{{ $bukuTersedia }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body text-center">
                <h6>Buku Habis</h6>
                <h2>{{ $bukuHabis }}</h2>
            </div>
        </div>
    </div>

</div>

{{-- 🔍 SEARCH + FILTER --}}
<div class="card mb-4">
    <div class="card-body">

        <form action="{{ route('buku.index') }}" method="GET">

            <div class="row g-2">

                <div class="col-md-3">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Cari judul / pengarang / penerbit..."
                           value="{{ request('keyword') }}">
                </div>

                <div class="col-md-2">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="Programming" {{ request('kategori')=='Programming'?'selected':'' }}>Programming</option>
                        <option value="Database" {{ request('kategori')=='Database'?'selected':'' }}>Database</option>
                        <option value="Web Design" {{ request('kategori')=='Web Design'?'selected':'' }}>Web Design</option>
                        <option value="Networking" {{ request('kategori')=='Networking'?'selected':'' }}>Networking</option>
                        <option value="Data Science" {{ request('kategori')=='Data Science'?'selected':'' }}>Data Science</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('tahun')==$i?'selected':'' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
                        <option value="habis" {{ request('status')=='habis'?'selected':'' }}>Habis</option>
                    </select>
                </div>

                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- BULK DELETE FORM --}}
<form action="{{ route('buku.bulk-delete') }}"
      method="POST"
      id="bulk-delete-form">
    @csrf
</form>

<div class="d-flex justify-content-between mb-3">

    <div>
      <button type="submit"
        form="bulk-delete-form"
        class="btn btn-danger"
        id="btn-bulk-delete"
        disabled>
    <i class="bi bi-trash"></i>
    Hapus Terpilih
</button>
    </div>

    <div>
        <input
            type="checkbox"
            id="select-all"
            class="form-check-input">

        <label for="select-all">
            Pilih Semua
        </label>
    </div>

</div>

<div class="row">

    @forelse($bukus as $buku)

        <div class="col-md-4 mb-4">

            <div class="card h-100">
<div class="card-body">

    <div class="form-check mb-2">
        <input
    class="form-check-input buku-checkbox"
    type="checkbox"
    form="bulk-delete-form"
    name="buku_ids[]"
    value="{{ $buku->id }}">
    </div>
                    <h5>{{ $buku->judul }}</h5>
                    <p class="text-muted">{{ $buku->pengarang }}</p>

                    <p>
                        <span class="badge bg-primary">{{ $buku->kategori_name }}</span>
                    </p>

                    <div class="btn-group-vertical d-grid gap-2">

                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i> Detail
                        </a>

                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        {{-- DELETE --}}
                        {{-- Delete Button dengan SweetAlert --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}"
                              method="POST"
                              class="d-grid">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-sm btn-danger w-100 btn-delete"
                                    data-judul="{{ $buku->judul }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
 
                    </div>

                </div>
            </div>

        </div>

    @empty

        <div class="col-12">
            <div class="alert alert-info">
                Tidak ada data buku.
            </div>
        </div>

    @endforelse

</div>

{{-- 📄 INFO --}}
@if($bukus->count() > 0)
    <div class="text-center mt-3">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
        </p>
    </div>
@endif

@push('scripts')
<script>

// =====================
// Select All
// =====================
const selectAll = document.getElementById('select-all');
const checkboxes = document.querySelectorAll('.buku-checkbox');
const bulkBtn = document.getElementById('btn-bulk-delete');

function toggleBulkButton() {
    bulkBtn.disabled =
        document.querySelectorAll('.buku-checkbox:checked').length === 0;
}

if (selectAll) {

    selectAll.addEventListener('change', function () {

        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });

        toggleBulkButton();

    });

}

checkboxes.forEach(cb => {

    cb.addEventListener('change', toggleBulkButton);

});

// =====================
// Bulk Delete
// =====================
document.getElementById('bulk-delete-form')
.addEventListener('submit', function(e){

    e.preventDefault();

    const total =
        document.querySelectorAll('.buku-checkbox:checked').length;

    if(total == 0){

        Swal.fire(
            'Peringatan',
            'Pilih minimal satu buku.',
            'warning'
        );

        return;
    }

    Swal.fire({

        title:'Hapus Buku?',
        text: total+' buku akan dihapus.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Ya',
        cancelButtonText:'Batal'

    }).then((result)=>{

        if(result.isConfirmed){

            this.submit();

        }

    });

});


// =====================
// Delete Satu Buku
// =====================
document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function(e){

        e.preventDefault();

        const form = this.closest('form');
        const judul = this.dataset.judul;

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus buku "' + judul + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result)=>{

            if(result.isConfirmed){
                form.submit();
            }

        });

    });

});

</script>
@endpush

@endsection