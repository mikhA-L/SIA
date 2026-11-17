@extends('layouts.app')

@section('title', 'Beranda admin prodi')

@section('content')
    <h1>Beranda admin prodi</h1>
    <div class="box">
        <p class="mb-2">Halo, {{ auth()->user()->name }}. Login berhasil.</p>
        <p class="mb-0 text-secondary">Menu data master akan ditambahkan di Sprint 1, dan persetujuan KRS di Sprint 2.</p>
    </div>
@endsection
