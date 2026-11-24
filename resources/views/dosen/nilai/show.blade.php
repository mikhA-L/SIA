@extends('layouts.app')

@section('title', 'Halaman')

@section('content')
<div class="halaman halaman-tabel">
<h1>Nilai: {{ $mataKuliah->kode_mk }} - {{ $mataKuliah->nama_mk }}</h1>
<p>Semester {{ $semester }} | {{ $mataKuliah->sks }} SKS</p>
<a href="{{ route('dosen.nilai.index') }}">&larr; Kembali</a>
@unless ($dibuka)
    <p style="color:red">Masa penginputan nilai ditutup. Hubungi admin untuk membukanya.</p>
@endunless

@if (session('success')) <p>{{ session('success') }}</p> @endif
@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('dosen.nilai.store', $mataKuliah) }}">
    @csrf
    <table border="1" cellpadding="6">
        <tr><th>NIM</th><th>Nama</th><th>Nilai angka (0-100)</th><th>Huruf</th></tr>
        @forelse ($peserta as $k)
            @php $n = $nilai[$k->mahasiswa_id] ?? null; @endphp
            <tr>
                <td>{{ $k->mahasiswa->nim }}</td>
                <td>{{ $k->mahasiswa->nama }}</td>
                <td>
                    <input type="number" step="0.01" min="0" max="100"
                           name="nilai[{{ $k->mahasiswa_id }}]"
                           value="{{ old('nilai.'.$k->mahasiswa_id, $n->nilai_angka ?? '') }}"
                           @disabled(! $dibuka)>
                </td>
                <td>{{ $n->nilai_huruf ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada mahasiswa yang mengambil mata kuliah ini.</td></tr>
        @endforelse
    </table>
    @if ($peserta->count() && $dibuka)
        <button type="submit">Simpan nilai</button>
    @endif
</form>
</div>
@endsection
