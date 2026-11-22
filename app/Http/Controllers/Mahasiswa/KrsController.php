<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    private const SEMESTER = '2026/2027 Ganjil';
    private const MAKS_SKS = 24;

    private function mahasiswa()
    {
        $mhs = auth()->user()->mahasiswa;
        abort_unless($mhs, 403, 'Akun belum terhubung ke data mahasiswa.');
        return $mhs;
    }

    private function krsSaya($mhsId)
    {
        return Krs::with('mataKuliah')
            ->where('mahasiswa_id', $mhsId)
            ->where('semester', self::SEMESTER)
            ->get();
    }

    public function index()
    {
        $mhs = $this->mahasiswa();
        $krs = $this->krsSaya($mhs->id);

        $tersedia = MataKuliah::whereNotIn('id', $krs->pluck('mata_kuliah_id'))
            ->orderBy('kode_mk')
            ->get();

        return view('mahasiswa.krs.index', [
            'mhs'      => $mhs,
            'krs'      => $krs,
            'tersedia' => $tersedia,
            'totalSks' => $krs->sum(fn ($k) => $k->mataKuliah->sks),
            'maksSks'  => self::MAKS_SKS,
            'semester' => self::SEMESTER,
        ]);
    }

    public function store(Request $request)
    {
        $mhs  = $this->mahasiswa();
        $data = $request->validate([
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
        ]);

        $krs = $this->krsSaya($mhs->id);

        if ($krs->contains('mata_kuliah_id', (int) $data['mata_kuliah_id'])) {
            return back()->withErrors(['mata_kuliah_id' => 'Mata kuliah ini sudah diambil.']);
        }

        $mk = MataKuliah::findOrFail($data['mata_kuliah_id']);
        $totalSks = $krs->sum(fn ($k) => $k->mataKuliah->sks);

        if ($totalSks + $mk->sks > self::MAKS_SKS) {
            return back()->withErrors([
                'mata_kuliah_id' => 'Total SKS melebihi batas ' . self::MAKS_SKS . '.',
            ]);
        }

        Krs::create([
            'mahasiswa_id'   => $mhs->id,
            'mata_kuliah_id' => $mk->id,
            'semester'       => self::SEMESTER,
        ]);

        return back()->with('success', 'Mata kuliah ditambahkan ke KRS.');
    }

    public function destroy(Krs $krs)
    {
        abort_unless($krs->mahasiswa_id === $this->mahasiswa()->id, 403);
        $krs->delete();

        return back()->with('success', 'Mata kuliah dihapus dari KRS.');
    }
}