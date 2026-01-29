<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    /** @use HasFactory<\Database\Factories\TandaTanganFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
