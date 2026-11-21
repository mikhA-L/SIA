<h1>Tambah Mahasiswa</h1>
<form method="POST" action="{{ route('admin.mahasiswa.store') }}">
    @include('admin.mahasiswa._form')
</form>