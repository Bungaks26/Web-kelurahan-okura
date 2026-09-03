@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="mx-auto max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Tambah Pengguna
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Buat akun Staf baru untuk mengakses dashboard kelurahan.
        </p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <ul class="space-y-1 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.pengguna.store') }}"
              class="space-y-5">

            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">

                <p class="mt-1 text-xs text-slate-500">
                    Minimal 8 karakter.
                </p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    minlength="8"
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="rounded-xl bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-700">
                    Role
                </div>
                <div class="mt-1 text-sm text-slate-500">
                    Akun baru akan dibuat sebagai <strong>Staf</strong>.
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.pengguna.index') }}"
                   class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                    Simpan Pengguna
                </button>
            </div>

        </form>
    </div>

</div>
@endsection