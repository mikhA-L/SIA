@extends('layouts.app')

@section('title', 'Halaman')

@section('content')
<div class="halaman halaman-tabel">
<h1>KRS {{ $pengajuan->mahasiswa->nama }}</h1>
<p>{{ $pengajuan->mahasiswa->nim }} | {{ $pengajuan->semester }} | Status: <strong>{{ $pengajuan->status }}</strong></p>
<a href="{{ route('admin.krs.index') }}">&larr; Kembali</a>

@if ($errors->any())
    <ul style="color:red">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
@endif

<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Mata kuliah</th><th>SKS</th></tr>
    @foreach ($krs as $k)
        <tr>
            <td>{{ $k->mataKuliah->kode_mk }}</td>
            <td>{{ $k->mataKuliah->nama_mk }}</td>
            <td>{{ $k->mataKuliah->sks }}</td>
        </tr>
    @endforeach
</table>
<p>Total SKS: {{ $totalSks }}</p>

@if ($pengajuan->catatan) <p>Catatan: {{ $pengajuan->catatan }}</p> @endif

@if ($pengajuan->status === 'diajukan')
    <form method="POST" action="{{ route('admin.krs.update', $pengajuan) }}">
        @csrf @method('PUT')
        <div><label>Catatan (wajib jika ditolak)</label><br>
            <textarea name="catatan" rows="3" cols="40">{{ old('catatan') }}</textarea></div>
        <button name="aksi" value="setujui">Setujui</button>
        <button name="aksi" value="tolak">Tolak</button>
    </form>
@endif
</div>
@endsection
