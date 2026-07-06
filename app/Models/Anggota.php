<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Transaksi;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'tanggal_daftar',
        'status'
    ];

    /**
     * Accessor Status Badge
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->status == 'Aktif') {
            return '<span class="badge bg-success">Aktif</span>';
        }

        return '<span class="badge bg-secondary">Nonaktif</span>';
    }

    /**
     * Accessor Kategori Usia
     */
    public function getKategoriUsiaAttribute(): string
    {
        $umur = Carbon::parse($this->tanggal_lahir)->age;

        if ($umur < 20) {
            return 'Remaja';
        } elseif ($umur <= 50) {
            return 'Dewasa';
        }

        return 'Senior';
    }

    /**
     * Scope Jenis Kelamin
     */
    public function scopeJenisKelamin($query, $jk)
    {
        return $query->where('jenis_kelamin', $jk);
    }

    /**
     * Scope Terdaftar Bulan Ini
     */
    public function scopeTerdaftarBulanIni($query)
    {
        return $query->whereMonth('tanggal_daftar', now()->month)
                     ->whereYear('tanggal_daftar', now()->year);
    }

    // Tambahkan method ini di class Anggota
public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}
}