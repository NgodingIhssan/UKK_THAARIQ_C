@extends('layouts.petugas')

@section('title', 'Barang Dipinjam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-box"></i> Barang Sedang Dipinjam</h2>
    <a href="{{ route('petugas.report.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>Barang</th><th>Jumlah</th><th>Peminjam</th><th>Tanggal Pinjam</th><th>Harus Kembali</th></tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->transaksi->siswa->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->transaksi->tgl_harus_kembali)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada barang dipinjam</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection