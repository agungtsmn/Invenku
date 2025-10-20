<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanKendaraan extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamanKendaraanFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function fPemohon()
    {
        return $this->belongsTo(Pegawai::class, 'pemohon');
    }

    public function fPetugas()
    {
        return $this->belongsTo(User::class, 'petugas');
    }

    public function fPenanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab');
    }

    public function fVerif()
    {
        return $this->belongsTo(User::class, 'verifikator');
    }
}
