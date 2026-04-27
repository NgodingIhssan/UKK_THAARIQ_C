@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-boxes"></i> Data Barang</h2>
    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang
    </a>
</div>

<!-- Card Filter & Search -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Filter Kategori</label>
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Cari Barang</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nama barang...">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Barang -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th>Nama Barang</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Stok</th>
                        <th width="15%">Denda Hilang</th>
                        <th width="15%">Denda Rusak</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $barang->id }}</td>
                        <td>{{ $barang->nama_barang }}</td>
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
                        <td>
                            <span class="badge bg-secondary">{{ $barang->stok_tersedia }}</span>
                        </td>
                        <td>Rp {{ number_format($barang->denda_hilang, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->denda_rusak, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.barang.show', $barang->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $barang->id }}, '{{ $barang->nama_barang }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="editStok({{ $barang->id }}, {{ $barang->stok_tersedia }})" title="Update Stok">
                                <i class="fas fa-boxes"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="fas fa-inbox"></i> Tidak ada data barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-end">
            {{ $barangs->links() }}
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-trash text-danger"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus barang <strong id="deleteBarangName"></strong>?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle"></i> Data yang sudah dihapus tidak dapat dikembalikan!</small></p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Stok -->
<div class="modal fade" id="stokModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-boxes"></i> Update Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="stokForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Stok Tersedia</label>
                        <input type="number" name="stok_tersedia" id="stokValue" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Update Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    let stokModal = new bootstrap.Modal(document.getElementById('stokModal'));
    let currentBarangId = null;

    function confirmDelete(id, name) {
        document.getElementById('deleteBarangName').innerText = name;
        document.getElementById('deleteForm').action = `/admin/barang/${id}`;
        deleteModal.show();
    }

    function editStok(id, currentStok) {
        currentBarangId = id;
        document.getElementById('stokValue').value = currentStok;
        stokModal.show();
    }

    document.getElementById('stokForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let stok = document.getElementById('stokValue').value;
        
        fetch(`/admin/barang/${currentBarangId}/stok`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ stok_tersedia: stok })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal update stok');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
        });
    });
</script>
@endpush