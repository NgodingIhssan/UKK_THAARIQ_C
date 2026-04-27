@extends('layouts.petugas')

@section('title', 'Report')

@section('content')
<h2><i class="fas fa-chart-bar"></i> Laporan</h2>

<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Barang Dipinjam</h5>
                <h2 class="mb-0">{{ $barangDipinjam }}</h2>
                <a href="{{ route('petugas.report.barang_dipinjam') }}" class="text-white d-block mt-2">Lihat Detail →</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Transaksi Selesai</h5>
                <h2 class="mb-0">{{ $transaksiSelesai }}</h2>
                <a href="{{ route('petugas.report.histori') }}" class="text-white d-block mt-2">Lihat Detail →</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Total Denda</h5>
                <h2 class="mb-0">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection