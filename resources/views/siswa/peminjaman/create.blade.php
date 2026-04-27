@extends('layouts.siswa')

@section('title', 'Pinjam Barang')

@section('content')
<h2><i class="fas fa-plus"></i> Form Peminjaman Baru</h2>

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Silakan scan/pilih barang yang ingin dipinjam. 
    Peminjaman maksimal 7 hari dan akan diproses oleh admin.
</div>

<div class="card">
    <div class="card-body">
        <form id="peminjamanForm" method="POST" action="{{ route('siswa.peminjaman.store') }}">
            @csrf
            
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Daftar Barang</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Cari Barang (ID atau Nama)</label>
                            <div class="input-group">
                                <input type="text" id="barang_keyword" class="form-control" placeholder="Scan ID atau nama barang">
                                <button type="button" id="cari_barang" class="btn btn-primary">Tambah</button>
                            </div>
                            <small class="text-muted">Contoh: ketik "Laptop" atau ID barang</small>
                        </div>
                    </div>
                    
                    <div id="barang_list">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr><th>Barang</th><th>Jumlah</th><th>Stok</th><th>Aksi</th></tr>
                            </thead>
                            <tbody id="barang_tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
            </button>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@push('scripts')
<script>
let items = [];

$('#cari_barang').click(function() {
    let keyword = $('#barang_keyword').val();
    if (!keyword) {
        alert('Masukkan ID atau nama barang');
        return;
    }
    
    $.post('{{ route("siswa.peminjaman.cari_barang") }}', {
        keyword: keyword, 
        _token: '{{ csrf_token() }}'
    }, function(res) {
        if (res.success) {
            let exists = items.find(i => i.barang_id == res.data.id);
            if (exists) {
                alert('Barang sudah ditambahkan!');
                return;
            }
            
            items.push({
                barang_id: res.data.id,
                nama_barang: res.data.nama_barang,
                stok: res.data.stok,
                jumlah: 1
            });
            renderBarangList();
            $('#barang_keyword').val('');
        } else {
            alert(res.message);
        }
    });
});

function renderBarangList() {
    let html = '';
    items.forEach((item, index) => {
        html += `<tr>
            <td>${item.nama_barang}<input type="hidden" name="items[${index}][barang_id]" value="${item.barang_id}"></td>
            <td><input type="number" name="items[${index}][jumlah]" value="${item.jumlah}" min="1" max="${item.stok}" class="form-control form-control-sm" style="width:80px" onchange="updateJumlah(${index}, this.value)"></td>
            <td>${item.stok}</td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(${index})">Hapus</button></td>
        </tr>`;
    });
    $('#barang_tbody').html(html);
}

function updateJumlah(index, jumlah) {
    items[index].jumlah = parseInt(jumlah);
}

function hapusItem(index) {
    items.splice(index, 1);
    renderBarangList();
}

$('#peminjamanForm').submit(function(e) {
    if (!items.length) {
        e.preventDefault();
        alert('Minimal 1 barang dipinjam!');
        return false;
    }
});
</script>
@endpush
@endsection