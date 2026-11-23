@csrf
<div><label>NIDN/NIP</label>
    <input name="nidn" value="{{ old('nidn', $dosen->nidn ?? '') }}" required @isset($dosen) readonly @endisset>
    @error('nidn') <p>{{ $message }}</p> @enderror
    @isset($dosen) <small>NIDN dipakai sebagai username login, jadi tidak dapat diubah.</small> @endisset</div>
<div><label>Nama</label>
    <input name="nama" value="{{ old('nama', $dosen->nama ?? '') }}" required>
    @error('nama') <p>{{ $message }}</p> @enderror</div>

@unless (isset($dosen))
    <div><label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <p>{{ $message }}</p> @enderror</div>
    <div><label>Kata sandi awal</label>
        <input type="password" name="password" required>
        @error('password') <p>{{ $message }}</p> @enderror
        <small>Dosen login dengan NIDN dan kata sandi ini, lalu mengubahnya lewat menu Ubah kata sandi.</small></div>
@endunless

<button type="submit">Simpan</button>
<a href="{{ route('admin.dosen.index') }}">Batal</a>