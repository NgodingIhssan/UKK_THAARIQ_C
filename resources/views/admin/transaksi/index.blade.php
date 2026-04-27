@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-exchange-alt"></i> Transaksi Peminjaman</h2>
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
                            <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($transaksi->status == 'menunggu_acc')
                                <form action="{{ route('admin.transaksi.approve', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui peminjaman ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.transaksi.reject', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak peminjaman ini?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
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