<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nis', 'rayon', 'rombel', 'barcode'];

    // Relasi ke User (inverse 1:1)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Transaksi (1:N)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_siswa');
    }
}