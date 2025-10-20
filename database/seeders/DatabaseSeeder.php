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
        // User::factory(10)->create();
        Jabatan::create([
            'nama_jabatan' => 'Pranata Komputer Ahli Pertama'
        ]);

        // Jabatan::create([
        //     'nama_jabatan' => 'Perencana Ahli Pertama'
        // ]);

        // Jabatan::create([
        //     'nama_jabatan' => 'Analis Kebijakan'
        // ]);

        // Jabatan::create([
        //     'nama_jabatan' => 'Pengelola Sistem Informasi'
        // ]);

        // Jabatan::create([
        //     'nama_jabatan' => 'Kepala Subbagian Tata Usaha'
        // ]);

        Pegawai::create([
            'jabatan_id' => 1,
            'nama' => 'Amanda Agung Permata, S.Tr.Kom',
            'nip' => '200112272025061002'
        ]);

        // Pegawai::create([
        //     'jabatan_id' => 2,
        //     'nama' => 'Muhammad Aris Abdillah, S.Mat.',
        //     'nip' => '000000000000000002'
        // ]);

        // Pegawai::create([
        //     'jabatan_id' => 4,
        //     'nama' => 'Faisal Yanto Setiawan, S.Tr.Kom',
        //     'nip' => '000000000000000003'
        // ]);

        // Pegawai::create([
        //     'jabatan_id' => 3,
        //     'nama' => 'M. Syukur A., S.E.',
        //     'nip' => '000000000000000004'
        // ]);

        // Pegawai::create([
        //     'jabatan_id' => 3,
        //     'nama' => 'Emil Tito Karunia, S.Tr.Kom',
        //     'nip' => '000000000000000005'
        // ]);

        // Pegawai::create([
        //     'jabatan_id' => 3,
        //     'nama' => 'Edi',
        //     'nip' => '000000000000000006'
        // ]);

        // Pegawai::create([
        //     'jabatan_id' => 5,
        //     'nama' => 'Nur Muhammaditya Priatmaja Husnanto, S.Sos., M.Si.',
        //     'nip' => '198504082010121010'
        // ]);

        User::create([
            'pegawai_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'Super Admin',
        ]);

        // User::create([
        //     'pegawai_id' => 1,
        //     'email' => 'agungtsmn.p@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'role' => 'Petugas',
        // ]);

        // User::create([
        //     'pegawai_id' => 4,
        //     'email' => 'pj@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'role' => 'Penanggung Jawab',
        // ]);

        // User::create([
        //     'pegawai_id' => 5,
        //     'email' => 'verif@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'role' => 'Verifikator',
        // ]);

        // User::create([
        //     'pegawai_id' => 7,
        //     'email' => 'kasubag@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'role' => 'Kasubag TU',
        // ]);

        // User::create([
        //     'pegawai_id' => 6,
        //     'email' => 'p.kendaraan@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'role' => 'Verifikator',
        // ]);

        Ruang::create([
            'nama' => 'Ruang Sidang Utama Lt.1',
        ]);

        Ruang::create([
            'nama' => 'Ruang Sidang Lt.2',
        ]);

        Ruang::create([
            'nama' => 'Lab. Kompetensi',
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
