{{-- resources/views/frontend/wisata/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Wisata Okura')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">

            <span class="inline-flex items-center px-4 py-1.5 rounded-full
                            bg-[#009B3A]/10 text-[#009B3A]
                            text-xs sm:text-sm font-semibold mb-4">
                Destinasi Wisata
            </span>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#151515] tracking-tight"
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Pesona Tebing Tinggi Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Jelajahi potensi wisata alam, tepian Sungai Siak, dan suasana khas Kelurahan Tebing Tinggi Okura.
            </p>
        </div>

        @if ($heroWisata)

        <div class="relative rounded-3xl overflow-hidden mb-12 shadow-lg">

            <img src="{{ $heroWisata->thumbnail
                ? asset('storage/'.$heroWisata->thumbnail)
                : asset('images/placeholder.jpg') }}"
                alt="{{ $heroWisata->nama }}"
                class="w-full h-[260px] sm:h-[340px] object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>

            <div class="absolute inset-0 flex items-center">
                <div class="p-6 sm:p-10 max-w-xl text-white">

                    <p class="text-sm font-semibold tracking-wide uppercase text-white/80 mb-2">
                        Wisata Unggulan
                    </p>

                    <h2 class="text-2xl sm:text-4xl font-bold leading-tight mb-3">
                        {{ $heroWisata->nama }}
                    </h2>

                    <p class="text-sm sm:text-base text-white/90 leading-relaxed line-clamp-3">
                        {{ $heroWisata->deskripsi }}
                    </p>

                </div>
            </div>

        </div>

        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7 items-stretch">
            @forelse ($wisatas as $wisata)
                <a href="{{ route('wisata.show', $wisata->slug) }}" class="group flex flex-col rounded-3xl overflow-hidden bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 h-full">

                    <div class="relative h-56 overflow-hidden">

                        <img src="{{ $wisata->thumbnail ? asset('storage/'.$wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            alt="{{ $wisata->nama }}"
                            loading="lazy">

                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur text-xs font-semibold text-[#009B3A]">
                                Wisata
                            </span>
                        </div>

                    </div>


                    <div class="p-6 flex flex-col flex-1">

                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-[#009B3A] transition-colors">
                            {{ $wisata->nama }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed line-clamp-3 flex-1">
                            {{ $wisata->deskripsi }}
                        </p>

                        <div class="mt-5 flex items-center justify-between">

                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#009B3A]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Okura
                            </span>

                            <span class="text-sm font-semibold text-slate-700">
                                {{ $wisata->harga_tiket ?? 'Gratis' }}
                            </span>

                        </div>

                    </div>

                </a>
            @empty
                <p class="col-span-3 text-center text-slate-400 text-sm py-16">Belum ada data wisata.</p>
            @endforelse
        </div>

        @if ($wisatas->hasPages())
            <div class="mt-10">{{ $wisatas->links() }}</div>
        @endif
    </div>
</section>
@endsection
