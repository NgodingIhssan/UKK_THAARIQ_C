<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\RequestHapusTransaksi;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestHapusController extends Controller
{
    public function create($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('petugas.request_hapus.create', compact('transaksi'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:10'
        ]);

        $exists = RequestHapusTransaksi::where('id_transaksi', $id)
            ->where('status_request', 'pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Sudah ada request pending untuk transaksi ini!');
        }

        RequestHapusTransaksi::create([
            'id_transaksi' => $id,
            'id_petugas' => Auth::id(),
            'alasan' => $request->alasan,
            'status_request' => 'pending'
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'timestamp' => now(),
            'kegiatan' => 'REQUEST HAPUS',
            'keterangan' => "Minta hapus transaksi ID: {$id} dengan alasan: {$request->alasan}"
        ]);

        return redirect()->route('petugas.transaksi.index')
            ->with('success', 'Request hapus telah dikirim ke admin!');
    }

    public function index()
    {
        $requests = RequestHapusTransaksi::with(['transaksi.siswa.user', 'admin'])
            ->where('id_petugas', Auth::id())
            ->latest()
            ->paginate(10);

        return view('petugas.request_hapus.index', compact('requests'));
    }
}