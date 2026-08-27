{{-- resources/views/frontend/pengaduan/track-result.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Hasil Lacak Pengaduan')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">
    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-slate-100">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-xs text-slate-400 mb-1">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-[#0B1F3A]">
                    {{ $pengaduan->kode_tiket }}
                </p>
            </div>

            @php
                $statusClass = match($pengaduan->status) {
                    'diterima' => 'bg-blue-50 text-blue-700',
                    'diproses' => 'bg-amber-50 text-amber-700',
                    'selesai' => 'bg-emerald-50 text-emerald-700',
                    'ditolak' => 'bg-red-50 text-red-700',
                    default => 'bg-slate-50 text-slate-700',
                };
            @endphp

            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                {{ ucfirst($pengaduan->status) }}
            </span>
        </div>

        {{-- Judul Pengaduan --}}
        <div class="mb-6">
            <p class="text-xs text-slate-400 mb-1">Judul Pengaduan</p>
            <h2 class="font-semibold text-lg text-slate-800">
                {{ $pengaduan->judul_aduan }}
            </h2>
        </div>

        {{-- Kategori --}}
        <div class="mb-6">
            <p class="text-xs text-slate-400 mb-1">Kategori</p>
            <span class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium capitalize">
                {{ $pengaduan->kategori }}
            </span>
        </div>

        {{-- Isi Pengaduan --}}
        <div class="mb-6">
            <p class="text-xs text-slate-400 mb-2">Isi Pengaduan</p>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $pengaduan->isi_aduan }}
                </p>
            </div>
        </div>

        {{-- Catatan Admin --}}
        @if ($pengaduan->catatan_admin)
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 mb-6">
                <p class="text-xs font-semibold text-amber-700 mb-1">
                    Catatan Petugas
                </p>

                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $pengaduan->catatan_admin }}
                </p>
            </div>
        @endif

        {{-- Waktu Pengaduan --}}
        <div class="pt-5 border-t border-slate-100">
            <p class="text-xs text-slate-400">
                Dilaporkan pada
                {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }}
            </p>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('pengaduan.track.form') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">
                ← Lacak Pengaduan Lain
            </a>
        </div>

    </div>
</section>
@endsection