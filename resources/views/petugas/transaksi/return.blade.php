@extends('layouts.petugas')

@section('title', 'Pengembalian Barang')

@section('content')
<h2><i class="fas fa-undo-alt"></i> Form Pengembalian Barang</h2>

<div class="card">
    <div class="card-body">
        <p><strong>Transaksi #{{ $transaksi->id }}</strong></p>
        <p>Siswa: {{ $transaksi->siswa->user->name ?? '-' }}</p>
        <p>Tanggal Pinjam: {{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</p>
        <p>Harus Kembali: {{ \Carbon\Carbon::parse($transaksi->tgl_harus_kembali)->format('d/m/Y') }}</p>
        
        <hr>
        
        <form method="POST" action="{{ route('petugas.transaksi.process_return', $transaksi->id) }}">
            @csrf
            
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Barang</th><th>Jumlah</th><th>Kondisi Kembali</th></tr>
                </thead>
                <tbody>
                    @foreach($transaksi->transaksiDetails as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang }} ({{ $detail->jumlah }})</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>
                            <select name="kondisi[{{ $detail->id }}]" class="form-select" required>
                                <option value="baik">Baik</option>
                                <option value="kurang_baik">Kurang Baik</option>
                                <option value="rusak">Rusak</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <button type="submit" class="btn btn-success">Proses Pengembalian</button>
            <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection