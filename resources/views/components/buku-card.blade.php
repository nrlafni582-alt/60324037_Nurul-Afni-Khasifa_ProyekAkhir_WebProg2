<div class="card shadow-sm h-100">

    <div class="card-body">

        <div class="text-center mb-3">

            <i class="bi bi-book text-primary" style="font-size:70px;"></i>

        </div>

        <h5 class="card-title">{{ $buku->judul }}</h5>

        <p>
            <i class="bi bi-person"></i>
            {{ $buku->pengarang }}
        </p>

        <p>
            <i class="bi bi-building"></i>
            {{ $buku->penerbit }}
        </p>

        <p class="fw-bold text-primary">
            {{ $buku->harga_format }}
        </p>

        <p>
            Stok :
            <strong>{{ $buku->stok }}</strong>
        </p>

        <span class="badge bg-primary">
            {{ $buku->kategori_name }}
        </span>

        <hr>

        @if($buku->stok > 0)

            <span class="badge bg-success">
                Tersedia
            </span>

        @else

            <span class="badge bg-danger">
                Habis
            </span>

        @endif

    </div>

    @if($showActions)

<div class="card-footer">

    <div class="btn-group-vertical d-grid gap-2">

        <a href="{{ route('buku.show', $buku->id) }}"
           class="btn btn-sm btn-info text-white">
            <i class="bi bi-eye"></i> Detail
        </a>

        <a href="{{ route('buku.edit', $buku->id) }}"
           class="btn btn-sm btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>

        <form action="{{ route('buku.destroy', $buku->id) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku {{ $buku->judul }}?')">

            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-sm btn-danger w-100">
                <i class="bi bi-trash"></i> Hapus
            </button>

        </form>

    </div>

</div>

@endif