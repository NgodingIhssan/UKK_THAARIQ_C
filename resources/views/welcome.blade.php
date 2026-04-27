<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Peminjaman Barang Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .feature-card {
            transition: transform 0.3s;
            border-radius: 10px;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-box"></i> Peminjaman Barang Sekolah
            </a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-light">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Sistem Peminjaman Barang</h1>
            <p class="lead mt-3">Kelola peminjaman barang sekolah dengan mudah, cepat, dan terstruktur</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg mt-4">
                <i class="fas fa-sign-in-alt"></i> Mulai Sekarang
            </a>
        </div>
    </div>

    <!-- Fitur Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-boxes fa-4x text-primary mb-3"></i>
                        <h5 class="card-title">Kelola Barang</h5>
                        <p class="card-text">Data barang lengkap dengan 3 kategori: Elektronik, ATK, dan Peralatan Kelas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-exchange-alt fa-4x text-success mb-3"></i>
                        <h5 class="card-title">Transaksi</h5>
                        <p class="card-text">Peminjaman dan pengembalian barang dengan sistem barcode/NIS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="fas fa-chart-bar fa-4x text-info mb-3"></i>
                        <h5 class="card-title">Laporan</h5>
                        <p class="card-text">Report peminjaman, barang hilang, barang rusak, dan rekap siswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <small>&copy; 2025 Sistem Peminjaman Barang Sekolah</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>