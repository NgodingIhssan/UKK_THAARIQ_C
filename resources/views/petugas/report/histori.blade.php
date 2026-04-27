@extends('layouts.petugas')

@section('title', 'Histori Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-history"></i> Histori Transaksi</h2>
    <a href="{{ route('petugas.report.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>ID</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Siswa</th><th>Denda</th></tr>
            </thead>
            <tbody>
                @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ $transaksi->tgl_kembali ? \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $transaksi->siswa->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($transaksi->denda_total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <td><td colspan="5" class="text-center">Belum ada transaksi selesai</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $transaksis->links() }}
    </div>
</div>
@endsection