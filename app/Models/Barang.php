<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_barang', 'id_kategori', 'stok_tersedia', 'denda_hilang', 'denda_rusak'];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke TransaksiDetail
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_barang');
    }
}