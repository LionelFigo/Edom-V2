<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       // 1. Jalankan Seeder Prodi (Jika belum ada)
        $this->call([ProdiSeeder::class]);

        // 2. Buat Role (Ini yang belum ada di database Anda)
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'dosen']);
        Role::firstOrCreate(['name' => 'mahasiswa']);

        // 3. Buat Admin Default (Opsional)
        if (!User::where('email', 'admin@edom.com')->exists()) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@edom.com',
                'password' => Hash::make('password123'),
            ]);
            $admin->assignRole('admin');
        }

        $this->call([
        ProdiSeeder::class,
        ]);
    }
}