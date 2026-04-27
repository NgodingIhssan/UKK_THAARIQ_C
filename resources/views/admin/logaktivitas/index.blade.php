@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-history"></i> Log Aktivitas</h2>
    <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari kegiatan..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Waktu</th>
                        <th>Pelaku</th>
                        <th>Kegiatan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->timestamp)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $log->user->name }} ({{ $log->user->role }})</td>
                        <td>
                            <span class="badge bg-primary">{{ $log->kegiatan }}</span>
                        </td>
                        <td>{{ $log->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada log aktivitas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</div>
@endsection