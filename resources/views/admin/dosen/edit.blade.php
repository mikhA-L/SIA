<h1>Ubah Dosen</h1>
<form method="POST" action="{{ route('admin.dosen.update', $dosen) }}">
    @method('PUT')
    @include('admin.dosen._form')
</form>