@extends('layouts.app')

@section('content')

<h2>

Hasil pencarian :
<span class="text-danger">

{{ $keyword }}

</span>

</h2>

@if($kategori_list->count())

<div class="row">

@foreach($kategori_list as $kategori)

<div class="col-md-4 mb-3">

<div class="card">

<div class="card-body">

<h4>

{!! str_ireplace($keyword,
"<mark>$keyword</mark>",
$kategori['nama']) !!}

</h4>

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

@else

<div class="alert alert-danger">

Kategori tidak ditemukan.

</div>

@endif

@endsection