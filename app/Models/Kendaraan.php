<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    /** @use HasFactory<\Database\Factories\KendaraanFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function peminjamanKendaraan()
    {
        return $this->hasMany(PeminjamanKendaraan::class);
    }
}
