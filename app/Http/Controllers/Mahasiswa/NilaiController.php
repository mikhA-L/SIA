<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function index()
    {
        $mhs = auth()->user()->mahasiswa;
        abort_unless($mhs, 403, 'Akun belum terhubung ke data mahasiswa.');

        $nilai = Nilai::with('mataKuliah')
            ->where('mahasiswa_id', $mhs->id)
            ->whereNotNull('nilai_huruf')
            ->get();

        return view('mahasiswa.nilai.index', [
            'mhs'         => $mhs,
            'perSemester' => $nilai->groupBy('semester'),
            'ipk'         => Nilai::hitungIndeks($nilai),
        ]);
    }
}