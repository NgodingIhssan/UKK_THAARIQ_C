@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Detail Transaksi #{{ $transaksi->id }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="40%">Tanggal Pinjam</th><td>{{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</td></tr>
                    <tr><th>Tanggal Harus Kembali</th><td>{{ \Carbon\Carbon::parse($transaksi->tgl_harus_kembali)->format('d/m/Y') }}</td></tr>
                    @if($transaksi->tgl_kembali)
                    <tr><th>Tanggal Kembali</th><td>{{ \Carbon\Carbon::parse($transaksi->tgl_kembali)->format('d/m/Y') }}</td></tr>
                    @endif
                    <tr><th>Status</th><td>
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
                    </td></tr>
                    <tr><th>Denda Total</th><td>Rp {{ number_format($transaksi->denda_total, 0, ',', '.') }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th width="40%">Nama Siswa</th><td>{{ $transaksi->siswa->user->name ?? '-' }}</td></tr>
                    <tr><th>NIS</th><td>{{ $transaksi->siswa->nis ?? '-' }}</td></tr>
                    <tr><th>Rayon</th><td>{{ $transaksi->siswa->rayon ?? '-' }}</td></tr>
                    <tr><th>Rombel</th><td>{{ $transaksi->siswa->rombel ?? '-' }}</td></tr>
                    <tr><th>Petugas</th><td>{{ $transaksi->petugas->name ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <h4 class="mt-4">Detail Barang yang Dipinjam</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi Pinjam</th>
                        <th>Kondisi Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->transaksiDetails as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ $detail->kondisi_pinjam }}</td>
                        <td>{{ $detail->kondisi_kembali ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection