@extends('layouts.siswa')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard Siswa</h2>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Transaksi Aktif</h5>
                <h2 class="mb-0">{{ $transaksiAktif }}</h2>
                <small>Menunggu ACC / Dipinjam</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="mb-0">{{ $totalTransaksi }}</h2>
                <small>Semua peminjaman</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Total Denda</h5>
                <h2 class="mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
                <small>Belum dibayar</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Barcode</h5>
                <h2 class="mb-0"><i class="fas fa-qrcode"></i></h2>
                <small>Klik untuk lihat barcode</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5><i class="fas fa-bolt"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-plus"></i> Pinjam Barang Baru
                </a>
                <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                    <i class="fas fa-qrcode"></i> Lihat Barcode Saya
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5><i class="fas fa-clock"></i> Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr><th>ID</th><th>Tgl Pinjam</th><th>Status</th><th>Detail</th></tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $t)
                        <tr>
                            <td>{{ $t->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tgl_pinjam)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $t->status == 'dipinjam' ? 'primary' : ($t->status == 'menunggu_acc' ? 'warning' : 'success') }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('siswa.riwayat.show', $t->id) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection