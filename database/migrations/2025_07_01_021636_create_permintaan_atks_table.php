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
        Schema::create('permintaan_atks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemohon')->constrained('pegawais')->onDelete('restrict');
            $table->foreignId('petugas')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verifikator')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('penanggung_jawab')->nullable()->constrained('users')->nullOnDelete();
            $table->string('signature_pemohon')->nullable();
            $table->string('signature_verifikator')->nullable();
            $table->string('signature_kasubag_tu')->nullable();
            $table->string('nomor');
            $table->string('jenis'); // ATK / Suvenir
            $table->date('tanggal');
            $table->string('lokasi');
            $table->longText('atk');
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
        Schema::dropIfExists('permintaan_atks');
    }
};
