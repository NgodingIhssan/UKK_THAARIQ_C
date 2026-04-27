<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Siswa;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    // __construct() DIHAPUS karena middleware sudah di route

    public function index()
    {
        $totalBarang = Barang::count();
        $totalSiswa = Siswa::count();
        $transaksiAktif = Transaksi::where('status', 'dipinjam')->count();
        $totalTransaksi = Transaksi::count();

        return view('admin.dashboard', compact(
            'totalBarang', 
            'totalSiswa', 
            'transaksiAktif', 
            'totalTransaksi'
        ));
    }
}