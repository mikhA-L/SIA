<h1>KRS {{ $semester }}</h1>
<p>{{ $mhs->nim }} - {{ $mhs->nama }} (angkatan {{ $mhs->angkatan }})</p>
<p>Total SKS: {{ $totalSks }} / {{ $maksSks }}</p>

@if (session('success')) <p>{{ session('success') }}</p> @endif
@error('mata_kuliah_id') <p style="color:red">{{ $message }}</p> @enderror

<h2>Mata kuliah diambil</h2>
<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Jadwal</th><th>Ruang</th><th>Aksi</th></tr>
    @forelse ($krs as $k)
        @php $m = $k->mataKuliah; @endphp
        <tr>
            <td>{{ $m->kode_mk }}</td>
            <td>{{ $m->nama_mk }}</td>
            <td>{{ $m->sks }}</td>
            <td>{{ $m->hari ? $m->hari.' '.substr($m->jam_mulai,0,5).'-'.substr($m->jam_selesai,0,5) : '-' }}</td>
            <td>{{ $m->ruang ?? '-' }}</td>
            <td>
                <form method="POST" action="{{ route('mahasiswa.krs.destroy', $k) }}"
                      onsubmit="return confirm('Hapus dari KRS?')">
                    @csrf @method('DELETE')
                    <button>Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6">Belum ada mata kuliah.</td></tr>
    @endforelse
</table>

<h2>Mata kuliah tersedia</h2>
<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Jadwal</th><th>Ruang</th><th>Sisa kuota</th><th>Aksi</th></tr>
    @forelse ($tersedia as $mk)
        @php $sisa = ($mk->kuota ?? 0) - ($terisi[$mk->id] ?? 0); @endphp
        <tr>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>{{ $mk->hari ? $mk->hari.' '.substr($mk->jam_mulai,0,5).'-'.substr($mk->jam_selesai,0,5) : '-' }}</td>
            <td>{{ $mk->ruang ?? '-' }}</td>
            <td>{{ $sisa > 0 ? $sisa : 'Penuh' }}</td>
            <td>
                <form method="POST" action="{{ route('mahasiswa.krs.store') }}">
                    @csrf
                    <input type="hidden" name="mata_kuliah_id" value="{{ $mk->id }}">
                    <button @disabled($sisa <= 0)>Ambil</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="7">Tidak ada mata kuliah lain.</td></tr>
    @endforelse
</table>