@extends('layouts.app')

@section('title', 'Ubah Dosen')

@section('content')
<div class="halaman halaman-kartu">
<h1>Ubah Dosen</h1>
<form method="POST" action="{{ route('admin.dosen.update', $dosen) }}">
    @method('PUT')
    @include('admin.dosen._form')
</form>
</div>
@endsection
