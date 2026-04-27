@extends('layouts.siswa')

@section('title', 'Berhasil')

@section('content')
<div class="card text-center">
    <div class="card-body py-5">
        <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
        <h2 class="mt-3">Peminjaman Berhasil!</h2>
        <p class="lead">Peminjaman Anda sedang menunggu persetujuan admin.</p>
        <p>Silakan cek status peminjaman di menu <strong>Riwayat Peminjaman</strong>.</p>
        <a href="{{ route('siswa.riwayat.index') }}" class="btn btn-primary mt-3">
            <i class="fas fa-history"></i> Lihat Riwayat
        </a>
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-home"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection