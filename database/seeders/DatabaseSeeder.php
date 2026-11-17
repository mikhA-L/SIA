<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun uji. Ganti kata sandi sebelum aplikasi dipasang online.
        $akun = [
            ['name' => 'Admin Prodi',      'username' => 'admin',      'email' => 'admin@sia.test',      'role' => 'admin'],
            ['name' => 'Dosen Contoh',     'username' => '198001012005', 'email' => 'dosen@sia.test',    'role' => 'dosen'],
            ['name' => 'Mahasiswa Contoh', 'username' => '3233111001', 'email' => 'mahasiswa@sia.test', 'role' => 'mahasiswa'],
        ];

        foreach ($akun as $data) {
            User::updateOrCreate(
                ['username' => $data['username']],
                $data + ['password' => Hash::make('password123')]
            );
        }
    }
}
