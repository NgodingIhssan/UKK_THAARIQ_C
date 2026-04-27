<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHapusTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi', 'id_petugas', 'id_admin_yang_acc',
        'status_request', 'alasan'
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke User (petugas)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas');
    }

    // Relasi ke User (admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin_yang_acc');
    }
}