<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanRuang extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamanRuangFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
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
