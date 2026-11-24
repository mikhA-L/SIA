@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="halaman halaman-tabel">
<h1>Data Mahasiswa</h1>
@if (session('success')) <p>{{ session('success') }}</p> @endif

<form method="GET">
    <input name="q" value="{{ $q }}" placeholder="Cari NIM atau nama">
    <button>Cari</button>
</form>
<a href="{{ route('admin.mahasiswa.create') }}">+ Tambah</a>

<table border="1" cellpadding="6">
    <tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Angkatan</th><th>Akun</th><th>Aksi</th></tr>
    @forelse ($data as $m)
        <tr>
            <td>{{ $m->nim }}</td><td>{{ $m->nama }}</td>
            <td>{{ $m->prodi }}</td><td>{{ $m->angkatan }}</td>
            <td>{{ $m->user_id ? 'Sudah' : 'Belum' }}</td>
            <td>
                <a href="{{ route('admin.mahasiswa.edit', $m) }}">Ubah</a>
                <form method="POST" action="{{ route('admin.mahasiswa.destroy', $m) }}"
                      style="display:inline" onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button>Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6">Belum ada data.</td></tr>
    @endforelse
</table>
{{ $data->links() }}
</div>
@endsection
