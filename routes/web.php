<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Auth\LoginController;

// Route landing page
Route::get('/', function () {
    return view('welcome');
});

// ============ ROUTE LOGIN MANUAL ============
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============ ROUTE UNTUK ADMIN ============
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Barang
    Route::resource('barang', BarangController::class);
    Route::post('/barang/{id}/stok', [BarangController::class, 'updateStok'])->name('barang.stok');
    
    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/{id}/approve', [TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::post('/transaksi/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    
    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/barang-dipinjam', [ReportController::class, 'barangDipinjam'])->name('report.barang_dipinjam');
    Route::get('/report/barang-hilang', [ReportController::class, 'barangHilang'])->name('report.barang_hilang');
    Route::get('/report/barang-rusak', [ReportController::class, 'barangRusak'])->name('report.barang_rusak');
    
    // Data Siswa
    Route::resource('siswa', SiswaController::class);
    
    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log_aktivitas.index');
});

// ============ ROUTE UNTUK PETUGAS ============
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Petugas\DashboardController::class, 'index'])->name('dashboard');
    
    // Transaksi
    Route::get('/transaksi', [App\Http\Controllers\Petugas\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [App\Http\Controllers\Petugas\TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [App\Http\Controllers\Petugas\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/cari-siswa', [App\Http\Controllers\Petugas\TransaksiController::class, 'cariSiswa'])->name('transaksi.cari_siswa');
    Route::post('/transaksi/cari-barang', [App\Http\Controllers\Petugas\TransaksiController::class, 'cariBarang'])->name('transaksi.cari_barang');
    Route::get('/transaksi/{id}/return', [App\Http\Controllers\Petugas\TransaksiController::class, 'returnForm'])->name('transaksi.return');
    Route::post('/transaksi/{id}/return', [App\Http\Controllers\Petugas\TransaksiController::class, 'processReturn'])->name('transaksi.process_return');
    
    // Report
    Route::get('/report', [App\Http\Controllers\Petugas\ReportController::class, 'index'])->name('report.index');
    Route::get('/report/barang-dipinjam', [App\Http\Controllers\Petugas\ReportController::class, 'barangDipinjam'])->name('report.barang_dipinjam');
    Route::get('/report/histori', [App\Http\Controllers\Petugas\ReportController::class, 'histori'])->name('report.histori');
    
    // Request Hapus
    Route::get('/request-hapus', [App\Http\Controllers\Petugas\RequestHapusController::class, 'index'])->name('request_hapus.index');
    Route::get('/request-hapus/{id}/create', [App\Http\Controllers\Petugas\RequestHapusController::class, 'create'])->name('request_hapus.create');
    Route::post('/request-hapus/{id}/store', [App\Http\Controllers\Petugas\RequestHapusController::class, 'store'])->name('request_hapus.store');
});
// ============ ROUTE UNTUK SISWA ============
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    
    // Peminjaman
    Route::get('/peminjaman/create', [App\Http\Controllers\Siswa\PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/store', [App\Http\Controllers\Siswa\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/cari-barang', [App\Http\Controllers\Siswa\PeminjamanController::class, 'cariBarang'])->name('peminjaman.cari_barang');
    Route::get('/peminjaman/success', [App\Http\Controllers\Siswa\PeminjamanController::class, 'success'])->name('peminjaman.success');
    
    // Riwayat
    Route::get('/riwayat', [App\Http\Controllers\Siswa\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [App\Http\Controllers\Siswa\RiwayatController::class, 'show'])->name('riwayat.show');
});