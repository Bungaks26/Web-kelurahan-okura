@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Manajemen Pengguna
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola akun staf yang memiliki akses ke dashboard kelurahan.
            </p>
        </div>

        <a href="{{ route('admin.pengguna.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
            + Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.pengguna.index') }}"
              class="grid gap-3 md:grid-cols-3">

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Cari pengguna
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau email..."
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">
                    Role
                </label>

                <select
                    name="role"
                    class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Semua Role</option>
                    <option value="super_admin" @selected(request('role') === 'super_admin')>
                        Super Admin
                    </option>
                    <option value="staf" @selected(request('role') === 'staf')>
                        Staf
                    </option>
                    <option value="lurah" @selected(request('role') === 'lurah')>
                        Lurah
                    </option>
                </select>
            </div>

            <div class="md:col-span-3">
                <button
                    type="submit"
                    class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                    Terapkan Filter
                </button>

                <a href="{{ route('admin.pengguna.index') }}"
                   class="ml-2 text-sm font-medium text-slate-500 hover:text-slate-900">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Pengguna
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Email
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Role
                        </th>
                        <th class="px-6 py-4 text-right font-semibold text-slate-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $user->name }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">
                                @if($user->role === 'super_admin')
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        Super Admin
                                    </span>
                                @elseif($user->role === 'lurah')
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Lurah
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        Staf
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pengguna.edit', $user) }}"
                                       class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id() && $user->role !== 'super_admin')
                                        <form method="POST"
                                              action="{{ route('admin.pengguna.destroy', $user) }}"
                                              onsubmit="return confirm('Hapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection