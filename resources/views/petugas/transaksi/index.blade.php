@extends('layouts.petugas')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-list"></i> Daftar Transaksi</h2>
    <a href="{{ route('petugas.transaksi.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Peminjaman Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tgl Pinjam</th>
                        <th>Harus Kembali</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>{{ $transaksi->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tgl_harus_kembali)->format('d/m/Y') }}</td>
                        <td>{{ $transaksi->siswa->user->name ?? '-' }}<br>
                            <small>{{ $transaksi->siswa->rayon ?? '-' }} / {{ $transaksi->siswa->rombel ?? '-' }}</small>
                        </td>
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
                        <td>
                            <a href="{{ route('petugas.transaksi.return', $transaksi->id) }}" class="btn btn-sm btn-success" {{ $transaksi->status != 'dipinjam' ? 'disabled' : '' }}>
                                <i class="fas fa-undo-alt"></i> Kembali
                            </a>
                            <a href="{{ route('petugas.request_hapus.create', $transaksi->id) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Request Hapus
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $transaksis->links() }}
    </div>
</div>
@endsection