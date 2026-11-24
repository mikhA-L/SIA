@extends('layouts.app')

@section('title', 'Ubah Kata Sandi')

@section('content')
<div class="halaman halaman-kartu">
<h1>Ubah Kata Sandi</h1>
@if (session('success')) <p>{{ session('success') }}</p> @endif

<form method="POST" action="{{ route('akun.password.update') }}">
    @csrf @method('PUT')
    <div><label>Kata sandi lama</label>
        <input type="password" name="password_lama" required>
        @error('password_lama') <p>{{ $message }}</p> @enderror</div>
    <div><label>Kata sandi baru</label>
        <input type="password" name="password" required>
        @error('password') <p>{{ $message }}</p> @enderror</div>
    <div><label>Ulangi kata sandi baru</label>
        <input type="password" name="password_confirmation" required></div>
    <button type="submit">Simpan</button>
</form>
</div>
@endsection
