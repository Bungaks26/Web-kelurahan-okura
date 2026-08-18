{{-- resources/views/frontend/agenda/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Agenda Kelurahan')

@section('content')
<section class="pt-28 pb-16 bg-[#F8F8F6] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- Header --}}
        <div class="text-center mb-12">

            <span class="inline-flex items-center px-4 py-1.5 rounded-full
                         bg-[#009B3A]/10 text-[#009B3A]
                         text-xs sm:text-sm font-semibold mb-4">
                Agenda Kelurahan
            </span>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#151515] tracking-tight"
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Agenda & Kegiatan Tebing Tinggi Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Informasi jadwal kegiatan masyarakat, rapat, pelayanan, dan agenda resmi
                Kelurahan Tebing Tinggi Okura.
            </p>

        </div>

        @forelse ($agendas as $index => $agenda)

            @php
                $tanggal = \Carbon\Carbon::parse($agenda->tanggal);
                $hariIni = now();

                if ($tanggal->isToday()) {
                    $status = 'Berlangsung';
                    $badge = 'bg-blue-100 text-blue-700';
                } elseif ($tanggal->isFuture()) {
                    $status = 'Akan Datang';
                    $badge = 'bg-[#009B3A]/10 text-[#009B3A]';
                } else {
                    $status = 'Selesai';
                    $badge = 'bg-slate-100 text-slate-600';
                }
            @endphp

            {{-- Agenda utama --}}
            @if($index === 0)

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-10">

                    <div class="p-6 sm:p-8">

                        <div class="flex flex-wrap items-center gap-3 mb-4">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $status }}
                            </span>

                            <span class="text-sm text-slate-500">
                                {{ $tanggal->translatedFormat('l, d F Y') }}
                            </span>

                        </div>

                        <h2 class="text-2xl sm:text-3xl font-bold text-[#151515] leading-tight mb-4">
                            {{ $agenda->judul }}
                        </h2>

                        @if($agenda->lokasi)
                            <div class="flex items-center gap-2 text-sm text-slate-600 mb-4">
                                <svg class="w-4 h-4 text-[#009B3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $agenda->lokasi }}
                            </div>
                        @endif

                        <p class="text-slate-600 leading-relaxed whitespace-pre-line">
                            {{ \Illuminate\Support\Str::limit($agenda->deskripsi, 250) }}
                        </p>

                    </div>

                </div>

            @else

                {{-- Timeline agenda lainnya --}}
                <div class="relative pl-8 pb-8">

                    <div class="absolute left-3 top-2 bottom-0 w-px bg-slate-200"></div>

                    <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-[#009B3A] border-4 border-white shadow"></div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition">

                        <div class="flex flex-wrap items-center gap-3 mb-3">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $status }}
                            </span>

                            <span class="text-sm text-slate-500">
                                {{ $tanggal->translatedFormat('d F Y') }}
                            </span>

                        </div>

                        <h3 class="text-lg font-semibold text-slate-800 mb-2">
                            {{ $agenda->judul }}
                        </h3>

                        @if($agenda->lokasi)
                            <p class="text-sm text-slate-500 mb-3">
                                📍 {{ $agenda->lokasi }}
                            </p>
                        @endif

                        <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $agenda->deskripsi }}
                        </p>

                    </div>

                </div>

            @endif

        @empty

            <div class="bg-white rounded-3xl border border-dashed border-slate-300 py-16 text-center">

                <div class="text-5xl mb-3">📅</div>

                <p class="text-base font-semibold text-slate-700">
                    Belum ada agenda kegiatan
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Jadwal kegiatan kelurahan akan ditampilkan setelah dipublikasikan oleh admin.
                </p>

            </div>

        @endforelse

    </div>
</section>
@endsection