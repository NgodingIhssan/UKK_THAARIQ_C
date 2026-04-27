@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                                <h5 class="card-title">Total Barang</h5>
                <h2 class="mb-0">{{ $totalBarang }}</h2>
                <small>Jenis barang tersedia</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <h2 class="mb-0">{{ $totalSiswa }}</h2>
                <small>Terdaftar di sistem</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Transaksi Aktif</h5>
                <h2 class="mb-0">{{ $transaksiAktif }}</h2>
                <small>Barang sedang dipinjam</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="mb-0">{{ $totalTransaksi }}</h2>
                <small>Semua transaksi</small>
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
                <a href="{{ route('admin.barang.create') }}" class="btn btn-primary mb-2 w-100">
                    <i class="fas fa-plus"></i> Tambah Barang Baru
                </a>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-boxes"></i> Kelola Data Barang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection