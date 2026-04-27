<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petugas - @yield('title', 'Peminjaman Barang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #28a745;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #218838;
        }
        .sidebar .nav-link.active {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('petugas.dashboard') }}">
                <i class="fas fa-box"></i> Petugas Peminjaman Barang
            </a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
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
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('petugas.transaksi.create') }}" class="nav-link {{ request()->routeIs('petugas.transaksi.create') ? 'active' : '' }}">
                        <i class="fas fa-plus"></i> Peminjaman Baru
                    </a>
                    <a href="{{ route('petugas.transaksi.index') }}" class="nav-link {{ request()->routeIs('petugas.transaksi.index') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Daftar Transaksi
                    </a>
                    <a href="{{ route('petugas.report.index') }}" class="nav-link {{ request()->routeIs('petugas.report.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Report
                    </a>
                    <a href="{{ route('petugas.request_hapus.index') }}" class="nav-link {{ request()->routeIs('petugas.request_hapus.*') ? 'active' : '' }}">
                        <i class="fas fa-trash-alt"></i> Request Hapus
                    </a>
                </div>
            </div>
            
            <div class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    @stack('scripts')
</body>
</html>