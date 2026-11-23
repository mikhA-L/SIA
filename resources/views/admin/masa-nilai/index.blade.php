<h1>Masa Input Nilai</h1>
@if (session('success')) <p>{{ session('success') }}</p> @endif

<p>Status saat ini: <strong>{{ $dibuka ? 'DIBUKA' : 'DITUTUP' }}</strong></p>

<form method="POST" action="{{ route('admin.masa-nilai.update') }}">
    @csrf @method('PUT')
    <input type="hidden" name="buka" value="{{ $dibuka ? 0 : 1 }}">
    <button>{{ $dibuka ? 'Tutup masa input nilai' : 'Buka masa input nilai' }}</button>
</form>
<p>Saat ditutup, dosen tidak dapat memasukkan atau mengubah nilai.</p>