<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori',
        'kategori_id',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'harga',
        'stok',
        'deskripsi',
        'bahasa'
    ];

    /**
     * Accessor Status Stok Badge
     */
    public function getStatusStokBadgeAttribute(): string
    {
        if ($this->stok == 0) {
            return '<span class="badge bg-danger">Habis</span>';
        } elseif ($this->stok <= 5) {
            return '<span class="badge bg-warning">Menipis</span>';
        } elseif ($this->stok <= 15) {
            return '<span class="badge bg-info">Sedang</span>';
        }

        return '<span class="badge bg-success">Aman</span>';
    }

    /**
     * Accessor Tahun Label
     */
    public function getTahunLabelAttribute(): string
    {
        return $this->tahun_terbit >= 2024
            ? 'Buku Baru'
            : 'Buku Lama';
    }

    /**
     * Scope Stok Menipis
     */
    public function scopeStokMenipis($query)
    {
        return $query->where('stok', '<', 5);
    }

    /**
     * Scope Harga Range
     */
    public function scopeHargaRange($query, $min, $max)
    {
        return $query->whereBetween('harga', [$min, $max]);
    }

    /**
     * Scope Terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query->where('tahun_terbit', '>=', 2024);
    }

    /**
     * Accessor Harga Format
     */
    public function getHargaFormatAttribute(): string
    {
        if (is_null($this->harga)) {
            return '-';
        }

        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    
    public function kategoriRelation()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    public function getKategoriNameAttribute()
    {
        return $this->kategoriRelation ? $this->kategoriRelation->nama : $this->kategori;
    }
}

