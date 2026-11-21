<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah - SIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Mata Kuliah</h5>
            <a href="{{ route('mata-kuliah.create') }}" class="btn btn-light btn-sm fw-bold">+ Tambah Mata Kuliah</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th width="10%" class="text-center">SKS</th>
                            <th width="12%" class="text-center">Semester</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataKuliahs as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $mk->kode_mk }}</span></td>
                                <td>{{ $mk->nama_mk }}</td>
                                <td class="text-center">{{ $mk->sks }}</td>
                                <td class="text-center">{{ $mk->semester }}</td>
                                <td class="text-center">
                                    <a href="{{ route('mata-kuliah.edit', $mk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('mata-kuliah.destroy', $mk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data mata kuliah. Silakan tambah data baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>