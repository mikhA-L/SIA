<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class AkunContohSeeder extends Seeder
{
    public function run(): void
    {
        // Data master mahasiswa contoh (belum punya akun, dipakai untuk uji register)
        foreach ([
            ['2024001', 'Budi Santoso', 'PTIK', 2024],
            ['2024002', 'Siti Aminah', 'PTIK', 2024],
            ['2023001', 'Rudi Hartono', 'PTIK', 2023],
        ] as [$nim, $nama, $prodi, $angkatan]) {
            Mahasiswa::firstOrCreate(['nim' => $nim], [
                'nama' => $nama, 'prodi' => $prodi, 'angkatan' => $angkatan,
            ]);
        }

        // Tautkan akun mahasiswa buatan Ariel ke data master
        $user = User::where('username', '3233111001')->first();
        if ($user) {
            Mahasiswa::updateOrCreate(['nim' => '3233111001'], [
                'nama'     => $user->name,
                'prodi'    => 'PTIK',
                'angkatan' => 2023, // NIM 323... = angkatan 2023, ubah kalau berbeda
                'user_id'  => $user->id,
            ]);
        }
    }
}