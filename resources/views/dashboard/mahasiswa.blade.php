@extends('layouts.app')

@section('title', 'Beranda mahasiswa')

@section('content')
<div class="page-head">
    <div>
        <h1><i class="bi bi-speedometer2" aria-hidden="true"></i>Beranda</h1>
        <p>Halo, {{ auth()->user()->name }}. Semester {{ $semester }}.</p>
    </div>
    <a href="{{ route('mahasiswa.krs.index') }}" class="btn-line">
        <i class="bi bi-journal-check" aria-hidden="true"></i>Buka KRS
    </a>
</div>

<h2 class="box-title">Jadwal kuliah</h2>

@if ($status !== 'disetujui')
    <div class="box">
        <p class="mb-2">
            Jadwal tampil setelah KRS Anda disetujui admin. Status KRS saat ini:
            @php
                $chip = match ($status) {
                    'diajukan' => 'chip-wait',
                    'ditolak' => 'chip-no',
                    default => 'chip-muted',
                };
            @endphp
            <span class="chip {{ $chip }}">{{ ucfirst($status) }}</span>
        </p>
        <a href="{{ route('mahasiswa.krs.index') }}" class="btn-sia">
            <i class="bi bi-arrow-right" aria-hidden="true"></i>Ke halaman KRS
        </a>
    </div>
@elseif ($jadwal->isEmpty())
    <div class="box empty">Belum ada mata kuliah yang berjadwal.</div>
@else
    <div class="kartu-grid">
        @foreach ($jadwal as $hari => $daftar)
            <section class="box {{ $hari === $hariIni ? 'border-warning' : '' }}" aria-label="Jadwal {{ $hari }}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="box-title mb-0">{{ $hari }}</h3>
                    @if ($hari === $hariIni)
                        <span class="chip chip-wait">Hari ini</span>
                    @endif
                </div>
                <ul class="list-unstyled mb-0">
                    @foreach ($daftar as $mk)
                        <li class="py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                            <strong>{{ $mk->nama_mk }}</strong>
                            <div class="muted small">
                                {{ $mk->kode_mk }} &middot; {{ $mk->sks }} SKS
                            </div>
                            <div class="small">
                                <i class="bi bi-clock" aria-hidden="true"></i>
                                {{ substr($mk->jam_mulai, 0, 5) }}&ndash;{{ substr($mk->jam_selesai, 0, 5) }}
                                @if (array_key_exists('ruang', $mk->getAttributes()) && $mk->ruang)
                                    &middot; <i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $mk->ruang }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endforeach
    </div>

    <p class="muted small mt-3">
        Total {{ $totalSks }} SKS.
        @if ($tanpaJadwal > 0)
            {{ $tanpaJadwal }} mata kuliah belum punya jadwal.
        @endif
    </p>
@endif
@endsection