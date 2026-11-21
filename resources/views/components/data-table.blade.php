{{--
  Pemakaian:
  <x-data-table :headers="['NIM','Nama','Aksi']" :count="$rows->count()" :q="$q">
      <tr>...</tr>  (baris tabel)
      <x-slot:footer>{{ $paginator->links() }}</x-slot:footer>   (opsional)
  </x-data-table>
--}}
@props([
    'headers' => [],
    'count' => 0,
    'q' => null,
    'searchable' => true,
    'placeholder' => 'Cari...',
    'empty' => 'Belum ada data.',
])

<div class="box p-0">
    @if ($searchable)
        <form method="GET" action="{{ url()->current() }}" class="table-tools" role="search">
            <label for="q" class="visually-hidden">Cari data</label>
            <input id="q" name="q" type="search" value="{{ $q }}" class="form-control" placeholder="{{ $placeholder }}">
            <button class="btn-sia" type="submit">Cari</button>
            @if ($q)
                <a class="btn-line" href="{{ url()->current() }}">Hapus pencarian</a>
            @endif
        </form>
    @endif

    @if ($count > 0)
        <div class="table-responsive">
            <table class="table sia-table">
                <thead>
                    <tr>
                        @foreach ($headers as $h)
                            <th scope="col">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>{{ $slot }}</tbody>
            </table>
        </div>
        @isset($footer)
            <div class="table-foot">{{ $footer }}</div>
        @endisset
    @else
        <div class="empty">
            <p class="mb-0">{{ $q ? 'Tidak ada hasil untuk "' . $q . '".' : $empty }}</p>
        </div>
    @endif
</div>
