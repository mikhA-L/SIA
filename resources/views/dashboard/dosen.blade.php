@extends('layouts.app')

@section('title', 'Beranda dosen')

@section('content')
    <h1>Beranda dosen</h1>
    <div class="box">
        <p class="mb-2">Halo, {{ auth()->user()->name }}. Login berhasil.</p>
    </div>
@endsection
