@extends('layouts.app')

@section('title', 'KRS ' . $pengajuan->mahasiswa->nama)

@section('content')
@php
    $kelasChip = match ($pengajuan->status) {
        'disetujui' => 'chip-ok',
        'diajukan' => 'chip-wait',
        'ditolak' => 'chip-no',
        default => 'chip-muted',
    };
@endphp

<div class="page-head">
    <div>
        <h1><i class="bi bi-journal-check" aria-hidden="true"></i>KRS {{ $pengajuan->mahasiswa->nama }}</h1>
        <p>
            {{ $pengajuan->mahasiswa->nim }} &middot; Semester {{ $pengajuan->semester }} &middot;
            <span class="chip {{ $kelasChip }}">{{ ucfirst($pengajuan->status) }}</span>
        </p>
    </div>
    <a href="{{ route('admin.krs.index') }}" class="btn-line">
        <i class="bi bi-arrow-left" aria-hidden="true"></i>Kembali
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box p-0 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table sia-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Mata kuliah</th>
                    <th class="text-end">SKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($krs as $k)
                    <tr>
                        <td>{{ $k->mataKuliah->kode_mk }}</td>
                        <td>{{ $k->mataKuliah->nama_mk }}</td>
                        <td class="text-end">{{ $k->mataKuliah->sks }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total SKS</th>
                    <th class="text-end">{{ $totalSks }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@if ($pengajuan->catatan)
    <div class="box mb-4">
        <h2 class="box-title">Catatan</h2>
        <p class="mb-0">{{ $pengajuan->catatan }}</p>
    </div>
@endif

@if ($pengajuan->status === 'diajukan')
    <div class="box form-narrow">
        <h2 class="box-title">Keputusan</h2>
        <form method="POST" action="{{ route('admin.krs.update', $pengajuan) }}">
            @csrf
            @method('PUT')

            <label for="catatan" class="form-label">
                Catatan <span class="text-muted fw-normal">(wajib jika ditolak)</span>
            </label>
            <textarea id="catatan" name="catatan" rows="3"
                      class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="field-error">{{ $message }}</div>
            @enderror

            <div class="form-actions">
                <button type="submit" name="aksi" value="setujui" class="btn-sia">
                    <i class="bi bi-check-lg" aria-hidden="true"></i>Setujui
                </button>
                <button type="submit" name="aksi" value="tolak" class="btn-line btn-danger-line"
                        onclick="return confirm('Tolak KRS ini?')">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>Tolak
                </button>
            </div>
        </form>
    </div>
@endif
@endsection