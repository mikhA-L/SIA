<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\KrsPengajuan;
use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KrsController extends Controller
{
    public const SEMESTER = '2026/2027 Ganjil';
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

    private function pengajuan($mhsId): KrsPengajuan
    {
        return KrsPengajuan::firstOrCreate(
            ['mahasiswa_id' => $mhsId, 'semester' => self::SEMESTER],
            ['status' => 'draf']
        );
    }

    private function terkunci($mhsId): bool
    {
        return in_array($this->pengajuan($mhsId)->status, ['diajukan', 'disetujui'], true);
    }

    private function bentrok(MataKuliah $a, MataKuliah $b): bool
    {
        if (! $a->hari || ! $b->hari || $a->hari !== $b->hari) {
            return false;
        }
        if (! $a->jam_mulai || ! $a->jam_selesai || ! $b->jam_mulai || ! $b->jam_selesai) {
            return false;
        }
        return $a->jam_mulai < $b->jam_selesai && $b->jam_mulai < $a->jam_selesai;
    }

    public function index()
    {
        $mhs = $this->mahasiswa();
        $krs = $this->krsSaya($mhs->id);

        $tersedia = MataKuliah::whereNotIn('id', $krs->pluck('mata_kuliah_id'))
            ->orderBy('kode_mk')->get();

        $terisi = Krs::where('semester', self::SEMESTER)
            ->selectRaw('mata_kuliah_id, count(*) as total')
            ->groupBy('mata_kuliah_id')
            ->pluck('total', 'mata_kuliah_id');

        return view('mahasiswa.krs.index', [
            'mhs'      => $mhs,
            'krs'      => $krs,
            'tersedia' => $tersedia,
            'terisi'   => $terisi,
            'totalSks' => $krs->sum(fn ($k) => $k->mataKuliah->sks),
            'maksSks'  => self::MAKS_SKS,
            'semester' => self::SEMESTER,
            'pengajuan' => $this->pengajuan($mhs->id),
        ]);
    }

    public function store(Request $request)
    {
        $mhs  = $this->mahasiswa();
        $data = $request->validate([
            'mata_kuliah_id' => ['required', 'exists:mata_kuliahs,id'],
        ]);

        if ($this->terkunci($mhs->id)) {
            return back()->withErrors(['mata_kuliah_id' => 'KRS sudah diajukan dan tidak dapat diubah.']);
        }

        // Transaksi + kunci baris: kuota tidak terlampaui walau dua mahasiswa memilih bersamaan (NFR-07)
        $galat = DB::transaction(function () use ($mhs, $data) {
            $mk  = MataKuliah::lockForUpdate()->findOrFail($data['mata_kuliah_id']);
            $krs = $this->krsSaya($mhs->id);

            if ($krs->contains('mata_kuliah_id', $mk->id)) {
                return 'Mata kuliah ini sudah diambil.';
            }

            $totalSks = $krs->sum(fn ($k) => $k->mataKuliah->sks);
            if ($totalSks + $mk->sks > self::MAKS_SKS) {
                return 'Total SKS melebihi batas ' . self::MAKS_SKS . '.';
            }

            foreach ($krs as $k) {
                if ($this->bentrok($k->mataKuliah, $mk)) {
                    return 'Jadwal bentrok dengan ' . $k->mataKuliah->nama_mk
                        . ' (' . $k->mataKuliah->hari . ' '
                        . substr($k->mataKuliah->jam_mulai, 0, 5) . '-'
                        . substr($k->mataKuliah->jam_selesai, 0, 5) . ').';
                }
            }

            $terisi = Krs::where('mata_kuliah_id', $mk->id)
                ->where('semester', self::SEMESTER)->count();
            if ($mk->kuota && $terisi >= $mk->kuota) {
                return 'Kuota kelas penuh.';
            }

            Krs::create([
                'mahasiswa_id'   => $mhs->id,
                'mata_kuliah_id' => $mk->id,
                'semester'       => self::SEMESTER,
            ]);
            return null;
        });

        if ($galat) {
            return back()->withErrors(['mata_kuliah_id' => $galat]);
        }
        return back()->with('success', 'Mata kuliah ditambahkan ke KRS.');
    }

    public function destroy(Krs $krs)
    {
        $mhs = $this->mahasiswa();
        abort_unless($krs->mahasiswa_id === $mhs->id, 403);

        if ($this->terkunci($mhs->id)) {
            return back()->withErrors(['mata_kuliah_id' => 'KRS sudah diajukan dan tidak dapat diubah.']);
        }

        $krs->delete();
        return back()->with('success', 'Mata kuliah dihapus dari KRS.');
    }

    public function ajukan()
    {
        $mhs = $this->mahasiswa();
        $p = $this->pengajuan($mhs->id);

        if (! in_array($p->status, ['draf', 'ditolak'], true)) {
            return back()->withErrors(['mata_kuliah_id' => 'KRS sudah diajukan.']);
        }
        if ($this->krsSaya($mhs->id)->isEmpty()) {
            return back()->withErrors(['mata_kuliah_id' => 'KRS masih kosong.']);
        }

        $p->update(['status' => 'diajukan', 'catatan' => null]);
        return back()->with('success', 'KRS diajukan untuk persetujuan admin.');
    }
}