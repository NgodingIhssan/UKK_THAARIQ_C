@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user"></i> Detail Siswa</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="35%">NIS</th><td>{{ $siswa->nis }}</td></tr>
                    <tr><th>Nama</th><td>{{ $siswa->user->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $siswa->user->email }}</td></tr>
                    <tr><th>Rayon</th><td>{{ $siswa->rayon }}</td></tr>
                    <tr><th>Rombel</th><td>{{ $siswa->rombel }}</td></tr>
                    <tr><th>Barcode</th><td><strong>{{ $siswa->barcode }}</strong></td></tr>
                </table>
            </div>
        </div>
        
        <h4 class="mt-3">Riwayat Peminjaman</h4>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa->transaksis as $transaksi)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ $transaksi->tgl_kembali ? \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $transaksi->status }}</td>
                        <td>Rp {{ number_format($transaksi->denda_total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Belum ada riwayat peminjaman</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection