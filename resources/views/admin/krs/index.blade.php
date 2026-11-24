@extends('layouts.app')

@section('title', 'Persetujuan KRS')

@section('content')
<div class="halaman halaman-tabel">
<h1>Persetujuan KRS</h1>
@if (session('success')) <p>{{ session('success') }}</p> @endif

<p>
    Filter:
    @foreach (['diajukan', 'disetujui', 'ditolak', 'semua'] as $s)
        <a href="{{ route('admin.krs.index', ['status' => $s]) }}"
           @if ($status === $s) style="font-weight:bold" @endif>{{ ucfirst($s) }}</a>
    @endforeach
</p>

<table border="1" cellpadding="6">
    <tr><th>NIM</th><th>Nama</th><th>Semester</th><th>Status</th><th>Aksi</th></tr>
    @forelse ($data as $p)
        <tr>
            <td>{{ $p->mahasiswa->nim }}</td>
            <td>{{ $p->mahasiswa->nama }}</td>
            <td>{{ $p->semester }}</td>
            <td>{{ $p->status }}</td>
            <td><a href="{{ route('admin.krs.show', $p) }}">Lihat</a></td>
        </tr>
    @empty
        <tr><td colspan="5">Tidak ada data.</td></tr>
    @endforelse
</table>
{{ $data->links() }}
</div>
@endsection
