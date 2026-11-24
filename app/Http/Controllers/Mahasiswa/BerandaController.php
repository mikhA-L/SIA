<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\KrsPengajuan;

class BerandaController extends Controller
{
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    public function __invoke()
    {
        $mhs = auth()->user()->mahasiswa;
        abort_unless($mhs, 403, 'Akun belum terhubung ke data mahasiswa.');

        $semester = KrsController::SEMESTER;
        $status = KrsPengajuan::where('mahasiswa_id', $mhs->id)
            ->where('semester', $semester)
            ->value('status') ?? 'draf';

        $jadwal = collect();
        $tanpaJadwal = 0;

        // Jadwal hanya dari KRS yang sudah disetujui (FR-21).
        if ($status === 'disetujui') {
            $matkul = Krs::with('mataKuliah')
                ->where('mahasiswa_id', $mhs->id)
                ->where('semester', $semester)
                ->get()
                ->pluck('mataKuliah');

            $tanpaJadwal = $matkul->filter(fn ($mk) => ! $mk->hari)->count();
            $urutan = array_flip(self::HARI);

            $jadwal = $matkul
                ->filter(fn ($mk) => $mk->hari)
                ->sortBy('jam_mulai')
                ->groupBy(fn ($mk) => ucfirst(strtolower($mk->hari)))
                ->sortBy(fn ($grup, $hari) => $urutan[$hari] ?? 99);
        }

        return view('dashboard.mahasiswa', [
            'semester' => $semester,
            'status' => $status,
            'jadwal' => $jadwal,
            'tanpaJadwal' => $tanpaJadwal,
            'hariIni' => self::HARI[now('Asia/Jakarta')->dayOfWeekIso - 1],
            'totalSks' => $jadwal->flatten()->sum('sks'),
        ]);
    }
}