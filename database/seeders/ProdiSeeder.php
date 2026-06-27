<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodi')->insert([
            ['nama_prodi' => 'Teknik Informatika'],
            ['nama_prodi' => 'Sistem Informasi'],
            ['nama_prodi' => 'Teknik Elektro'],
            ['nama_prodi' => 'Teknik Mesin'],
            ['nama_prodi' => 'Akuntansi'],
        ]);
    }
}
