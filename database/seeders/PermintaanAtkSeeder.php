<?php

namespace Database\Seeders;

use App\Models\PermintaanAtk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermintaanAtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermintaanAtk::create([
            'user_id' => 2,
            'nomor' => '002/LK02.02/RT-BMN/2025',
            'verifikator' => 4,
            'penanggung_jawab' => 5,
            'status' => 'Pengajuan',
            'atk' => [
                [
                    'nama' => 'Laptop',
                    'jumlah' => 2,
                    'satuan' => 'Unit',
                    'lokasi_penggunaan' => 'Ruang A',
                ],
                [
                    'nama' => 'Proyektor',
                    'jumlah' => 1,
                    'satuan' => 'Unit',
                    'lokasi_penggunaan' => 'Ruang A',
                ],
            ],
        ]);
    }
}
