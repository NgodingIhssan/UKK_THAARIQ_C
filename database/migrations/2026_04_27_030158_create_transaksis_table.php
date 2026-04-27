<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswas');
            $table->foreignId('id_petugas')->constrained('users');
            $table->date('tgl_pinjam');
            $table->date('tgl_harus_kembali');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', ['menunggu_acc', 'dipinjam', 'dikembalikan', 'ditolak'])->default('menunggu_acc');
            $table->decimal('denda_total', 10, 2)->default(0);
            $table->text('keterangan_denda')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};