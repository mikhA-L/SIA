<h1>Nilai dan Transkrip</h1>
<p>{{ $mhs->nim }} - {{ $mhs->nama }}</p>
<p><strong>IPK: {{ number_format($ipk, 2) }}</strong></p>

@forelse ($perSemester as $semester => $daftar)
    <h2>{{ $semester }} (IPS: {{ number_format(\App\Models\Nilai::hitungIndeks($daftar), 2) }})</h2>
    <table border="1" cellpadding="6">
        <tr><th>Kode</th><th>Mata kuliah</th><th>SKS</th><th>Angka</th><th>Huruf</th></tr>
        @foreach ($daftar as $n)
            <tr>
                <td>{{ $n->mataKuliah->kode_mk }}</td>
                <td>{{ $n->mataKuliah->nama_mk }}</td>
                <td>{{ $n->mataKuliah->sks }}</td>
                <td>{{ $n->nilai_angka }}</td>
                <td>{{ $n->nilai_huruf }}</td>
            </tr>
        @endforeach
    </table>
@empty
    <p>Belum ada nilai.</p>
@endforelse