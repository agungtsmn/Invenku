<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanAtk extends Model
{
    /** @use HasFactory<\Database\Factories\PermintaanAtkFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['atk' => 'array'];

    public function fPemohon()
    {
        return $this->belongsTo(Pegawai::class, 'pemohon');
    }

    public function fPetugas()
    {
        return $this->belongsTo(User::class, 'petugas');
    }

    public function fKatim()
    {
        return $this->belongsTo(User::class, 'katim');
    }

    public function fPetugasBmn()
    {
        return $this->belongsTo(User::class, 'petugas_bmn');
    }
}
