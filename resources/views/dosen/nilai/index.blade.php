<h1>Input Nilai</h1>
<p>Semester {{ $semester }}</p>

<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Mata kuliah</th><th>SKS</th><th>Peserta</th><th>Aksi</th></tr>
    @forelse ($mataKuliah as $mk)
        <tr>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>{{ $jumlah[$mk->id] ?? 0 }}</td>
            <td><a href="{{ route('dosen.nilai.show', $mk) }}">Isi nilai</a></td>
        </tr>
    @empty
        <tr><td colspan="5">Belum ada mata kuliah yang Anda ampu.</td></tr>
    @endforelse
</table>