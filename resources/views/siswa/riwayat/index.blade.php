@extends('layouts.siswa')

@section('title', 'Riwayat Peminjaman')

@section('content')
<h2><i class="fas fa-history"></i> Riwayat Peminjaman</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Harus Kembali</th>
                        <th>Tgl Kembali</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>{{ $transaksi->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_harus_kembali)->format('d/m/Y') }}</td>
                        <td>{{ $transaksi->tgl_kembali ? \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @foreach($transaksi->transaksiDetails as $detail)
                                <span class="badge bg-secondary">{{ $detail->barang->nama_barang ?? '-' }} ({{ $detail->jumlah }})</span><br>
                            @endforeach
                        </td>
                        <td>
                            @php
                                $statusBadge = match($transaksi->status) {
                                    'menunggu_acc' => 'bg-warning',
                                    'dipinjam' => 'bg-primary',
                                    'dikembalikan' => 'bg-success',
                                    'ditolak' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusBadge }}">{{ $transaksi->status }}</span>
                        </td>
                        <td>Rp {{ number_format($transaksi->denda_total, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('siswa.riwayat.show', $transaksi->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada riwayat peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $transaksis->links() }}
    </div>
</div>
@endsection