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
        Schema::create('peminjaman_bmns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemohon')->constrained('pegawais')->onDelete('restrict');
            $table->foreignId('petugas')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verifikator')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('penanggung_jawab')->nullable()->constrained('users')->nullOnDelete();
            $table->string('signature_pemohon')->nullable();
            $table->string('signature_verifikator')->nullable();
            $table->string('signature_kasubag_tu')->nullable();
            $table->string('nomor');
            $table->longText('bmn'); // [Nama, Merek, NUP, Jumlah, Satuan]
            $table->integer('lama_pinjam'); // Dalam Hari
            $table->string('lokasi_penggunaan');
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
        Schema::dropIfExists('peminjaman_bmns');
    }
};
