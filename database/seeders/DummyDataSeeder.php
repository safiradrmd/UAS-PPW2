<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Data Pekerjaan
        $pekerjaanList = ['Software Engineer', 'HR Specialist', 'Digital Marketer', 'Accountant', 'Product Manager'];
        $pekerjaanIds = [];

        foreach ($pekerjaanList as $job) {
            $id = DB::table('pekerjaan')->insertGetId([
                'nama' => $job,
                'deskripsi' => 'Deskripsi untuk posisi ' . $job,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $pekerjaanIds[] = $id;
        }

        // 2. Buat 50 Data Pegawai
        for ($i = 1; $i <= 50; $i++) {
            DB::table('pegawai')->insert([
                'nama' => 'Pegawai Dummy ' . $i,
                'email' => 'pegawai' . $i . '@example.com',
                'pekerjaan_id' => $pekerjaanIds[array_rand($pekerjaanIds)], // Pilih random pekerjaan
                'gender' => ($i % 2 == 0) ? 'male' : 'female',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
