<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Halaman utama report
     */
    public function index()
    {
        // Barang sedang dipinjam
        $barangDipinjam = TransaksiDetail::whereHas('transaksi', function($q) {
            $q->where('status', 'dipinjam');
        })->count();

        // Barang hilang
        $barangHilang = TransaksiDetail::where('kondisi_kembali', 'hilang')->count();

        // Barang rusak
        $barangRusak = TransaksiDetail::where('kondisi_kembali', 'rusak')->count();

        // Transaksi terlambat
        $transaksiTerlambat = Transaksi::where('status', 'dipinjam')
            ->where('tgl_harus_kembali', '<', now())
            ->count();

        return view('admin.report.index', compact(
            'barangDipinjam', 
            'barangHilang', 
            'barangRusak',
            'transaksiTerlambat'
        ));
    }

    /**
     * Laporan barang dipinjam
     */
    public function barangDipinjam()
    {
        $items = TransaksiDetail::with(['barang', 'transaksi.siswa.user'])
            ->whereHas('transaksi', function($q) {
                $q->where('status', 'dipinjam');
            })
            ->get();

        return view('admin.report.barang_dipinjam', compact('items'));
    }

    /**
     * Laporan barang hilang
     */
    public function barangHilang()
    {
        $items = TransaksiDetail::with(['barang', 'transaksi.siswa.user'])
            ->where('kondisi_kembali', 'hilang')
            ->get();

        return view('admin.report.barang_hilang', compact('items'));
    }

    /**
     * Laporan barang rusak
     */
    public function barangRusak()
    {
        $items = TransaksiDetail::with(['barang', 'transaksi.siswa.user'])
            ->where('kondisi_kembali', 'rusak')
            ->get();

        return view('admin.report.barang_rusak', compact('items'));
    }
}