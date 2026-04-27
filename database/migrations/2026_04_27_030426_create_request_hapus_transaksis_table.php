<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_hapus_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('transaksis');
            $table->foreignId('id_petugas')->constrained('users');
            $table->foreignId('id_admin_yang_acc')->nullable()->constrained('users');
            $table->enum('status_request', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('alasan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_hapus_transaksis');
    }
};