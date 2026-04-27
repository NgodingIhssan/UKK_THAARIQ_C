@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Detail Barang</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID Barang</th>
                        <td>{{ $barang->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td><strong>{{ $barang->nama_barang }}</strong></td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>
                            @php
                                $badgeColor = match($barang->kategori->nama_kategori) {
                                    'Elektronik' => 'bg-danger',
                                    'ATK' => 'bg-success',
                                    'Peralatan Kelas' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeColor }}">
                                {{ $barang->kategori->nama_kategori }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Stok Tersedia</th>
                        <td>
                            <span class="badge bg-secondary">{{ $barang->stok_tersedia }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Denda Hilang</th>
                        <td>Rp {{ number_format($barang->denda_hilang, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Denda Rusak</th>
                        <td>Rp {{ number_format($barang->denda_rusak, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $barang->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $barang->updated_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <h4 class="mt-4">Riwayat Peminjaman</h4>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <th>Nama Siswa</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPinjam as $detail)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($detail->transaksi->tgl_pinjam)->format('d-m-Y') }}</td>
                        <td>{{ $detail->transaksi->siswa->user->name ?? '-' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>
                            @php
                                $statusBadge = match($detail->transaksi->status) {
                                    'menunggu_acc' => 'bg-warning',
                                    'dipinjam' => 'bg-primary',
                                    'dikembalikan' => 'bg-success',
                                    'ditolak' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusBadge }}">
                                {{ $detail->transaksi->status }}
                            </span>
                        </td>
                        <td>{{ $detail->transaksi->petugas->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <i class="fas fa-inbox"></i> Belum ada riwayat peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Barang
            </a>
            <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection