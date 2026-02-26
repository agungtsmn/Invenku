<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Kendaraan;
use App\Models\Pegawai;
use App\Models\PermintaanAtk;
use App\Models\Ruang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'pegawai_id' => 91,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'Super Admin',
        ]);

        Kendaraan::create([
            'jenis' => 'Motor',
            'merek' => 'Yamaha',
            'no_polisi' => 'B 3783 JGK',
            'nama' => 'Lexi',
        ]);

        Kendaraan::create([
            'jenis' => 'Motor',
            'merek' => 'Yamaha',
            'no_polisi' => 'B 9390 JGK',
            'nama' => 'Vario',
        ]);

        Kendaraan::create([
            'jenis' => 'Mobil',
            'merek' => 'Toyota',
            'no_polisi' => 'B 4234 JGK',
            'nama' => 'Avanza',
        ]);

        Kendaraan::create([
            'jenis' => 'Mobil',
            'merek' => 'Toyota',
            'no_polisi' => 'B 2534 JGK',
            'nama' => 'Kijang Innova',
        ]);
    }
}
