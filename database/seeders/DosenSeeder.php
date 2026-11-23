<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('username', '198001012005')->first();

        $dosen = Dosen::firstOrCreate(['nidn' => '198001012005'], [
            'nama'    => $user->name ?? 'Dosen Contoh',
            'user_id' => $user?->id,
        ]);

        // Untuk demo: mata kuliah yang belum punya dosen diampu dosen contoh
        MataKuliah::whereNull('dosen_id')->update(['dosen_id' => $dosen->id]);
    }
}