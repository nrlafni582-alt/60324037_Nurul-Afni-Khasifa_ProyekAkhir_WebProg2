@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">

<ol class="breadcrumb">

<li class="breadcrumb-item">
<a href="{{ route('kategori.index') }}">
Kategori
</a>
</li>

<li class="breadcrumb-item active">
{{ $kategori['nama'] }}
</li>

</ol>

</nav>

<div class="card mb-4">

<div class="card-header bg-primary text-white">

{{ $kategori['nama'] }}

</div>

<div class="card-body">

<p>{{ $kategori['deskripsi'] }}</p>

<p>Jumlah Buku : {{ $kategori['jumlah_buku'] }}</p>

</div>

</div>

<h4>Daftar Buku</h4>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>No</th>

<th>Judul</th>

<th>Penulis</th>

<th>Tahun</th>

</tr>

</thead>

<tbody>

@foreach($buku_list as $buku)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $buku['judul'] }}</td>

<td>{{ $buku['penulis'] }}</td>

<td>{{ $buku['tahun'] }}</td>

</tr>

@endforeach

</tbody>

</table>

@endsection