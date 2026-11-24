<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | SIA PTIK UNIMED</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #15233b;
            --slate: #4a5b75;
            --mist: #eef2f6;
            --line: #d5dce6;
            --amber: #e8a317;
            --danger: #b3261e;
        }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: "Open Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: var(--ink);
            background: #fff;
        }
        .shell { min-height: 100vh; display: flex; flex-direction: column; }
        @media (min-width: 900px) { .shell { flex-direction: row; } }

        .brand {
            background: var(--ink);
            color: #fff;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 2rem;
        }
        @media (min-width: 900px) { .brand { width: 42%; padding: 3.5rem 3.5rem; } }
        .brand h1 {
            font-family: "Poppins", system-ui, sans-serif;
            font-weight: 600;
            font-size: 2.25rem;
            line-height: 1.1;
            margin: 0 0 .5rem;
        }
        @media (min-width: 900px) { .brand h1 { font-size: 3rem; } }
        .brand .sub { color: #c4cddb; margin: 0; max-width: 28rem; }
        .brand .peran { display: none; margin: 0; padding: 0; list-style: none; color: #c4cddb; font-size: .95rem; }
        .brand .peran li { padding: .6rem 0; border-top: 1px solid rgba(255,255,255,.18); }
        .brand .peran strong { color: #fff; font-weight: 600; }
        @media (min-width: 900px) { .brand .peran { display: block; } }

        .panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem 1.5rem; }
        .form-wrap { width: 100%; max-width: 380px; }
        .form-wrap h2 { font-size: 1.5rem; font-weight: 600; margin: 0 0 .25rem; }
        .form-wrap .hint { color: var(--slate); margin: 0 0 1.75rem; }

        label { font-weight: 500; font-size: .95rem; margin-bottom: .35rem; }
        .form-control {
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: .7rem .85rem;
            color: var(--ink);
        }
        .form-control:focus { border-color: var(--ink); box-shadow: 0 0 0 3px rgba(232,163,23,.45); }
        .form-control.is-invalid { border-color: var(--danger); background-image: none; }
        .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(179,38,30,.25); }
        .error { color: var(--danger); font-size: .9rem; margin-top: .4rem; }

        .pw { position: relative; }
        .pw .form-control { padding-right: 5.5rem; }
        .pw button {
            position: absolute; top: 50%; right: .5rem; transform: translateY(-50%);
            border: 0; background: transparent; color: var(--slate);
            font-size: .85rem; font-weight: 500; padding: .35rem .5rem; border-radius: 4px;
        }
        .pw button:hover { color: var(--ink); }
        .pw button:focus-visible, .btn-masuk:focus-visible, .form-check-input:focus-visible {
            outline: 3px solid var(--amber); outline-offset: 2px;
        }

        .form-check-input:checked { background-color: var(--ink); border-color: var(--ink); }
        .btn-masuk {
            width: 100%;
            background: var(--ink);
            color: #fff;
            border: 0;
            border-radius: 6px;
            padding: .8rem 1rem;
            font-weight: 600;
        }
        .btn-masuk:hover { background: #0f1a2d; color: #fff; }
        .bantuan { margin: 1.5rem 0 0; color: var(--slate); font-size: .9rem; }
    </style>
</head>
<body>
<div class="shell">
    <section class="brand">
        <div>
            <h1>SIA PTIK</h1>
            <p class="sub">Sistem Informasi Akademik Program Studi PTIK, Universitas Negeri Medan.</p>
        </div>
    </section>

    <main class="panel">
        <div class="form-wrap">
            <h2>Masuk ke akun Anda</h2>
            <p class="hint">Gunakan NIM, NIP, atau username dari prodi.</p>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">NIM / NIP / Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}"
                           class="form-control @error('username') is-invalid @enderror"
                           autocomplete="username" autofocus required
                           @error('username') aria-describedby="username-error" aria-invalid="true" @enderror>
                    @error('username')
                        <div id="username-error" class="error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata sandi</label>
                    <div class="pw">
                        <input id="password" name="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="current-password" required
                               @error('password') aria-describedby="password-error" aria-invalid="true" @enderror>
                        <button type="button" id="togglePw" aria-controls="password" aria-pressed="false">Tampilkan</button>
                    </div>
                    @error('password')
                        <div id="password-error" class="error" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>

                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            </form>

            <p class="bantuan">Lupa kata sandi? Hubungi admin prodi untuk mengatur ulang.</p>
        </div>
    </main>
</div>

<script>
    (function () {
        var btn = document.getElementById('togglePw');
        var input = document.getElementById('password');
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Sembunyikan' : 'Tampilkan';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        });
    })();
</script>
</body>
</html>
