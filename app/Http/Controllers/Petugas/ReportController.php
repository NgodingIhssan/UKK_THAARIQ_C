<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $barangDipinjam = TransaksiDetail::whereHas('transaksi', function($q) {
            $q->where('status', 'dipinjam');
        })->count();

        $transaksiSelesai = Transaksi::where('status', 'dikembalikan')->count();
        $totalDenda = Transaksi::sum('denda_total');

        return view('petugas.report.index', compact('barangDipinjam', 'transaksiSelesai', 'totalDenda'));
    }

    public function barangDipinjam()
    {
        $items = TransaksiDetail::with(['barang', 'transaksi.siswa.user'])
            ->whereHas('transaksi', function($q) {
                $q->where('status', 'dipinjam');
            })
            ->get();

        return view('petugas.report.barang_dipinjam', compact('items'));
    }

    public function histori()
    {
        $transaksis = Transaksi::with(['siswa.user', 'transaksiDetails.barang'])
            ->where('status', 'dikembalikan')
            ->latest()
            ->paginate(10);

        return view('petugas.report.histori', compact('transaksis'));
    }
}