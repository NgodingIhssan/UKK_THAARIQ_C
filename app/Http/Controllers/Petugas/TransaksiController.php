<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Form peminjaman
     */
    public function create()
    {
        $barangs = Barang::with('kategori')->where('stok_tersedia', '>', 0)->get();
        return view('petugas.transaksi.create', compact('barangs'));
    }

    /**
     * Cari siswa berdasarkan barcode/NIS
     */
    public function cariSiswa(Request $request)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);

        $siswa = Siswa::with('user')
            ->where('barcode', $request->kode)
            ->orWhere('nis', $request->kode)
            ->first();

        if ($siswa) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $siswa->id,
                    'name' => $siswa->user->name,
                    'nis' => $siswa->nis,
                    'rayon' => $siswa->rayon,
                    'rombel' => $siswa->rombel,
                    'barcode' => $siswa->barcode
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Siswa tidak ditemukan!'
        ]);
    }

    /**
     * Cari barang berdasarkan ID/nama
     */
    public function cariBarang(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string'
        ]);

        $barang = Barang::with('kategori')
            ->where('id', $request->keyword)
            ->orWhere('nama_barang', 'like', '%' . $request->keyword . '%')
            ->first();

        if ($barang && $barang->stok_tersedia > 0) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'kategori' => $barang->kategori->nama_kategori,
                    'stok' => $barang->stok_tersedia
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Barang tidak ditemukan atau stok habis!'
        ]);
    }

    /**
     * Simpan transaksi peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'tgl_harus_kembali' => 'required|date|after_or_equal:today'
        ]);

        // Hitung total hari peminjaman (contoh: 7 hari default)
        $tgl_pinjam = Carbon::now();
        $tgl_harus_kembali = Carbon::parse($request->tgl_harus_kembali);

        // Buat transaksi
        $transaksi = Transaksi::create([
            'id_siswa' => $request->siswa_id,
            'id_petugas' => Auth::id(),
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_harus_kembali' => $tgl_harus_kembali,
            'status' => 'menunggu_acc'
        ]);

        // Simpan detail barang
        foreach ($request->items as $item) {
            TransaksiDetail::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'kondisi_pinjam' => 'baik'
            ]);

            // Kurangi stok
            $barang = Barang::find($item['barang_id']);
            $barang->stok_tersedia -= $item['jumlah'];
            $barang->save();
        }

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'INPUT TRANSAKSI',
            'keterangan' => "Membuat transaksi peminjaman ID: {$transaksi->id}"
        ]);

        return redirect()->route('petugas.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat, menunggu persetujuan admin!');
    }

    /**
     * Daftar transaksi
     */
    public function index()
    {
        $transaksis = Transaksi::with(['siswa.user', 'transaksiDetails.barang'])
            ->latest()
            ->paginate(10);

        return view('petugas.transaksi.index', compact('transaksis'));
    }

    /**
     * Form pengembalian
     */
    public function returnForm($id)
    {
        $transaksi = Transaksi::with(['siswa.user', 'transaksiDetails.barang'])
            ->findOrFail($id);

        return view('petugas.transaksi.return', compact('transaksi'));
    }

    /**
     * Proses pengembalian
     */
    public function processReturn(Request $request, $id)
    {
        $request->validate([
            'kondisi' => 'required|array',
            'kondisi.*' => 'required|in:baik,kurang_baik,rusak,hilang'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $totalDenda = 0;

        foreach ($transaksi->transaksiDetails as $detail) {
            $kondisi = $request->kondisi[$detail->id];
            $detail->kondisi_kembali = $kondisi;
            $detail->save();

            // Hitung denda
            if ($kondisi == 'rusak') {
                $totalDenda += $detail->barang->denda_rusak * $detail->jumlah;
            } elseif ($kondisi == 'hilang') {
                $totalDenda += $detail->barang->denda_hilang * $detail->jumlah;
            }

            // Kembalikan stok jika kondisi baik atau kurang baik
            if ($kondisi != 'hilang') {
                $barang = Barang::find($detail->id_barang);
                $barang->stok_tersedia += $detail->jumlah;
                $barang->save();
            }
        }

        // Cek telat
        $tgl_harus_kembali = Carbon::parse($transaksi->tgl_harus_kembali);
        if (Carbon::now()->gt($tgl_harus_kembali)) {
            $hariTelat = Carbon::now()->diffInDays($tgl_harus_kembali);
            $dendaTelat = $hariTelat * 5000; // Contoh denda per hari
            $totalDenda += $dendaTelat;
        }

        $transaksi->tgl_kembali = now();
        $transaksi->status = 'dikembalikan';
        $transaksi->denda_total = $totalDenda;
        $transaksi->save();

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'PENGEMBALIAN',
            'keterangan' => "Pengembalian transaksi ID: {$transaksi->id}, Denda: Rp " . number_format($totalDenda, 0, ',', '.')
        ]);

        return redirect()->route('petugas.transaksi.index')
            ->with('success', 'Pengembalian berhasil! Denda: Rp ' . number_format($totalDenda, 0, ',', '.'));
    }
}