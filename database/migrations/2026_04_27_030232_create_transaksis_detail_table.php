<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('id_barang')->constrained('barangs');
            $table->integer('jumlah');
            $table->enum('kondisi_pinjam', ['baik', 'kurang_baik', 'rusak'])->default('baik');
            $table->enum('kondisi_kembali', ['baik', 'kurang_baik', 'rusak', 'hilang'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};