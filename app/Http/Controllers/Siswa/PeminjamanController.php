<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Form peminjaman
     */
    public function create()
    {
        $barangs = Barang::with('kategori')->where('stok_tersedia', '>', 0)->get();
        return view('siswa.peminjaman.create', compact('barangs'));
    }
    
    /**
     * Cari barang
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
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);
        
        $siswa = Auth::user()->siswa;
        $tgl_pinjam = Carbon::now();
        $tgl_harus_kembali = Carbon::now()->addDays(7);
        
        // Cari user admin atau petugas untuk dijadikan id_petugas (karena siswa pinjam sendiri)
        $defaultPetugas = User::where('role', 'admin')->orWhere('role', 'petugas')->first();
        
        $transaksi = Transaksi::create([
            'id_siswa' => $siswa->id,
            'id_petugas' => $defaultPetugas ? $defaultPetugas->id : 1, // pake user id 1 (admin) jika tidak ada
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_harus_kembali' => $tgl_harus_kembali,
            'status' => 'menunggu_acc'
        ]);
        
        foreach ($request->items as $item) {
            TransaksiDetail::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'kondisi_pinjam' => 'baik'
            ]);
            
            $barang = Barang::find($item['barang_id']);
            $barang->stok_tersedia -= $item['jumlah'];
            $barang->save();
        }
        
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'PINJAM SENDIRI',
            'keterangan' => "Siswa {$siswa->user->name} meminjam transaksi #{$transaksi->id}"
        ]);
        
        return redirect()->route('siswa.peminjaman.success')
            ->with('success', 'Peminjaman berhasil! Menunggu persetujuan admin.');
    }
    
    /**
     * Halaman sukses
     */
    public function success()
    {
        return view('siswa.peminjaman.success');
    }
}