<h1>Data Dosen</h1>
@if (session('success')) <p>{{ session('success') }}</p> @endif

<form method="GET">
    <input name="q" value="{{ $q }}" placeholder="Cari NIDN atau nama">
    <button>Cari</button>
</form>
<a href="{{ route('admin.dosen.create') }}">+ Tambah</a>

<table border="1" cellpadding="6">
    <tr><th>NIDN/NIP</th><th>Nama</th><th>Akun</th><th>Aksi</th></tr>
    @forelse ($data as $d)
        <tr>
            <td>{{ $d->nidn }}</td><td>{{ $d->nama }}</td>
            <td>{{ $d->user_id ? 'Sudah' : 'Belum' }}</td>
            <td>
                <a href="{{ route('admin.dosen.edit', $d) }}">Ubah</a>
                <form method="POST" action="{{ route('admin.dosen.destroy', $d) }}"
                      style="display:inline" onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button>Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4">Belum ada data.</td></tr>
    @endforelse
</table>
{{ $data->links() }}