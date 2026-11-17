
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Informasi Akademik</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-5">

    <main class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden grid md:grid-cols-2">

        <!-- Bagian Kiri -->
        <section class="bg-blue-900 text-white p-10 md:p-14 flex flex-col justify-between min-h-[500px]">

            <div>
                <div class="flex items-center gap-3 mb-14">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-blue-900 font-bold text-xl">
                        SIA
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Sistem Informasi</h1>
                        <p class="text-blue-200 text-sm">Akademik</p>
                    </div>
                </div>

                <p class="text-blue-200 text-sm font-semibold tracking-widest uppercase mb-4">
                    Selamat Datang
                </p>

                <h2 class="text-3xl md:text-4xl font-bold leading-tight mb-5">
                    Portal Akademik Mahasiswa
                </h2>

                <p class="text-blue-100 leading-relaxed">
                    Akses informasi akademik, jadwal perkuliahan,
                    KRS, dan hasil studi dalam satu platform.
                </p>
            </div>

            <p class="text-blue-200 text-xs mt-10">
                © 2026 Sistem Informasi Akademik
            </p>

        </section>

        <!-- Bagian Kanan -->
        <section class="p-8 md:p-14 flex flex-col justify-center">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">
                    Masuk ke Akun
                </h2>
                <p class="text-slate-500 text-sm">
                    Silakan masukkan akun akademik Anda.
                </p>
            </div>

            <form action="#" method="POST" class="space-y-5">

                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email / NIM
                    </label>

                    <input
                        type="text"
                        id="email"
                        name="email"
                        placeholder="Masukkan email atau NIM"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" class="accent-blue-700">
                        Ingat saya
                    </label>

                    <a href="#" class="text-blue-700 font-semibold hover:underline">
                        Lupa password?
                    </a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-800 hover:bg-blue-900 text-white font-semibold py-3 rounded-lg transition duration-200"
                >
                    Masuk
                </button>

            </form>

            <p class="text-center text-xs text-slate-400 mt-8">
                Sistem Informasi Akademik
            </p>

        </section>

    </main>

</body>
</html>
