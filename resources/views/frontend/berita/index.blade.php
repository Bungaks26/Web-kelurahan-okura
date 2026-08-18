
{{-- resources/views/frontend/berita/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Berita Kelurahan')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">

            <span class="inline-flex items-center px-4 py-1.5 rounded-full
                        bg-[#009B3A]/10 text-[#009B3A]
                        text-xs sm:text-sm font-semibold mb-4">
                Informasi Kelurahan
            </span>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#151515] tracking-tight"
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Berita & Kegiatan Tebing Tinggi Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Informasi terbaru mengenai kegiatan masyarakat, pelayanan publik,
                pembangunan, dan agenda Kelurahan Tebing Tinggi Okura.
            </p>

        </div>

        @php
            $beritaUtama = $beritas->first();
        @endphp

        @if ($beritaUtama)

        <div class="mb-12">

            <a href="{{ route('berita.show', $beritaUtama->slug) }}"
            class="group block relative rounded-3xl overflow-hidden shadow-lg">

                <img src="{{ asset('storage/'.$beritaUtama->thumbnail) }}"
                    alt="{{ $beritaUtama->judul }}"
                    class="w-full h-[260px] sm:h-[380px] object-cover group-hover:scale-105 transition-transform duration-700">

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-white">

                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur text-xs font-semibold mb-3 capitalize">
                        {{ $beritaUtama->kategori }}
                    </span>

                    <h2 class="text-2xl sm:text-4xl font-bold leading-tight mb-3">
                        {{ $beritaUtama->judul }}
                    </h2>

                    <p class="text-sm sm:text-base text-white/90 line-clamp-2 max-w-2xl">
                        {{ \Illuminate\Support\Str::limit(strip_tags($beritaUtama->isi), 140) }}
                    </p>

                    <div class="mt-4 flex items-center gap-4 text-sm text-white/80">
                        <span>{{ $beritaUtama->published_at->translatedFormat('d F Y') }}</span>
                        <span>•</span>
                        <span>{{ $beritaUtama->views }} kali dilihat</span>
                    </div>

                </div>

            </a>

        </div>

        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($beritas->skip(1) as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}" class="group flex flex-col rounded-3xl overflow-hidden bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 h-full">
                    <div class="relative h-52 overflow-hidden">

                        <img src="{{ asset('storage/'.$berita->thumbnail) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            alt="{{ $berita->judul }}"
                            loading="lazy">

                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur text-xs font-semibold text-[#009B3A] capitalize">
                                {{ $berita->kategori }}
                            </span>
                        </div>

                    </div>

                    <div class="p-6 flex flex-col flex-1">

                        <h3 class="text-lg font-bold text-slate-800 line-clamp-2 group-hover:text-[#009B3A] transition-colors">
                            {{ $berita->judul }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 line-clamp-3 flex-1 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 120) }}
                        </p>

                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-sm">

                            <span class="text-slate-500">
                                {{ $berita->published_at->translatedFormat('d M Y') }}
                            </span>

                            <span class="font-semibold text-[#009B3A]">
                                Baca →
                            </span>

                        </div>

                    </div>

                </a>
            @empty
                <div class="col-span-3 bg-white rounded-3xl border border-dashed border-slate-300 py-16 text-center">
                    <div class="text-5xl mb-3">📰</div>
                    <p class="text-base font-semibold text-slate-700">
                        Belum ada berita dipublikasikan
                    </p>
                    <p class="text-sm text-slate-500 mt-1">
                        Informasi terbaru kegiatan kelurahan akan ditampilkan setelah dipublikasikan oleh admin.
                    </p>
                </div>
            @endforelse
        </div>

        @if ($beritas->hasPages())
            <div class="mt-10">{{ $beritas->links() }}</div>
        @endif
    </div>
</section>
@endsection
