@extends('layouts.app')

@section('title', 'Ubah Mahasiswa')

@section('content')
<div class="halaman halaman-kartu">
<h1>Ubah Mahasiswa</h1>
<form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswa) }}">
    @method('PUT')
    @include('admin.mahasiswa._form')
</form>
</div>
@endsection
