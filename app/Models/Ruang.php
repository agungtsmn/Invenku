<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    /** @use HasFactory<\Database\Factories\RuangFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function peminjamanRuang()
    {
        return $this->hasMany(PeminjamanRuang::class);
    }
}
