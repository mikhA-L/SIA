<h1>Tambah Dosen</h1>
<form method="POST" action="{{ route('admin.dosen.store') }}">
    @include('admin.dosen._form')
</form>