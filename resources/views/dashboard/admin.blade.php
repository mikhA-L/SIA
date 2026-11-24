@extends('layouts.app')

@section('title', 'Beranda admin')

@section('content')
    @php
        // Alamat dicari dari daftar rute yang benar-benar ada, jadi kartu tanpa halaman otomatis nonaktif.
        $uris = collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
            ->filter(fn ($r) => in_array('GET', $r->methods()) && ! str_contains($r->uri(), '{'))
            ->map(fn ($r) => $r->uri());
        $cari = fn (string $pola) => $uris->first(fn ($u) => preg_match($pola, $u));

        $kartu = [
            ['Data mahasiswa', 'Kelola data mahasiswa dan status akunnya.', $cari('#^admin/mahasiswa$#'), 'bi-mortarboard'],
            ['Data dosen', 'Kelola data dosen pengampu.', $cari('#^admin/dosen$#'), 'bi-person-badge'],
            ['Mata kuliah dan kelas', 'Atur mata kuliah, kelas, jadwal, dan kuota.', $cari('#^admin/(mata[-_]?kuliah|kelas|akademik)$#'), 'bi-book'],
            ['Masa input nilai', 'Buka atau tutup masa pengisian nilai oleh dosen.', $cari('#^admin/masa-nilai$#'), 'bi-award'],
            ['Ubah kata sandi', 'Ganti kata sandi akun Anda.', $cari('#^akun/password$#'), 'bi-key'],
        ];
    @endphp

    <div class="page-head">
        <div>
            <h1>Beranda admin</h1>
            <p>Selamat datang, {{ auth()->user()->name }}. Pilih menu yang ingin dikelola.</p>
        </div>
    </div>

    <div class="kartu-grid">
        @foreach ($kartu as [$judul, $ket, $uri, $ikon])
            @if ($uri)
                <a href="{{ url($uri) }}" class="kartu">
                    <span class="kartu-ikon"><i class="bi {{ $ikon }}" aria-hidden="true"></i></span>
                    <span><strong>{{ $judul }}</strong><span class="ket">{{ $ket }}</span></span>
                </a>
            @else
                <div class="kartu mati" aria-disabled="true">
                    <span class="kartu-ikon"><i class="bi {{ $ikon }}" aria-hidden="true"></i></span>
                    <span><strong>{{ $judul }}</strong><span class="ket">Segera tersedia.</span></span>
                </div>
            @endif
        @endforeach
    </div>
@endsection
