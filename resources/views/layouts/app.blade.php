<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | SIA PTIK UNIMED</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/sia.css') }}?v={{ @filemtime(public_path('css/sia.css')) }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <button class="btn-ghost d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#menuMobile" aria-controls="menuMobile">Menu</button>
            <a class="brand" href="{{ auth()->user()->homePath() }}">SIA PTIK</a>
            <span class="who d-none d-sm-inline">{{ auth()->user()->name }} ({{ auth()->user()->roleLabel() }})</span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn-ghost">Keluar</button>
            </form>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar d-none d-lg-block" aria-label="Menu utama">
            @include('partials.sidebar')
        </aside>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile" aria-labelledby="menuMobileLabel">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title fs-5" id="menuMobileLabel">Menu</h2>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup menu"></button>
            </div>
            <div class="offcanvas-body px-0">
                @include('partials.sidebar')
            </div>
        </div>

        <main class="content">
            <x-alert />
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sia.js') }}?v={{ @filemtime(public_path('js/sia.js')) }}" defer></script>
</body>
</html>
