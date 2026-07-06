<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    /* =========================================================
     * INDEX
     * ======================================================= */
    public function index()
    {
        $transaksis = Transaksi::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('transaksi.index', compact('transaksis'));
    }

    /* =========================================================
     * PINJAM (TEST/DEBUG)
     * ======================================================= */
    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);

        $anggotas = Anggota::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $bukus = Buku::where('stok', '>', 0)
            ->orderBy('judul')
            ->get();

        return view('transaksi.create', compact('anggotas', 'bukus', 'buku'));
    }

    /* =========================================================
     * CREATE
     * ======================================================= */
    public function create()
    {
        $anggotas = Anggota::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $bukus = Buku::where('stok', '>', 0)
            ->orderBy('judul')
            ->get();

        return view('transaksi.create', compact('anggotas', 'bukus'));
    }

    /* =========================================================
     * STORE
     * ======================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'     => 'required|exists:anggota,id',
            'buku_id'        => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'keterangan'     => 'nullable|string',
        ], [
            'anggota_id.required'     => 'Anggota wajib dipilih.',
            'buku_id.required'        => 'Buku wajib dipilih.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $buku = Buku::findOrFail($request->buku_id);

                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis!');
                }

                $kodeTransaksi = $this->generateKodeTransaksi();

                $tanggalKembali = Carbon::parse($request->tanggal_pinjam)
                    ->addDays(7);

                Transaksi::create([
                    'kode_transaksi'  => $kodeTransaksi,
                    'anggota_id'      => $request->anggota_id,
                    'buku_id'         => $request->buku_id,
                    'tanggal_pinjam'  => $request->tanggal_pinjam,
                    'tanggal_kembali' => $tanggalKembali,
                    'status'          => 'Dipinjam',
                    'keterangan'      => $request->keterangan,
                ]);

                $buku->decrement('stok');
            });

            return redirect()
                ->route('transaksi.index')
                ->with('success', 'Transaksi peminjaman berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    /* =========================================================
     * SHOW
     * ======================================================= */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }

    /* =========================================================
     * EDIT
     * ======================================================= */
    public function edit(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $anggotas = Anggota::where('status', 'Aktif')->get();
        $bukus = Buku::all();

        return view('transaksi.edit', compact('transaksi', 'anggotas', 'bukus'));
    }

    /* =========================================================
     * UPDATE
     * ======================================================= */
    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'anggota_id'     => 'required|exists:anggota,id',
            'buku_id'        => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali'=> 'nullable|date|after_or_equal:tanggal_pinjam',
            'keterangan'     => 'nullable|string',
        ]);

        $input = $request->all();

        // Jika tanggal_pinjam diubah, perbarui tanggal_kembali otomatis
        if ($request->filled('tanggal_pinjam')) {

            $oldPinjam = $transaksi->tanggal_pinjam ? $transaksi->tanggal_pinjam->format('Y-m-d') : null;
            $oldKembali = $transaksi->tanggal_kembali ? $transaksi->tanggal_kembali->format('Y-m-d') : null;
            $expectedOldKembali = $oldPinjam ? Carbon::parse($oldPinjam)->addDays(7)->format('Y-m-d') : null;

            // Jika user tidak mengisi tanggal_kembali di form, set otomatis
            if (! $request->filled('tanggal_kembali')) {
                $input['tanggal_kembali'] = Carbon::parse($request->tanggal_pinjam)->addDays(7)->format('Y-m-d');
            } else {
                // Jika sebelumnya tanggal_kembali adalah nilai default (pinjam+7)
                // dan user tidak mengubahnya, perbarui supaya mengikuti tanggal_pinjam baru
                if ($oldKembali && $expectedOldKembali && $oldKembali == $expectedOldKembali && $request->input('tanggal_kembali') == $oldKembali) {
                    $input['tanggal_kembali'] = Carbon::parse($request->tanggal_pinjam)->addDays(7)->format('Y-m-d');
                }
            }

        }

        $transaksi->update($input);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diubah.');
    }

    /* =========================================================
     * PENGEMBALIAN
     * ======================================================= */
    public function kembalikan(string $id)
    {
        try {
            DB::transaction(function () use ($id) {

                $transaksi = Transaksi::findOrFail($id);

                if ($transaksi->status === 'Dikembalikan') {
                    throw new \Exception('Buku sudah dikembalikan sebelumnya.');
                }

                $tanggalDikembalikan = now();

                $denda = $this->hitungDenda(
                    $transaksi,
                    $tanggalDikembalikan
                );

                $transaksi->update([
                    'status'               => 'Dikembalikan',
                    'tanggal_dikembalikan' => $tanggalDikembalikan,
                    'denda'                => $denda,
                ]);

                $transaksi->buku->increment('stok');
            });

            return redirect()
                ->route('transaksi.show', $id)
                ->with('success', 'Buku berhasil dikembalikan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }

    /* =========================================================
     * LAPORAN
     * ======================================================= */
    public function laporan(Request $request)
    {
        $query = Transaksi::with(['anggota', 'buku']);

        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        if ($request->status && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        if ($request->anggota_id) {
            $query->where('anggota_id', $request->anggota_id);
        }

        $transaksis = $query->latest()->get();
        $anggotas = Anggota::all();
        $totalDenda = $transaksis->sum('denda');

        return view('transaksi.laporan', compact(
            'transaksis',
            'anggotas',
            'totalDenda'
        ));
    }

    /* =========================================================
     * EXPORT PDF
     * ======================================================= */
    public function exportPdf()
    {
        $transaksis = Transaksi::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $totalDenda = $transaksis->sum('denda');

        $pdf = Pdf::loadView('transaksi.laporan_pdf', compact(
            'transaksis',
            'totalDenda'
        ));

        return $pdf->download('laporan-transaksi.pdf');
    }

    /* =========================================================
     * DELETE
     * ======================================================= */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /* =========================================================
     * HELPER
     * ======================================================= */
    private function generateKodeTransaksi()
    {
        $lastTransaksi = Transaksi::latest()->first();

        if ($lastTransaksi) {
            $lastNumber = (int) substr($lastTransaksi->kode_transaksi, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'TRX-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    private function hitungDenda($transaksi, $tanggalDikembalikan)
    {
        if ($tanggalDikembalikan->gt($transaksi->tanggal_kembali)) {

            $hariTerlambat = $transaksi->tanggal_kembali
                ->diffInDays($tanggalDikembalikan);

            $hariTerlambat = max(0, $hariTerlambat);

            return $hariTerlambat * 5000;
        }

        return 0;
    }
}