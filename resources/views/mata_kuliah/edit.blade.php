<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah - SIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Mata Kuliah</h5>
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

                    <form action="{{ route('mata-kuliah.update', $mataKuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_mk" class="form-control" value="{{ old('kode_mk', $mataKuliah->kode_mk) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Mata Kuliah</label>
                            <input type="text" name="nama_mk" class="form-control" value="{{ old('nama_mk', $mataKuliah->nama_mk) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah SKS</label>
                                <input type="number" name="sks" class="form-control" value="{{ old('sks', $mataKuliah->sks) }}" min="1" max="6" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Semester</label>
                                <input type="number" name="semester" class="form-control" value="{{ old('semester', $mataKuliah->semester) }}" min="1" max="8" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>