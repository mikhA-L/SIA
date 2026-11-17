@extends('layouts.app')

@section('title', 'Beranda dosen')

@section('content')
    <h1>Beranda dosen</h1>
    <div class="box">
        <p class="mb-2">Halo, {{ auth()->user()->name }}. Login berhasil.</p>
        <p class="mb-0 text-secondary">Menu input nilai akan ditambahkan di Sprint 3.</p>
    </div>
@endsection
