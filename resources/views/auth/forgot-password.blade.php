<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password | Kelurahan Tebing Tinggi Okura</title>

    <link rel="icon"
          type="image/png"
          href="{{ asset('storage/logo-kelurahan.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#0B1F3A] px-4">

<div class="w-full max-w-md">

    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo2.png') }}"
                 alt="Logo Kelurahan Tebing Tinggi Okura"
                 class="w-20 h-20 object-contain">
        </div>

        <h1 class="text-white font-bold text-lg">
            Kelurahan Tebing Tinggi Okura
        </h1>

        <p class="text-slate-400 text-sm mt-1">
            Portal Administrasi
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">

        <h2 class="text-xl font-bold text-slate-800 mb-1">
            Lupa Password
        </h2>

        <p class="text-sm text-slate-500 mb-6">
            Masukkan email akun Anda untuk menerima link reset password.
        </p>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3 mb-5">
                <p class="text-sm text-emerald-700">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 mb-5">
                <p class="text-sm text-red-600">
                    {{ $errors->first() }}
                </p>
            </div>
        @endif

        <form action="{{ route('password.email') }}"
              method="POST"
              class="space-y-5">

            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="admin@kelurahanokura.id"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
            </div>

            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition">
                Kirim Link Reset Password
            </button>
        </form>

    </div>

    <p class="text-center text-slate-500 text-xs mt-6">
        <a href="{{ route('admin.login') }}"
           class="hover:text-white transition">
            ← Kembali ke login
        </a>
    </p>

</div>

</body>
</html>