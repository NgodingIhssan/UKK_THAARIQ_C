<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Daftar siswa
     */
    public function index()
    {
        $siswas = Siswa::with('user')->latest()->paginate(10);
        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Form tambah siswa
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan siswa baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'nis' => 'required|string|unique:siswas',
            'rayon' => 'required|string',
            'rombel' => 'required|string',
            'barcode' => 'required|string|unique:siswas',
        ]);

        // Buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456'),
            'role' => 'siswa'
        ]);

        // Buat siswa
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'rayon' => $request->rayon,
            'rombel' => $request->rombel,
            'barcode' => $request->barcode,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Detail siswa
     */
    public function show($id)
    {
        $siswa = Siswa::with('user', 'transaksis')->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Hapus siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->user->delete(); // akan cascade ke siswa
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus!');
    }
}