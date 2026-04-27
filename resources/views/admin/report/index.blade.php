@extends('layouts.admin')

@section('title', 'Report')

@section('content')
<h2><i class="fas fa-chart-bar"></i> Laporan</h2>

<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Barang Dipinjam</h5>
                <h2 class="mb-0">{{ $barangDipinjam ?? 0 }}</h2>
                <small>Barang sedang dipinjam</small>
                <a href="{{ route('admin.report.barang_dipinjam') }}" class="text-white d-block mt-2">Lihat Detail →</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Barang Hilang</h5>
                <h2 class="mb-0">{{ $barangHilang ?? 0 }}</h2>
                <small>Barang dinyatakan hilang</small>
                <a href="{{ route('admin.report.barang_hilang') }}" class="text-white d-block mt-2">Lihat Detail →</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Barang Rusak</h5>
                <h2 class="mb-0">{{ $barangRusak ?? 0 }}</h2>
                <small>Barang dinyatakan rusak</small>
                <a href="{{ route('admin.report.barang_rusak') }}" class="text-white d-block mt-2">Lihat Detail →</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Transaksi Terlambat</h5>
                <h2 class="mb-0">{{ $transaksiTerlambat ?? 0 }}</h2>
                <small>Belum dikembalikan melebihi batas</small>
            </div>
        </div>
    </div>
</div>
@endsection