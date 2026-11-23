<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah - SIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Mata Kuliah Baru</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mata-kuliah.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_mk" class="form-control" value="{{ old('kode_mk') }}" placeholder="Contoh: TI101" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <input type="text" name="nama_mk" class="form-control" value="{{ old('nama_mk') }}" placeholder="Contoh: Pemrograman Web" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah SKS</label>
                                <input type="number" name="sks" class="form-control" value="{{ old('sks') }}" min="1" max="6" placeholder="1 - 6" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ old('semester') }}" min="1" max="8" placeholder="1 - 8" required>
                            </div>
                        </div>
                    
                        @php $x = $mata_kuliah ?? $mataKuliah ?? null; @endphp
                        <div><label>Hari</label>
                            <select name="hari">
                                <option value="">-</option>
                                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                    <option value="{{ $h }}" @selected(old('hari', optional($x)->hari) === $h)>{{ $h }}</option>
                                @endforeach
                            </select>
                            @error('hari') <p>{{ $message }}</p> @enderror</div>
                        <div><label>Jam mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', optional($x)->jam_mulai ? substr($x->jam_mulai, 0, 5) : '') }}">
                            @error('jam_mulai') <p>{{ $message }}</p> @enderror</div>
                        <div><label>Jam selesai</label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', optional($x)->jam_selesai ? substr($x->jam_selesai, 0, 5) : '') }}">
                            @error('jam_selesai') <p>{{ $message }}</p> @enderror</div>
                        <div><label>Ruang</label>
                            <input name="ruang" value="{{ old('ruang', optional($x)->ruang) }}">
                            @error('ruang') <p>{{ $message }}</p> @enderror</div>
                        <div><label>Kuota</label>
                            <input type="number" name="kuota" min="1" value="{{ old('kuota', optional($x)->kuota ?? 40) }}" required>
                            @error('kuota') <p>{{ $message }}</p> @enderror</div>
                        <div><label>Dosen pengampu</label>
                            <select name="dosen_id">
                                <option value="">- Belum ditentukan -</option>
                                @foreach (\App\Models\Dosen::orderBy('nama')->get() as $d)
                                    <option value="{{ $d->id }}" @selected(old('dosen_id', optional($x)->dosen_id) == $d->id)>{{ $d->nama }}</option>
                                @endforeach
                            </select>
                            @error('dosen_id') <p>{{ $message }}</p> @enderror</div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>