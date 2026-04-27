<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    /**
     * Daftar log aktivitas
     */
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user')
            ->when($request->search, function($q) use ($request) {
                $q->where('kegiatan', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(20);

        return view('admin.logaktivitas.index', compact('logs'));
    }
}