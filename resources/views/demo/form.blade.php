@extends('layouts.app')

@section('title', $judul)

@section('content')
    <x-page-header :title="$judul" subtitle="Isi data berikut. Tanda * wajib diisi." />

    <div class="box form-narrow">
        {{-- Ganti action ke rute asli (mis. route('dosen.store')) saat controller backend siap. --}}
        <form method="POST" action="#" novalidate>
            @csrf

            @foreach ($fields as $f)
                <x-field :name="$f['name']" :label="$f['label']" :type="$f['type'] ?? 'text'"
                         :required="$f['required'] ?? false" :hint="$f['hint'] ?? null"
                         :options="$f['options'] ?? []" />
            @endforeach

            <div class="form-actions">
                <button type="submit" class="btn-sia">Simpan</button>
                <a href="{{ url($kembali) }}" class="btn-line">Batal</a>
            </div>
        </form>
    </div>
@endsection
