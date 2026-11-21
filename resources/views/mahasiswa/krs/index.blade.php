<h1>KRS {{ $semester }}</h1>
<p>{{ $mhs->nim }} - {{ $mhs->nama }} (angkatan {{ $mhs->angkatan }})</p>
<p>Total SKS: {{ $totalSks }} / {{ $maksSks }}</p>

@if (session('success')) <p>{{ session('success') }}</p> @endif
@error('mata_kuliah_id') <p style="color:red">{{ $message }}</p> @enderror

<h2>Mata kuliah diambil</h2>
<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Aksi</th></tr>
    @forelse ($krs as $k)
        <tr>
            <td>{{ $k->mataKuliah->kode_mk }}</td>
            <td>{{ $k->mataKuliah->nama_mk }}</td>
            <td>{{ $k->mataKuliah->sks }}</td>
            <td>
                <form method="POST" action="{{ route('mahasiswa.krs.destroy', $k) }}"
                      onsubmit="return confirm('Hapus dari KRS?')">
                    @csrf @method('DELETE')
                    <button>Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4">Belum ada mata kuliah.</td></tr>
    @endforelse
</table>

<h2>Mata kuliah tersedia</h2>
<table border="1" cellpadding="6">
    <tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Aksi</th></tr>
    @forelse ($tersedia as $mk)
        <tr>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>{{ $mk->sks }}</td>
            <td>
                <form method="POST" action="{{ route('mahasiswa.krs.store') }}">
                    @csrf
                    <input type="hidden" name="mata_kuliah_id" value="{{ $mk->id }}">
                    <button>Ambil</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4">Tidak ada mata kuliah lain.</td></tr>
    @endforelse
</table>