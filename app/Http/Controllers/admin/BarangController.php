<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    // __construct() DIHAPUS karena middleware sudah di route

    /**
     * Menampilkan daftar barang
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->latest()->paginate(10);
        $kategoris = Kategori::all();

        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }

    /**
     * Form tambah barang
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    /**
     * Menyimpan barang baru
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategoris,id',
            'stok_tersedia' => 'required|integer|min:0',
            'denda_hilang' => 'required|numeric|min:0',
            'denda_rusak' => 'required|numeric|min:0',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'id_kategori.required' => 'Kategori wajib dipilih',
            'stok_tersedia.min' => 'Stok tidak boleh negatif',
            'denda_hilang.min' => 'Denda hilang tidak boleh negatif',
            'denda_rusak.min' => 'Denda rusak tidak boleh negatif',
        ]);

        $barang = Barang::create($validated);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'TAMBAH BARANG',
            'keterangan' => "Menambah barang: {$barang->nama_barang} (ID: {$barang->id}) | Kategori: {$barang->kategori->nama_kategori} | Stok: {$barang->stok_tersedia}"
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Detail barang
     */
    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        
        // Riwayat peminjaman barang
        $riwayatPinjam = $barang->transaksiDetails()
            ->with('transaksi.siswa.user', 'transaksi.petugas')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.barang.show', compact('barang', 'riwayatPinjam'));
    }

    /**
     * Form edit barang
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update barang
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        // Validasi
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategoris,id',
            'stok_tersedia' => 'required|integer|min:0',
            'denda_hilang' => 'required|numeric|min:0',
            'denda_rusak' => 'required|numeric|min:0',
        ]);

        $oldData = $barang->nama_barang;
        $barang->update($validated);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'EDIT BARANG',
            'keterangan' => "Mengedit barang: {$oldData} → {$barang->nama_barang} (ID: {$barang->id})"
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Hapus barang
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Cek apakah barang sedang dipinjam
        $sedangDipinjam = $barang->transaksiDetails()
            ->whereHas('transaksi', function($q) {
                $q->where('status', 'dipinjam');
            })
            ->exists();

        if ($sedangDipinjam) {
            return redirect()->route('admin.barang.index')
                ->with('error', 'Tidak bisa menghapus barang yang sedang dipinjam!');
        }

        $namaBarang = $barang->nama_barang;
        $idBarang = $barang->id;
        $barang->delete();

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'HAPUS BARANG',
            'keterangan' => "Menghapus barang: {$namaBarang} (ID: {$idBarang})"
        ]);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Update stok barang (AJAX)
     */
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok_tersedia' => 'required|integer|min:0'
        ]);

        $barang = Barang::findOrFail($id);
        $stokLama = $barang->stok_tersedia;
        $barang->stok_tersedia = $request->stok_tersedia;
        $barang->save();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'UPDATE STOK',
            'keterangan' => "Update stok barang {$barang->nama_barang}: {$stokLama} → {$request->stok_tersedia}"
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Stok berhasil diupdate'
        ]);
    }
}