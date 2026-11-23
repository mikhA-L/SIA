<?php

use Illuminate\Support\Facades\Route;

/*
 * Halaman contoh agar tampilan bisa dikerjakan tanpa menunggu backend.
 * Hapus file ini dan baris require di routes/web.php setelah modul asli jadi.
 * Hanya bisa dibuka oleh akun admin.
 */
Route::middleware(['auth', 'role:admin'])->prefix('demo')->group(function () {

    // Filter pencarian sederhana untuk data contoh.
    $saring = function ($semua, string $q) {
        $q = strtolower(trim($q));

        return $q === ''
            ? $semua
            : $semua->filter(fn ($r) => str_contains(strtolower(implode(' ', $r)), $q))->values();
    };

    // ---------- Mahasiswa (halaman asli dari kit pertama) ----------
    Route::get('/mahasiswa', function () use ($saring) {
        $rows = $saring(collect([
            ['nim' => '3233111001', 'nama' => 'Siti Rahmawati', 'angkatan' => '2023', 'status' => 'Aktif'],
            ['nim' => '3233111002', 'nama' => 'Budi Santoso', 'angkatan' => '2023', 'status' => 'Aktif'],
            ['nim' => '3233111003', 'nama' => 'Dewi Lestari', 'angkatan' => '2023', 'status' => 'Cuti'],
            ['nim' => '3223111004', 'nama' => 'Rizky Pratama', 'angkatan' => '2022', 'status' => 'Non-aktif'],
            ['nim' => '3243111005', 'nama' => 'Putri Anggraini', 'angkatan' => '2024', 'status' => 'Aktif'],
        ]), (string) request('q'));

        return view('demo.mahasiswa-index', ['rows' => $rows, 'q' => trim((string) request('q'))]);
    });
    Route::get('/mahasiswa/baru', fn () => view('demo.mahasiswa-form'));

    // ---------- Modul lain: satu konfigurasi per modul ----------
    $namaDosen = ['Dr. Hendra Wijaya, M.Kom.', 'Maya Sari, M.Pd.', 'Agus Prasetyo, M.T.'];
    $namaMatkul = ['Manajemen Proyek TI', 'Basis Data', 'Pemrograman Web', 'Basis Data Multimedia', 'Rekayasa Perangkat Lunak'];

    $modul = [
        'dosen' => [
            'judul' => 'Data dosen',
            'sub' => 'Kelola data dosen pengampu.',
            'tambahLabel' => 'Tambah dosen',
            'placeholder' => 'Cari NIP atau nama',
            'empty' => 'Belum ada data dosen.',
            'headers' => ['NIP', 'Nama', 'Email', 'Jumlah kelas', 'Status'],
            'keys' => ['nip', 'nama', 'email', 'kelas', 'status'],
            'data' => [
                ['nip' => '198001012005', 'nama' => $namaDosen[0], 'email' => 'hendra@sia.test', 'kelas' => '3', 'status' => 'Aktif'],
                ['nip' => '198505152010', 'nama' => $namaDosen[1], 'email' => 'maya@sia.test', 'kelas' => '2', 'status' => 'Aktif'],
                ['nip' => '197912312003', 'nama' => $namaDosen[2], 'email' => 'agus@sia.test', 'kelas' => '1', 'status' => 'Cuti'],
            ],
            'formJudul' => 'Tambah dosen',
            'fields' => [
                ['name' => 'nip', 'label' => 'NIP / NIDN', 'required' => true, 'hint' => 'Tidak boleh sama dengan dosen lain.'],
                ['name' => 'name', 'label' => 'Nama lengkap dan gelar', 'required' => true],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'required' => true,
                    'options' => ['Aktif' => 'Aktif', 'Cuti' => 'Cuti', 'Non-aktif' => 'Non-aktif']],
            ],
        ],
        'mata-kuliah' => [
            'judul' => 'Mata kuliah',
            'sub' => 'Kelola daftar mata kuliah dan bobot SKS.',
            'tambahLabel' => 'Tambah mata kuliah',
            'placeholder' => 'Cari kode atau nama',
            'empty' => 'Belum ada data mata kuliah.',
            'headers' => ['Kode', 'Nama mata kuliah', 'SKS', 'Semester'],
            'keys' => ['kode', 'nama', 'sks', 'semester'],
            'data' => [
                ['kode' => 'PTI301', 'nama' => $namaMatkul[0], 'sks' => '3', 'semester' => '5'],
                ['kode' => 'PTI302', 'nama' => $namaMatkul[1], 'sks' => '3', 'semester' => '3'],
                ['kode' => 'PTI303', 'nama' => $namaMatkul[2], 'sks' => '3', 'semester' => '4'],
                ['kode' => 'PTI304', 'nama' => $namaMatkul[3], 'sks' => '2', 'semester' => '5'],
                ['kode' => 'PTI305', 'nama' => $namaMatkul[4], 'sks' => '3', 'semester' => '5'],
            ],
            'formJudul' => 'Tambah mata kuliah',
            'fields' => [
                ['name' => 'kode', 'label' => 'Kode mata kuliah', 'required' => true, 'hint' => 'Kode harus unik.'],
                ['name' => 'nama', 'label' => 'Nama mata kuliah', 'required' => true],
                ['name' => 'sks', 'label' => 'SKS', 'type' => 'number', 'required' => true],
                ['name' => 'semester', 'label' => 'Semester', 'type' => 'select', 'required' => true,
                    'options' => array_combine(range(1, 8), range(1, 8))],
            ],
        ],
        'kelas' => [
            'judul' => 'Kelas',
            'sub' => 'Kelola kelas yang ditawarkan, jadwal, dan kuota.',
            'tambahLabel' => 'Tambah kelas',
            'placeholder' => 'Cari kode, mata kuliah, atau dosen',
            'empty' => 'Belum ada kelas.',
            'headers' => ['Kode kelas', 'Mata kuliah', 'Dosen', 'Jadwal', 'Ruang', 'Terisi / kuota'],
            'keys' => ['kode', 'matkul', 'dosen', 'jadwal', 'ruang', 'kuota'],
            'data' => [
                ['kode' => 'PTI301-A', 'matkul' => $namaMatkul[0], 'dosen' => $namaDosen[0], 'jadwal' => 'Senin 08.00-10.30', 'ruang' => 'R.301', 'kuota' => '28 / 35'],
                ['kode' => 'PTI302-A', 'matkul' => $namaMatkul[1], 'dosen' => $namaDosen[1], 'jadwal' => 'Selasa 10.00-12.30', 'ruang' => 'R.205', 'kuota' => '35 / 35'],
                ['kode' => 'PTI303-A', 'matkul' => $namaMatkul[2], 'dosen' => $namaDosen[2], 'jadwal' => 'Rabu 13.00-15.30', 'ruang' => 'Lab 2', 'kuota' => '20 / 30'],
            ],
            'formJudul' => 'Tambah kelas',
            'fields' => [
                ['name' => 'kode', 'label' => 'Kode kelas', 'required' => true, 'hint' => 'Contoh: PTI301-A'],
                ['name' => 'matkul', 'label' => 'Mata kuliah', 'type' => 'select', 'required' => true,
                    'options' => array_combine($namaMatkul, $namaMatkul)],
                ['name' => 'dosen', 'label' => 'Dosen pengampu', 'type' => 'select', 'required' => true,
                    'options' => array_combine($namaDosen, $namaDosen)],
                ['name' => 'hari', 'label' => 'Hari', 'type' => 'select', 'required' => true,
                    'options' => array_combine(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])],
                ['name' => 'jam_mulai', 'label' => 'Jam mulai', 'type' => 'time', 'required' => true],
                ['name' => 'jam_selesai', 'label' => 'Jam selesai', 'type' => 'time', 'required' => true],
                ['name' => 'ruang', 'label' => 'Ruang', 'required' => true],
                ['name' => 'kuota', 'label' => 'Kuota', 'type' => 'number', 'required' => true],
            ],
        ],
    ];

    foreach ($modul as $slug => $m) {
        Route::get("/{$slug}", function () use ($m, $slug, $saring) {
            $q = trim((string) request('q'));

            return view('demo.list', [
                'judul' => $m['judul'], 'sub' => $m['sub'], 'tambahLabel' => $m['tambahLabel'],
                'tambahUrl' => "/demo/{$slug}/baru", 'placeholder' => $m['placeholder'], 'empty' => $m['empty'],
                'headers' => $m['headers'], 'keys' => $m['keys'],
                'rows' => $saring(collect($m['data']), $q), 'q' => $q,
            ]);
        });

        Route::get("/{$slug}/baru", fn () => view('demo.form', [
            'judul' => $m['formJudul'], 'fields' => $m['fields'], 'kembali' => "/demo/{$slug}",
        ]));
    }
});
