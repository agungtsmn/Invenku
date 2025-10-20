<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBmn extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamanBmnFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['bmn' => 'array'];

    public function pengembalianBmn()
    {
        return $this->hasOne(PengembalianBmn::class);
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
