<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;

class BukuController extends Controller
{
    /**
     * Display listing buku + search + filter
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        // 🔍 SEARCH
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->keyword . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->keyword . '%');
            });
        }

        // 📚 FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 📅 FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // 📦 FILTER STATUS
        if ($request->filled('status')) {
            if ($request->status == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->status == 'habis') {
                $query->where('stok', 0);
            }
        }

        $bukus = $query->latest()->get();

        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis'
        ));
    }

    /**
     * Show form create
     */
    public function create()
    {
        $kategoris = \App\Models\Kategori::orderBy('nama')->get();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Store buku baru
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            Buku::create($request->validated());

            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Show detail buku
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Edit buku
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = \App\Models\Kategori::orderBy('nama')->get();
        return view('buku.edit', compact('buku','kategoris'));
    }

  /**
 * Update the specified resource in storage.
 */
public function update(UpdateBukuRequest $request, string $id)
{
    try {
        $buku = Buku::findOrFail($id);
        
        // Update buku dengan validated data
        $buku->update($request->validated());
        
        // Redirect dengan success message
        return redirect()->route('buku.show', $buku->id)
                         ->with('success', 'Buku berhasil diupdate!');
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
    }
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    try {
        $buku = Buku::findOrFail($id);
        $judulBuku = $buku->judul;
        
        // Delete buku
        $buku->delete();
        
        // Redirect dengan success message
        return redirect()->route('buku.index')
                         ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                         
    } catch (\Exception $e) {
        // Redirect dengan error message jika gagal
        return redirect()->back()
                         ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
}
/**
 * Bulk Delete Buku
 */
public function bulkDelete(Request $request)
{
    if (!$request->has('buku_ids')) {
        return redirect()->route('buku.index')
            ->with('error', 'Pilih minimal satu buku.');
    }

    $deleted = Buku::whereIn('id', $request->buku_ids)->delete();

    return redirect()->route('buku.index')
        ->with('success', $deleted.' buku berhasil dihapus.');
}

/**
 * Export Buku ke CSV
 */
public function export()
{
    $bukus = Buku::all();

    $filename = 'buku_' . date('Y-m-d_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($bukus) {

        $file = fopen('php://output', 'w');

        // Header CSV
        fputcsv($file, [
            'Kode Buku',
            'Judul',
            'Kategori',
            'Pengarang',
            'Penerbit',
            'Tahun',
            'ISBN',
            'Harga',
            'Stok'
        ]);

        // Isi Data
        foreach ($bukus as $buku) {

            fputcsv($file, [
                $buku->kode_buku,
                $buku->judul,
                $buku->kategori,
                $buku->pengarang,
                $buku->penerbit,
                $buku->tahun_terbit,
                $buku->isbn,
                $buku->harga,
                $buku->stok
            ]);

        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}