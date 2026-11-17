@extends('layouts.app')

@section('title', 'Tambah mahasiswa')

@section('content')
    <x-page-header title="Tambah mahasiswa" subtitle="Isi data berikut. Tanda * wajib diisi." />

    <div class="box form-narrow">
        {{-- Ganti action ke rute asli (mis. route('mahasiswa.store')) saat controller backend siap. --}}
        <form method="POST" action="#" novalidate>
            @csrf

            <x-field name="nim" label="NIM" required hint="NIM tidak boleh sama dengan mahasiswa lain." />
            <x-field name="name" label="Nama lengkap" required />
            <x-field name="email" label="Email" type="email" required />
            <x-field name="angkatan" label="Angkatan" type="select" required
                     :options="['2022' => '2022', '2023' => '2023', '2024' => '2024', '2025' => '2025']" />
            <x-field name="status" label="Status" type="select" required
                     :options="['Aktif' => 'Aktif', 'Cuti' => 'Cuti', 'Non-aktif' => 'Non-aktif']" />

            <div class="form-actions">
                <button type="submit" class="btn-sia">Simpan</button>
                <a href="{{ url('/demo/mahasiswa') }}" class="btn-line">Batal</a>
            </div>
        </form>
    </div>
@endsection
