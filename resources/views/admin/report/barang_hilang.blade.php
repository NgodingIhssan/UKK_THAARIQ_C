@extends('layouts.admin')

@section('title', 'Report - Barang Hilang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-box"></i> Barang Hilang</h2>
    <a href="{{ route('admin.report.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah Hilang</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Denda Hilang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $item->jumlah ?? 0 }}</td>
                        <td>{{ $item->transaksi->siswa->user->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->transaksi->tgl_pinjam)->format('d/m/Y') ?? '-' }}</td>
                        <td>Rp {{ number_format(($item->barang->denda_hilang ?? 0) * ($item->jumlah ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada barang hilang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection