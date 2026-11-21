@extends('layouts.app')

@section('title', 'Data mahasiswa')

@section('content')
    <x-page-header title="Data mahasiswa" subtitle="Kelola data mahasiswa Prodi PTIK.">
        <x-slot:actions>
            <a href="{{ url('/demo/mahasiswa/baru') }}" class="btn-sia">Tambah mahasiswa</a>
        </x-slot:actions>
    </x-page-header>

    <x-data-table :headers="['NIM', 'Nama', 'Angkatan', 'Status', 'Aksi']"
                  :count="$rows->count()" :q="$q"
                  placeholder="Cari NIM atau nama" empty="Belum ada data mahasiswa.">
        @foreach ($rows as $r)
            @php
                $chip = ['Aktif' => 'chip-ok', 'Cuti' => 'chip-wait', 'Non-aktif' => 'chip-no'][$r['status']] ?? 'chip-wait';
            @endphp
            <tr>
                <td>{{ $r['nim'] }}</td>
                <td>{{ $r['nama'] }}</td>
                <td>{{ $r['angkatan'] }}</td>
                <td><span class="chip {{ $chip }}">{{ $r['status'] }}</span></td>
                <td>
                    <div class="aksi">
                        <a href="{{ url('/demo/mahasiswa/baru') }}" class="btn-line btn-sm-line">Ubah</a>
                        {{-- Pola hapus: form DELETE dengan konfirmasi. Ganti action ke rute asli saat backend siap. --}}
                        <form method="POST" action="#" class="m-0"
                              onsubmit="return confirm('Hapus data {{ $r['nama'] }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-line btn-sm-line btn-danger-line">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-data-table>
@endsection
