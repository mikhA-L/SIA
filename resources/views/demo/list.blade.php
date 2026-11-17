@extends('layouts.app')

@section('title', $judul)

@section('content')
    <x-page-header :title="$judul" :subtitle="$sub">
        <x-slot:actions>
            <a href="{{ url($tambahUrl) }}" class="btn-sia">{{ $tambahLabel }}</a>
        </x-slot:actions>
    </x-page-header>

    <x-data-table :headers="array_merge($headers, ['Aksi'])" :count="$rows->count()" :q="$q"
                  :placeholder="$placeholder" :empty="$empty">
        @foreach ($rows as $r)
            <tr>
                @foreach ($keys as $k)
                    <td>
                        @if ($k === 'status')
                            @php $chip = ['Aktif' => 'chip-ok', 'Cuti' => 'chip-wait', 'Non-aktif' => 'chip-no'][$r[$k]] ?? 'chip-wait'; @endphp
                            <span class="chip {{ $chip }}">{{ $r[$k] }}</span>
                        @else
                            {{ $r[$k] }}
                        @endif
                    </td>
                @endforeach
                <td>
                    <div class="aksi">
                        <a href="{{ url($tambahUrl) }}" class="btn-line btn-sm-line">Ubah</a>
                        <form method="POST" action="#" class="m-0"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-line btn-sm-line btn-danger-line">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-data-table>
@endsection
