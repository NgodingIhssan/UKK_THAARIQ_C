@extends('layouts.petugas')

@section('title', 'Peminjaman Baru')

@section('content')
<h2><i class="fas fa-plus"></i> Form Peminjaman Baru</h2>

<div class="card">
    <div class="card-body">
        <form id="transaksiForm" method="POST" action="{{ route('petugas.transaksi.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">Data Siswa</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Scan Barcode / NIS</label>
                                <div class="input-group">
                                    <input type="text" id="siswa_kode" class="form-control" placeholder="Scan barcode atau masukkan NIS">
                                    <button type="button" id="cari_siswa" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                            
                            <div id="siswa_info" style="display:none;">
                                <hr>
                                <p><strong>Nama:</strong> <span id="siswa_nama"></span></p>
                                <p><strong>NIS:</strong> <span id="siswa_nis"></span></p>
                                <p><strong>Rayon:</strong> <span id="siswa_rayon"></span></p>
                                <p><strong>Rombel:</strong> <span id="siswa_rombel"></span></p>
                                <input type="hidden" name="siswa_id" id="siswa_id">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">Data Peminjaman</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Harus Kembali</label>
                                <input type="date" name="tgl_harus_kembali" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
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
            
            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
            <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@push('scripts')
<script>
let items = [];

$('#cari_siswa').click(function() {
    let kode = $('#siswa_kode').val();
    if (!kode) return alert('Masukkan barcode/NIS');
    
    $.post('{{ route("petugas.transaksi.cari_siswa") }}', {kode: kode, _token: '{{ csrf_token() }}'}, function(res) {
        if (res.success) {
            $('#siswa_id').val(res.data.id);
            $('#siswa_nama').text(res.data.name);
            $('#siswa_nis').text(res.data.nis);
            $('#siswa_rayon').text(res.data.rayon);
            $('#siswa_rombel').text(res.data.rombel);
            $('#siswa_info').show();
        } else {
            alert(res.message);
        }
    });
});

$('#cari_barang').click(function() {
    let keyword = $('#barang_keyword').val();
    if (!keyword) return alert('Masukkan ID atau nama barang');
    
    $.post('{{ route("petugas.transaksi.cari_barang") }}', {keyword: keyword, _token: '{{ csrf_token() }}'}, function(res) {
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

$('#transaksiForm').submit(function(e) {
    if (!items.length) {
        e.preventDefault();
        alert('Minimal 1 barang dipinjam!');
        return false;
    }
});
</script>
@endpush
@endsection