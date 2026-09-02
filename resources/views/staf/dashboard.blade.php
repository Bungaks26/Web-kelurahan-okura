@extends('layouts.admin')

@section('page-title', 'Dashboard Staf')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard Staf
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Pantau pengaduan dan pengajuan layanan yang perlu ditangani.
        </p>
    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">

        {{-- Aduan Baru --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Aduan Baru
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['aduan_baru'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Menunggu penanganan
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    📢
                </div>
            </div>
        </div>


        {{-- Surat Masuk --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Surat Masuk
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['surat_masuk'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Menunggu diproses
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    📄
                </div>
            </div>
        </div>

        {{-- Janji Temu --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Janji Temu
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['janji_temu_menunggu'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Menunggu ditinjau
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                    📅
                </div>

            </div>
        </div>

        {{-- Sedang Diproses --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Sedang Diproses
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['sedang_diproses'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Aduan & surat
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    ⏳
                </div>
            </div>
        </div>


        {{-- Selesai --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Selesai
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['selesai'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Pengajuan terselesaikan
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    ✓
                </div>
            </div>
        </div>

    </div>


    {{-- Tiga Tabel --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Pengaduan Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800">
                        Pengaduan Terbaru
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Lima pengaduan terakhir
                    </p>
                </div>

                <a href="{{ route('staf.pengaduan.index') }}"
                   class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Semua →
                </a>
            </div>

            <div class="divide-y divide-slate-100">

                @forelse ($pengaduanTerbaru as $pengaduan)

                    <a href="{{ route('staf.pengaduan.show', $pengaduan) }}"
                       class="block px-5 py-4 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">
                                    {{ $pengaduan->judul_aduan }}
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $pengaduan->nama_pelapor }}
                                    ·
                                    {{ $pengaduan->kode_tiket }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $pengaduan->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-medium {{ $pengaduan->statusBadgeColor() }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="px-5 py-10 text-center">
                        <p class="text-sm text-slate-400">
                            Belum ada pengaduan.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>


        {{-- Pengajuan Surat Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800">
                        Pengajuan Surat Terbaru
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Lima pengajuan terakhir
                    </p>
                </div>

                <a href="{{ route('staf.layanan-surat.index') }}"
                   class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Semua →
                </a>
            </div>

            <div class="divide-y divide-slate-100">

                @forelse ($suratTerbaru as $surat)

                    <a href="{{ route('staf.layanan-surat.show', $surat) }}"
                       class="block px-5 py-4 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">
                                    {{ $surat->jenis_surat }}
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $surat->nama_pemohon }}
                                    ·
                                    {{ $surat->kode_tiket }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $surat->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-medium {{ $surat->statusBadgeColor() }}">
                                {{ ucfirst($surat->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="px-5 py-10 text-center">
                        <p class="text-sm text-slate-400">
                            Belum ada pengajuan surat.
                        </p>
                    </div>

                @endforelse

            </div>
        </div>

        {{-- Janji Temu Terbaru --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Janji Temu Terbaru
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Lima janji temu terakhir
                    </p>
                </div>

                <a href="{{ route('staf.janji-temu.index') }}"
                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                    Lihat Semua →
                </a>

            </div>

            <div class="divide-y divide-slate-100">

                @forelse ($janjiTemuTerbaru as $janjiTemu)

                    <a href="{{ route('staf.janji-temu.show', $janjiTemu) }}"
                    class="block px-5 py-4 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-slate-800 truncate">
                                    {{ $janjiTemu->nama_pemohon }}
                                </p>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $janjiTemu->keperluan }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $janjiTemu->tanggal_diinginkan?->format('d/m/Y') ?? '-' }}
                                    ·
                                    {{ $janjiTemu->created_at->diffForHumans() }}
                                </p>

                            </div>

                            <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-medium {{ $janjiTemu->statusBadgeColor() }}">
                                {{ ucfirst($janjiTemu->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="px-5 py-10 text-center">

                        <p class="text-sm text-slate-400">
                            Belum ada janji temu.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection