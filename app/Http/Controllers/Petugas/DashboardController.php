<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransaksi = Transaksi::count();
        $transaksiMenunggu = Transaksi::where('status', 'menunggu_acc')->count();
        $transaksiAktif = Transaksi::where('status', 'dipinjam')->count();
        $totalBarang = Barang::count();

        return view('petugas.dashboard', compact(
            'totalTransaksi',
            'transaksiMenunggu',
            'transaksiAktif',
            'totalBarang'
        ));
    }
}