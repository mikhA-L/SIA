@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="halaman halaman-kartu">
<h1>Tambah Dosen</h1>
<form method="POST" action="{{ route('admin.dosen.store') }}">
    @include('admin.dosen._form')
</form>
</div>
@endsection
