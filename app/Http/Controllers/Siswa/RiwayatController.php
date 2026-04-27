<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Riwayat peminjaman
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        
        $transaksis = Transaksi::where('id_siswa', $siswa->id)
            ->with('transaksiDetails.barang')
            ->latest()
            ->paginate(10);
        
        return view('siswa.riwayat.index', compact('transaksis'));
    }
    
    /**
     * Detail transaksi
     */
    public function show($id)
    {
        $siswa = Auth::user()->siswa;
        
        $transaksi = Transaksi::where('id_siswa', $siswa->id)
            ->with('transaksiDetails.barang')
            ->findOrFail($id);
        
        return view('siswa.riwayat.show', compact('transaksi'));
    }
}