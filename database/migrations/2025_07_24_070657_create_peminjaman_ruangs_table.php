<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_ruangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemohon')->constrained('pegawais')->onDelete('restrict');
            $table->foreignId('petugas')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verifikator')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('penanggung_jawab')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('ruang_id')->constrained('ruangs')->onDelate('restrict');
            $table->string('signature_pemohon')->nullable();
            $table->string('signature_verifikator')->nullable();
            $table->string('signature_kasubag_tu')->nullable();
            $table->string('nomor');
            $table->string('substansi');
            $table->string('alat_khusus')->nullable();
            $table->dateTime('tanggal_penggunaan');
            $table->dateTime('tanggal_selesai');
            $table->string('keperluan');
            $table->string('status'); // Status = Draf | Pengajuan | Diterima | Disetujui | Ditolak
            $table->string('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_ruangs');
    }
};
