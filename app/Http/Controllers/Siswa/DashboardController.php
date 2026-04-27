<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        
        // Transaksi aktif (menunggu acc atau dipinjam)
        $transaksiAktif = Transaksi::where('id_siswa', $siswa->id)
            ->whereIn('status', ['menunggu_acc', 'dipinjam'])
            ->count();
        
        // Total transaksi
        $totalTransaksi = Transaksi::where('id_siswa', $siswa->id)->count();
        
        // Total denda
        $totalDenda = Transaksi::where('id_siswa', $siswa->id)->sum('denda_total');
        
        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::where('id_siswa', $siswa->id)
            ->with('transaksiDetails.barang')
            ->latest()
            ->take(5)
            ->get();
        
        return view('siswa.dashboard', compact(
            'transaksiAktif',
            'totalTransaksi',
            'totalDenda',
            'transaksiTerbaru'
        ));
    }
}