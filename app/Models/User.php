<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    // Relasi ke Siswa (1:1)
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    // Relasi ke Transaksi sebagai petugas
    public function transaksiSebagaiPetugas()
    {
        return $this->hasMany(Transaksi::class, 'id_petugas');
    }

    // Relasi ke LogAktivitas
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    // Relasi ke RequestHapus sebagai petugas
    public function requestHapusSebagaiPetugas()
    {
        return $this->hasMany(RequestHapusTransaksi::class, 'id_petugas');
    }

    // Relasi ke RequestHapus sebagai admin
    public function requestHapusSebagaiAdmin()
    {
        return $this->hasMany(RequestHapusTransaksi::class, 'id_admin_yang_acc');
    }
}