@php
    // Memilih ikon berdasarkan kata pada nama menu.
    $ikonDari = function (string $t): string {
        $t = strtolower($t);

        return match (true) {
            str_contains($t, 'beranda') => 'bi-speedometer2',
            str_contains($t, 'mahasiswa') => 'bi-mortarboard',
            str_contains($t, 'dosen') => 'bi-person-badge',
            str_contains($t, 'mata kuliah'), str_contains($t, 'kelas') => 'bi-book',
            str_contains($t, 'krs') => 'bi-journal-check',
            str_contains($t, 'nilai') => 'bi-award',
            str_contains($t, 'jadwal') => 'bi-calendar-week',
            str_contains($t, 'sandi'), str_contains($t, 'password') => 'bi-key',
            default => 'bi-circle',
        };
    };
@endphp
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
                       @if (request()->is($pola)) aria-current="page" @endif><i class="bi {{ $ikonDari($label) }}" aria-hidden="true"></i><span>{{ $label }}</span></a>
                @else
                    <span class="nav-link disabled" aria-disabled="true">{{ $label }} <small>Segera</small></span>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
