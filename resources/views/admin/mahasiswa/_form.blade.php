@csrf
<div><label>NIM</label>
    <input name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
    @error('nim') <p>{{ $message }}</p> @enderror</div>
<div><label>Nama</label>
    <input name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required>
    @error('nama') <p>{{ $message }}</p> @enderror</div>
<div><label>Prodi</label>
    <input name="prodi" value="{{ old('prodi', $mahasiswa->prodi ?? '') }}" required>
    @error('prodi') <p>{{ $message }}</p> @enderror</div>
<div><label>Angkatan</label>
    <input name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? '') }}" required>
    @error('angkatan') <p>{{ $message }}</p> @enderror</div>
<button type="submit">Simpan</button>
<a href="{{ route('admin.mahasiswa.index') }}">Batal</a>