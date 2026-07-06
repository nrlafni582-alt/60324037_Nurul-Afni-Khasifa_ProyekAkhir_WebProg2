@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tags"></i> Kategori</h1>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>

@if($kategoris->count())
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr><th>No</th><th>Nama</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kat->nama }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $kat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-nama="{{ $kat->nama }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="alert alert-info">Belum ada kategori.</div>
@endif

@push('scripts')
<script>
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(){
        const form = this.closest('form');
        const nama = this.dataset.nama;
        if(confirm('Hapus kategori "'+nama+'"?')) form.submit();
    });
});
</script>
@endpush

@endsection
@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Daftar Kategori Buku
</h2>

<div class="row">

@foreach($kategori_list as $kategori)

<div class="col-md-4 mb-3">

<div class="card h-100">

<div class="card-body">

<h4>{{ $kategori['nama'] }}</h4>

<p>{{ $kategori['deskripsi'] }}</p>

<p>
Jumlah Buku :
<span class="badge bg-success">
{{ $kategori['jumlah_buku'] }}
</span>
</p>

<a href="{{ route('kategori.show',$kategori['id']) }}"
class="btn btn-primary">
Detail
</a>

</div>

</div>

</div>

@endforeach

</div>

@endsection