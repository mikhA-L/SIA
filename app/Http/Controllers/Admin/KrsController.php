<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\KrsPengajuan;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'diajukan');

        $data = KrsPengajuan::with('mahasiswa')
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->orderBy('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.krs.index', compact('data', 'status'));
    }

    public function show(KrsPengajuan $pengajuan)
    {
        $krs = Krs::with('mataKuliah')
            ->where('mahasiswa_id', $pengajuan->mahasiswa_id)
            ->where('semester', $pengajuan->semester)
            ->get();

        return view('admin.krs.show', [
            'pengajuan' => $pengajuan,
            'krs'       => $krs,
            'totalSks'  => $krs->sum(fn ($k) => $k->mataKuliah->sks),
        ]);
    }

    public function update(Request $request, KrsPengajuan $pengajuan)
    {
        abort_unless($pengajuan->status === 'diajukan', 403, 'KRS ini tidak sedang menunggu persetujuan.');

        $data = $request->validate([
            'aksi'    => ['required', 'in:setujui,tolak'],
            'catatan' => ['nullable', 'string', 'max:500', 'required_if:aksi,tolak'],
        ], [
            'catatan.required_if' => 'Catatan wajib diisi saat menolak KRS.',
        ]);

        $pengajuan->update([
            'status'  => $data['aksi'] === 'setujui' ? 'disetujui' : 'ditolak',
            'catatan' => $data['catatan'] ?? null,
        ]);

        return redirect()->route('admin.krs.index')
            ->with('success', $data['aksi'] === 'setujui' ? 'KRS disetujui.' : 'KRS ditolak.');
    }
}