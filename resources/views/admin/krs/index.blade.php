@extends('layouts.app')

@section('title', 'Persetujuan KRS')

@section('content')
<div class="page-head">
    <div>
        <h1><i class="bi bi-journal-check" aria-hidden="true"></i>Persetujuan KRS</h1>
        <p>Tinjau pengajuan KRS mahasiswa, lalu setujui atau tolak.</p>
    </div>
</div>

<div class="box p-0 overflow-hidden">
    <div class="table-tools" role="group" aria-label="Filter status">
        @foreach (['diajukan', 'disetujui', 'ditolak', 'semua'] as $s)
            <a href="{{ route('admin.krs.index', ['status' => $s]) }}"
               class="{{ $status === $s ? 'btn-sia' : 'btn-line' }} btn-sm-line"
               @if ($status === $s) aria-current="true" @endif>{{ ucfirst($s) }}</a>
        @endforeach
    </div>

    <div class="table-responsive">
        <table class="table sia-table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $p)
                    @php
                        $kelasChip = match ($p->status) {
                            'disetujui' => 'chip-ok',
                            'diajukan' => 'chip-wait',
                            'ditolak' => 'chip-no',
                            default => 'chip-muted',
                        };
                    @endphp
                    <tr>
                        <td>{{ $p->mahasiswa->nim }}</td>
                        <td>{{ $p->mahasiswa->nama }}</td>
                        <td>{{ $p->semester }}</td>
                        <td><span class="chip {{ $kelasChip }}">{{ ucfirst($p->status) }}</span></td>
                        <td>
                            <div class="aksi">
                                <a href="{{ route('admin.krs.show', $p) }}" class="btn-line btn-sm-line">Lihat</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($data->hasPages())
        <div class="table-foot">{{ $data->links() }}</div>
    @endif
</div>
@endsection