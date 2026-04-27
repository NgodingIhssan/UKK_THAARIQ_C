@extends('layouts.petugas')

@section('title', 'Request Hapus')

@section('content')
<h2><i class="fas fa-trash-alt"></i> Request Hapus Transaksi</h2>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>ID Transaksi</th><th>Siswa</th><th>Alasan</th><th>Status</th><th>Admin ACC</th></tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr>
                    <td>{{ $req->transaksi->id }}</td>
                    <td>{{ $req->transaksi->siswa->user->name ?? '-' }}</td>
                    <td>{{ $req->alasan }}</td>
                    <td>
                        <span class="badge bg-{{ $req->status_request == 'pending' ? 'warning' : ($req->status_request == 'disetujui' ? 'success' : 'danger') }}">
                            {{ $req->status_request }}
                        </span>
                    </td>
                    <td>{{ $req->admin->name ?? '-' }}</td>
                </tr>
                @empty
                <td><td colspan="5" class="text-center">Belum ada request hapus</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $requests->links() }}
    </div>
</div>
@endsection