@php
    // [label, url, pola rute aktif, sudah tersedia?]
    // Ubah false menjadi true saat modul sudah jadi. Ganti url demo dengan rute asli setelah modul backend selesai.
    $menus = [
        'admin' => [
            ['Beranda', '/admin', 'admin', true],
            ['Data mahasiswa', '/admin/mahasiswa', 'admin/mahasiswa*', true],
            ['Data dosen', '/demo/dosen', 'demo/dosen*', false],
            ['Mata kuliah', '/admin/mata-kuliah', 'admin/mata-kuliah*', true],
            ['Kelas', '/demo/kelas', 'demo/kelas*', false],
            ['Persetujuan KRS', '/admin/krs', 'admin/krs*', false],
        ],
        'dosen' => [
            ['Beranda', '/dosen', 'dosen', true],
            ['Input nilai', '/dosen/nilai', 'dosen/nilai*', false],
        ],
        'mahasiswa' => [
            ['Beranda', '/mahasiswa', 'mahasiswa', true],
            ['KRS', '/mahasiswa/krs', 'mahasiswa/krs*', true],
            ['Nilai', '/mahasiswa/nilai', 'mahasiswa/nilai*', false],
            ['Jadwal kuliah', '/mahasiswa/jadwal', 'mahasiswa/jadwal*', false],
        ],
    ];
    $items = $menus[auth()->user()->role] ?? [];
@endphp

<nav>
    <ul class="menu">
        @foreach ($items as [$label, $url, $pola, $siap])
            <li>
                @if ($siap)
                    <a href="{{ url($url) }}" class="nav-link {{ request()->is($pola) ? 'active' : '' }}"
                       @if (request()->is($pola)) aria-current="page" @endif>{{ $label }}</a>
                @else
                    <span class="nav-link disabled" aria-disabled="true">{{ $label }} <small>Segera</small></span>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
