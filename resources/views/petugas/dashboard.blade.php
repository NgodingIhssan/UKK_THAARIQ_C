@extends('layouts.petugas')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard Petugas</h2>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="mb-0">{{ $totalTransaksi }}</h2>
                <small>Semua transaksi</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Menunggu ACC</h5>
                <h2 class="mb-0">{{ $transaksiMenunggu }}</h2>
                <small>Menunggu persetujuan admin</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Transaksi Aktif</h5>
                <h2 class="mb-0">{{ $transaksiAktif }}</h2>
                <small>Sedang dipinjam</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <h2 class="mb-0">{{ $totalBarang }}</h2>
                <small>Jenis barang</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('petugas.transaksi.create') }}" class="btn btn-success mb-2 w-100">
                    <i class="fas fa-plus"></i> Peminjaman Baru
                </a>
                <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-info w-100">
                    <i class="fas fa-list"></i> Lihat Transaksi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection