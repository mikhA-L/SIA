<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - SIA PTIK</title>
</head>
<body>
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
</body>
</html>