<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | SIA PTIK UNIMED</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/sia.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
<main class="auth-card">
    <div class="auth-brandbar"><span class="auth-logo">S</span><span><strong>SIA PTIK</strong><small>Universitas Negeri Medan</small></span></div>
<h1>Daftar Akun Mahasiswa</h1>
    <p>Gunakan NIM yang sudah didaftarkan admin.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="nim">NIM</label>
            <input id="nim" type="text" name="nim" value="{{ old('nim') }}" required>
            @error('nim') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation">Ulangi password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</main>
</body>
</html>
