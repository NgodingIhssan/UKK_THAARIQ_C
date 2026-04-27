@extends('layouts.petugas')

@section('title', 'Buat Request Hapus')

@section('content')
<h2><i class="fas fa-trash-alt"></i> Request Hapus Transaksi #{{ $transaksi->id }}</h2>

<div class="card">
    <div class="card-body">
        <p><strong>Siswa:</strong> {{ $transaksi->siswa->user->name ?? '-' }}</p>
        <p><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($transaksi->tgl_pinjam)->format('d/m/Y') }}</p>
        
        <hr>
        
        <form method="POST" action="{{ route('petugas.request_hapus.store', $transaksi->id) }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Alasan Request Hapus <span class="text-danger">*</span></label>
                <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="4" required placeholder="Jelaskan alasan meminta penghapusan transaksi..."></textarea>
                @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <button type="submit" class="btn btn-danger">Kirim Request</button>
            <a href="{{ route('petugas.request_hapus.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection