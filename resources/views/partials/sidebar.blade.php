@php
    // [label, url, pola rute aktif, sudah tersedia?]
    // Ubah false menjadi true saat modul sudah jadi. Ganti url demo dengan rute asli setelah modul backend selesai.
    $menus = [
    'admin' => [
            ['Beranda', '/admin', 'admin', true],
            ['Data mahasiswa', '/admin/mahasiswa', 'admin/mahasiswa*', true],
            ['Data dosen', '/admin/dosen', 'admin/dosen*', true],
            ['Mata kuliah dan kelas', '/admin/mata-kuliah', 'admin/mata-kuliah*', true],
            ['Masa input nilai', '/admin/masa-nilai', 'admin/masa-nilai*', true],
            ['Ubah kata sandi', '/akun/password', 'akun/password*', true],
        ],
        'dosen' => [
            ['Beranda', '/dosen', 'dosen', true],
            ['Input nilai', '/dosen/nilai', 'dosen/nilai*', true],
            ['Ubah kata sandi', '/akun/password', 'akun/password*', true],
        ],
        'mahasiswa' => [
            ['Beranda', '/mahasiswa', 'mahasiswa', true],
            ['KRS', '/mahasiswa/krs', 'mahasiswa/krs*', true],
            ['Nilai', '/mahasiswa/nilai', 'mahasiswa/nilai*', true],
            ['Ubah kata sandi', '/akun/password', 'akun/password*', true],
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
