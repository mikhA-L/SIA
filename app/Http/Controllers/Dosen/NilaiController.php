<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Pengaturan;
use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // Harus sama dengan semester di KrsController mahasiswa
    private const SEMESTER = '2026/2027 Ganjil';

    private function dosen()
    {
        $dosen = auth()->user()->dosen;
        abort_unless($dosen, 403, 'Akun belum terhubung ke data dosen.');
        return $dosen;
    }

    /** Pastikan mata kuliah memang diampu dosen yang login. */
    private function milikDosen(MataKuliah $mataKuliah)
    {
        $dosen = $this->dosen();
        abort_unless($mataKuliah->dosen_id === $dosen->id, 403, 'Bukan mata kuliah yang Anda ampu.');
        return $dosen;
    }

    public function index()
    {
        $dosen = $this->dosen();
        $mataKuliah = $dosen->mataKuliah()->orderBy('kode_mk')->get();

        $jumlah = Krs::where('semester', self::SEMESTER)
            ->whereIn('mata_kuliah_id', $mataKuliah->pluck('id'))
            ->selectRaw('mata_kuliah_id, count(*) as total')
            ->groupBy('mata_kuliah_id')
            ->pluck('total', 'mata_kuliah_id');

        return view('dosen.nilai.index', [
            'mataKuliah' => $mataKuliah,
            'jumlah'     => $jumlah,
            'semester'   => self::SEMESTER,
        ]);
    }

    public function show(MataKuliah $mataKuliah)
    {
        $this->milikDosen($mataKuliah);

        $peserta = Krs::with('mahasiswa')
            ->where('mata_kuliah_id', $mataKuliah->id)
            ->where('semester', self::SEMESTER)
            ->get()
            ->sortBy(fn ($k) => $k->mahasiswa->nim);

        $nilai = Nilai::where('mata_kuliah_id', $mataKuliah->id)
            ->where('semester', self::SEMESTER)
            ->get()
            ->keyBy('mahasiswa_id');

        return view('dosen.nilai.show', [
            'mataKuliah' => $mataKuliah,
            'peserta'    => $peserta,
            'nilai'      => $nilai,
            'semester'   => self::SEMESTER,
            'dibuka' => Pengaturan::nilaiDibuka(),
        ]);
    }

    public function store(Request $request, MataKuliah $mataKuliah)
    {
        $this->milikDosen($mataKuliah);

        if (! Pengaturan::nilaiDibuka()) {
        return back()->withErrors(['nilai' => 'Masa penginputan nilai telah berakhir.']);
        }

        $request->validate([
            'nilai'   => ['required', 'array'],
            'nilai.*' => ['nullable', 'numeric', 'between:0,100'],
        ], [
            'nilai.*.numeric' => 'Nilai harus berupa angka.',
            'nilai.*.between' => 'Nilai harus antara 0 dan 100.',
        ]);

        // Hanya mahasiswa yang benar-benar mengambil mata kuliah ini (ada di KRS)
        $idPeserta = Krs::where('mata_kuliah_id', $mataKuliah->id)
            ->where('semester', self::SEMESTER)
            ->pluck('mahasiswa_id')
            ->all();

        $tersimpan = 0;
        foreach ($request->input('nilai') as $mahasiswaId => $angka) {
            if ($angka === null || $angka === '') {
                continue;                       // dikosongkan = dilewati
            }
            if (! in_array((int) $mahasiswaId, $idPeserta, true)) {
                continue;                       // bukan peserta, abaikan
            }

            Nilai::updateOrCreate(
                [
                    'mahasiswa_id'   => $mahasiswaId,
                    'mata_kuliah_id' => $mataKuliah->id,
                    'semester'       => self::SEMESTER,
                ],
                [
                    'nilai_angka' => $angka,
                    'nilai_huruf' => Nilai::konversi((float) $angka),
                ]
            );
            $tersimpan++;
        }

        return redirect()
            ->route('dosen.nilai.show', $mataKuliah)
            ->with('success', "$tersimpan nilai disimpan.");
    }
}