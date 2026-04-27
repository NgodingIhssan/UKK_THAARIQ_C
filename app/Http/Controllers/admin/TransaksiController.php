<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Siswa;
use App\Models\Barang;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Daftar semua transaksi
     */
    public function index()
    {
        $transaksis = Transaksi::with(['siswa.user', 'petugas', 'transaksiDetails.barang'])
            ->latest()
            ->paginate(10);
        
        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Detail transaksi
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['siswa.user', 'petugas', 'transaksiDetails.barang'])
            ->findOrFail($id);
        
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * ACC transaksi (setujui peminjaman)
     */
    public function approve($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'dipinjam';
        $transaksi->save();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil disetujui!');
    }

    /**
     * Tolak transaksi
     */
    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'ditolak';
        $transaksi->save();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi ditolak!');
    }
}