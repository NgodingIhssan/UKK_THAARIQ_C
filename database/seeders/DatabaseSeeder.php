<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori
        $kategori = [
            ['nama_kategori' => 'Elektronik'],
            ['nama_kategori' => 'ATK'],
            ['nama_kategori' => 'Peralatan Kelas'],
        ];
        foreach ($kategori as $k) {
            Kategori::create($k);
        }

        // Users
        $admin = User::create([
            'name' => 'Admin 1',
            'email' => 'thaariq@sekolah.com',
            'password' => Hash::make('123'),
            'role' => 'admin'
        ]);

        $petugas = User::create([
            'name' => 'Petugas 1',
            'email' => 'wwan@sekolah.com',
            'password' => Hash::make('123'),
            'role' => 'petugas'
        ]);

        $userSiswa = User::create([
            'name' => 'Budi',
            'email' => 'budi@siswa.com',
            'password' => Hash::make('123'),
            'role' => 'siswa'
        ]);

        // Siswa
        Siswa::create([
            'user_id' => $userSiswa->id,
            'nis' => '12001',
            'rayon' => 'Rayon A',
            'rombel' => 'XII RPL 1',
            'barcode' => 'BCR-001'
        ]);

        // Barang
        Barang::create([
            'nama_barang' => 'Laptop ASUS',
            'id_kategori' => 1, // Elektronik
            'stok_tersedia' => 10,
            'denda_hilang' => 5000000,
            'denda_rusak' => 1000000
        ]);

        Barang::create([
            'nama_barang' => 'Proyektor',
            'id_kategori' => 1, // Elektronik
            'stok_tersedia' => 5,
            'denda_hilang' => 3000000,
            'denda_rusak' => 500000
        ]);

        Barang::create([
            'nama_barang' => 'Buku Tulis',
            'id_kategori' => 2, // ATK
            'stok_tersedia' => 100,
            'denda_hilang' => 5000,
            'denda_rusak' => 2000
        ]);

        Barang::create([
            'nama_barang' => 'Pulpen',
            'id_kategori' => 2, // ATK
            'stok_tersedia' => 200,
            'denda_hilang' => 2000,
            'denda_rusak' => 1000
        ]);

        Barang::create([
            'nama_barang' => 'Meja Lipat',
            'id_kategori' => 3, // Peralatan Kelas
            'stok_tersedia' => 20,
            'denda_hilang' => 150000,
            'denda_rusak' => 50000
        ]);

        Barang::create([
            'nama_barang' => 'Kursi',
            'id_kategori' => 3, // Peralatan Kelas
            'stok_tersedia' => 50,
            'denda_hilang' => 100000,
            'denda_rusak' => 30000
        ]);
    }
}