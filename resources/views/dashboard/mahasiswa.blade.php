@extends('layouts.app')

@section('title', 'Beranda mahasiswa')

@section('content')
    <h1>Beranda mahasiswa</h1>
    <div class="box">
        <p class="mb-2">Halo, {{ auth()->user()->name }}. Login berhasil.</p>
        <p class="mb-0 text-secondary">Menu KRS akan ditambahkan di Sprint 2, dan lihat nilai di Sprint 3.</p>
    </div>
@endsection
