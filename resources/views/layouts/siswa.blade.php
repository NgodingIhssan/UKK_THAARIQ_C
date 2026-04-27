<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Siswa - @yield('title', 'Peminjaman Barang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #17a2b8;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #138496;
        }
        .sidebar .nav-link.active {
            background-color: #0f6674;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('siswa.dashboard') }}">
                <i class="fas fa-box"></i> Peminjaman Barang Sekolah
            </a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </span>
                <span class="navbar-text me-3">
                    <i class="fas fa-id-card"></i> {{ Auth::user()->siswa->nis ?? '-' }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 sidebar">
                <div class="nav flex-column mt-3">
                    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.peminjaman.create') }}" class="nav-link {{ request()->routeIs('siswa.peminjaman.*') ? 'active' : '' }}">
                        <i class="fas fa-plus"></i> Pinjam Barang
                    </a>
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#barcodeModal">
                        <i class="fas fa-qrcode"></i> Barcode Saya
                    </a>
                    <a href="{{ route('siswa.riwayat.index') }}" class="nav-link {{ request()->routeIs('siswa.riwayat.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Riwayat Peminjaman
                    </a>
                </div>
            </div>
            
            <div class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Modal Barcode -->
    <div class="modal fade" id="barcodeModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-qrcode"></i> Barcode Saya</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-1">Scan barcode ini untuk peminjaman</p>
                    <div class="bg-light p-3 rounded" style="font-size: 48px; font-family: monospace;">
                        {{ Auth::user()->siswa->barcode ?? 'BCR-001' }}
                    </div>
                    <p class="mt-2 small text-muted">{{ Auth::user()->siswa->nis ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @stack('scripts')
</body>
</html>