<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | SIA PTIK UNIMED</title>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@600&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #15233b; --slate: #4a5b75; --mist: #eef2f6; --line: #d5dce6; --amber: #e8a317; }
        body { font-family: "Public Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; color: var(--ink); background: var(--mist); }
        .topbar { background: var(--ink); color: #fff; }
        .topbar .brand { font-family: "Newsreader", Georgia, serif; font-weight: 600; font-size: 1.25rem; color: #fff; text-decoration: none; }
        .topbar .who { color: #c4cddb; font-size: .9rem; }
        .btn-keluar { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.4); border-radius: 6px; padding: .35rem .8rem; font-size: .9rem; }
        .btn-keluar:hover { background: rgba(255,255,255,.12); }
        .btn-keluar:focus-visible { outline: 3px solid var(--amber); outline-offset: 2px; }
        .page { max-width: 960px; }
        .page h1 { font-size: 1.6rem; font-weight: 600; }
        .box { background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: 1.25rem; }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container-fluid py-2 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <a class="brand" href="{{ auth()->user()->homePath() }}">SIA PTIK</a>
            <div class="d-flex align-items-center gap-3">
                <span class="who">{{ auth()->user()->name }} ({{ auth()->user()->roleLabel() }})</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn-keluar">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="page mx-auto px-3 py-4">
        @yield('content')
    </main>
</body>
</html>
