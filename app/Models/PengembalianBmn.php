<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianBmn extends Model
{
    /** @use HasFactory<\Database\Factories\PengembalianBmnFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function peminjamanBmn()
    {
        return $this->belongsTo(PeminjamanBmn::class);
    }
}
