@extends('layouts.admin')

@section('title', 'Data Wisata')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Wisata
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola dan ajukan data wisata untuk ditampilkan di website kelurahan.
            </p>
        </div>

        <a href="{{ route('staf.wisata.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                  bg-emerald-600 hover:bg-emerald-700 text-white text-sm
                  font-semibold rounded-xl transition">
            + Tambah Wisata
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700
                    px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('staf.wisata.index') }}"
          class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">

        <div class="flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama wisata..."
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200
                       text-sm focus:ring-2 focus:ring-emerald-500
                       focus:border-emerald-500 outline-none"
            >

            <button
                type="submit"
                class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900
                       text-white text-sm font-semibold transition">
                Cari
            </button>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Wisata
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Alamat
                        </th>

                        <th class="px-6 py-4 text-left font-semibold text-slate-600">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($wisatas as $wisata)
                        <tr class="hover:bg-slate-50 transition">

                            {{-- Wisata --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    @if ($wisata->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $wisata->thumbnail) }}"
                                            alt="{{ $wisata->nama }}"
                                            class="w-14 h-14 rounded-xl object-cover"
                                        >
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-slate-100
                                                    flex items-center justify-center
                                                    text-slate-400 text-xs">
                                            No Image
                                        </div>
                                    @endif

                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $wisata->nama }}
                                        </p>

                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ $wisata->created_at?->format('d M Y') }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- Alamat --}}
                            <td class="px-6 py-4 text-slate-600">
                                {{ $wisata->alamat }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if ($wisata->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1
                                                 rounded-full text-xs font-semibold
                                                 bg-amber-50 text-amber-700">
                                        Menunggu Persetujuan
                                    </span>

                                @elseif ($wisata->status === 'aktif')
                                    <span class="inline-flex items-center px-3 py-1
                                                 rounded-full text-xs font-semibold
                                                 bg-emerald-50 text-emerald-700">
                                        Aktif
                                    </span>

                                @else
                                    <span class="inline-flex items-center px-3 py-1
                                                 rounded-full text-xs font-semibold
                                                 bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">

                                <div class="text-slate-400">
                                    <p class="font-medium text-slate-600">
                                        Belum ada data wisata.
                                    </p>

                                    <p class="text-sm mt-1">
                                        Silakan tambahkan data wisata baru.
                                    </p>
                                </div>

                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($wisatas->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $wisatas->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>
@endsection