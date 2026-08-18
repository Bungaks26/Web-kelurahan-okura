{{-- resources/views/frontend/berita/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $berita->judul)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <span class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold mb-4 capitalize">
            {{ $berita->kategori }}
        </span>

        <h1 class="text-3xl sm:text-4xl font-bold text-[#151515] leading-tight tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $berita->judul }}
        </h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 mt-5 mb-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-[#009B3A]/10 flex items-center justify-center text-[#009B3A] text-xs font-bold">
                    {{ strtoupper(substr($berita->user->name, 0, 1)) }}
                </div>
                <span class="font-medium text-slate-700">{{ $berita->user->name }}</span>
            </div>

            <span class="text-slate-300">•</span>

            <span>{{ $berita->published_at->translatedFormat('d F Y') }}</span>

            <span class="text-slate-300">•</span>

            <span>{{ number_format($berita->views, 0, ',', '.') }} kali dilihat</span>
        </div>
        
        <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-full h-64 sm:h-96 object-cover rounded-2xl mb-8" alt="{{ $berita->judul }}">

        <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $berita->isi }}
        </div>
        <div class="mt-10 pt-6 border-t border-slate-100">
            <a href="{{ route('berita.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#009B3A] hover:text-[#007F2F]">
                ← Kembali ke daftar berita
            </a>
        </div>

        @if ($beritaLainnya->count())
            <div class="mt-14 pt-8 border-t border-slate-100">
                <h2 class="font-semibold text-slate-800 mb-4">Berita Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($beritaLainnya as $item)
                        <a href="{{ route('berita.show', $item->slug) }}"
                            class="group bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition">
                                <img src="{{ asset('storage/'.$item->thumbnail) }}"
                                    class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500"
                                    alt="">

                                <div class="p-3">
                                    <p class="text-xs font-semibold text-slate-800 group-hover:text-[#009B3A] line-clamp-2">
                                        {{ $item->judul }}
                                    </p>

                                    <p class="text-[11px] text-slate-400 mt-2">
                                        {{ $item->published_at->translatedFormat('d M Y') }}
                                    </p>
                                </div>

                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
