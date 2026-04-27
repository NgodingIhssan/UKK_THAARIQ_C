<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_siswa', 'id_petugas', 'tgl_pinjam', 'tgl_harus_kembali',
        'tgl_kembali', 'status', 'denda_total', 'keterangan_denda'
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Relasi ke User (petugas)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    // Relasi ke TransaksiDetail
    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi');
    }

    // Relasi ke RequestHapusTransaksi (1:1)
    public function requestHapus()
    {
        return $this->hasOne(RequestHapusTransaksi::class, 'id_transaksi');
    }
}