@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-edit"></i> Edit Barang</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('id_kategori', $barang->id_kategori) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Stok Tersedia <span class="text-danger">*</span></label>
                        <input type="number" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" value="{{ old('stok_tersedia', $barang->stok_tersedia) }}" min="0" required>
                        @error('stok_tersedia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Denda Hilang (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="denda_hilang" class="form-control @error('denda_hilang') is-invalid @enderror" value="{{ old('denda_hilang', $barang->denda_hilang) }}" min="0" required>
                        <small class="text-muted">Denda jika barang hilang</small>
                        @error('denda_hilang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Denda Rusak (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="denda_rusak" class="form-control @error('denda_rusak') is-invalid @enderror" value="{{ old('denda_rusak', $barang->denda_rusak) }}" min="0" required>
                        <small class="text-muted">Denda jika barang rusak</small>
                        @error('denda_rusak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Barang
                </button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection