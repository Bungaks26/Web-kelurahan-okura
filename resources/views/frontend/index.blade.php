{{-- resources/views/frontend/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Kelurahan Tebing Tinggi Okura')

@section('content')

{{-- ================= HERO SECTION — CAROUSEL DINAMIS ================= --}}
<section class="relative min-h-[78vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden"
         x-data="{
             slides: {{ $banners->count() ? $banners->count() : 1 }},
             current: 0,
             autoplay: null,
             init() {
                 if (this.slides > 1) {
                     this.autoplay = setInterval(() => this.next(), 6000);
                 }
             },
             next() { this.current = (this.current + 1) % this.slides },
             prev() { this.current = (this.current - 1 + this.slides) % this.slides },
             goTo(i) {
                 this.current = i;
                 clearInterval(this.autoplay);
                 if (this.slides > 1) this.autoplay = setInterval(() => this.next(), 6000);
             }
         }">

    {{-- Slides --}}
    <div class="absolute inset-0">
        @forelse ($banners as $i => $banner)
            <div x-show="current === {{ $i }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="absolute inset-0">
                
                <img src="{{ asset('storage/'.$banner->gambar) }}"
                    alt="{{ $banner->judul }}"
                    class="w-full h-full object-cover">

                <div class="absolute inset-0 bg-gray-800/60"></div>
            </div>

        @empty
            {{-- Fallback kalau belum ada banner sama sekali --}}
            <div class="absolute inset-0">
                <img src="{{ asset('images/hero-okura.jpg') }}"
                    alt="Okura"
                    class="w-full h-full object-cover">

                <div class="absolute inset-0 bg-gray-800/60"></div>
            </div>
        @endforelse
    </div>

    {{-- Navigation Arrows (hanya tampil kalau lebih dari 1 banner) --}}
    @if ($banners->count() > 1)
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Dots Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            @foreach ($banners as $i => $banner)
                <button @click="goTo({{ $i }})" :class="current === {{ $i }} ? 'w-8 bg-amber-400' : 'w-2 bg-white/40'" class="h-2 rounded-full transition-all duration-300"></button>
            @endforeach
        </div>
    @endif

    {{-- Konten Overlay --}}
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center pt-32 sm:pt-28 pb-10" x-data="{ counted: false }" x-intersect="counted = true">
        <span class="inline-block px-4 py-1.5 mb-5 rounded-full bg-[#FFE600]/20 text-[#FFE600] text-sm font-medium border border-[#FFE600]/30">           Portal Resmi Kelurahan
        </span>

        <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold text-white leading-[1.05] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            @if ($banners->isNotEmpty() && $banners->first()->judul)
                <span x-text="{{ json_encode($banners->pluck('judul')) }}[current] || '{{ $banners->first()->judul }}'"></span>
            @else
                Tebing Tinggi Okura
            @endif
        </h1>
        <p class="mt-5 text-base sm:text-lg md:text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
            Menyajikan pelayanan, informasi, dan potensi wisata & UMKM warga secara cepat, transparan, dan modern.
        </p>

        {{-- Universal Quick Search & Tracking Bar (2 Tab) --}}
        <div id="lacak" class="mt-8 max-w-xl mx-auto" x-data="{ tab: window.location.hash === '#lacak' ? 'lacak' : 'cari' }">
            {{-- Tab Switcher --}}
            <div class="flex bg-white/10 backdrop-blur rounded-xl p-1 mb-3 max-w-xs mx-auto">
                <button @click="tab = 'cari'"
                        :class="tab === 'cari' ? 'bg-white text-emerald-700' : 'text-white/70'"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition">
                    Cari Informasi
                </button>
                <button @click="tab = 'lacak'"
                        :class="tab === 'lacak' ? 'bg-white text-emerald-700' : 'text-white/70'"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition">
                    Lacak Pengajuan
                </button>
            </div>

            {{-- Form Cari Informasi --}}
            <form x-show="tab === 'cari'" action="{{ route('search') }}" method="GET">
                <div class="flex items-center bg-white/95 backdrop-blur rounded-2xl shadow-lg p-2">
                    <svg class="w-5 h-5 text-slate-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari: Syarat SKTM, Wisata Sungai Siak, UMKM..."
                           class="flex-1 px-3 py-2.5 bg-transparent focus:outline-none text-slate-700 text-sm sm:text-base">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#E31E24] hover:bg-[#C91A1F] text-white text-sm font-semibold transition">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Form Lacak Pengajuan (Universal) --}}
            <form x-show="tab === 'lacak'" x-cloak action="{{ route('tracking.universal') }}" method="POST">
                @csrf
                <div class="flex items-center bg-white/95 backdrop-blur rounded-2xl shadow-lg p-2">
                    <svg class="w-5 h-5 text-slate-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <input type="text" name="kode_tiket" placeholder="Masukkan kode tiket, contoh: ADU-20260809-001"
                           class="flex-1 px-3 py-2.5 bg-transparent focus:outline-none text-slate-700 text-sm sm:text-base font-mono">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#E31E24] hover:bg-[#C91A1F] text-white text-sm font-semibold transition">
                        Lacak
                    </button>
                </div>
                @error('kode_tiket')
                    <p class="text-xs text-red-300 mt-2 text-center bg-red-900/30 rounded-lg py-1.5">{{ $message }}</p>
                @enderror
            </form>
        </div>

        {{-- ================= LIVE COUNTER ================= --}}
        <div class="mt-12 mb-6 grid grid-cols-3 gap-4 max-w-lg mx-auto">

            {{-- Jumlah Penduduk --}}
            <div
                x-data="counter({{ (int) $jumlahPenduduk }}, true)"
                x-intersect.once="start()"
                class="text-center opacity-0 translate-y-3 transition-all duration-700"
                :class="started ? 'opacity-100 translate-y-0' : ''"
            >
                <p
                    class="text-2xl sm:text-3xl font-bold text-[#FFE600] tabular-nums"
                    x-text="displayValue"
                ></p>

                <p class="text-xs sm:text-sm text-white/80 mt-1">
                    Jumlah Penduduk
                </p>
            </div>


            {{-- Destinasi Wisata --}}
            <div
                x-data="counter({{ (int) $jumlahWisata }}, false)"
                x-intersect.once="start()"
                class="text-center opacity-0 translate-y-3 transition-all duration-700 delay-100"
                :class="started ? 'opacity-100 translate-y-0' : ''"
            >
                <p
                    class="text-2xl sm:text-3xl font-bold text-[#FFE600] tabular-nums"
                    x-text="displayValue"
                ></p>

                <p class="text-xs sm:text-sm text-white/80 mt-1">
                    Destinasi Wisata
                </p>
            </div>


            {{-- UMKM --}}
            <div
                x-data="counter({{ (int) $jumlahUmkm }}, false)"
                x-intersect.once="start()"
                class="text-center opacity-0 translate-y-3 transition-all duration-700 delay-200"
                :class="started ? 'opacity-100 translate-y-0' : ''"
            >
                <p
                    class="text-2xl sm:text-3xl font-bold text-[#FFE600] tabular-nums"
                    x-text="displayValue"
                ></p>

                <p class="text-xs sm:text-sm text-white/80 mt-1">
                    UMKM Terdaftar
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ================= QUICK ACCESS CARDS (Melayang) ================= --}}
<section class="relative z-20 -mt-10 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $quickLinks = [
                ['icon' => '📄', 'label' => 'Layanan Surat', 'desc' => 'Ajukan & lacak', 'route' => 'layanan.index', 'color' => 'bg-[#009B3A]/10 text-[#009B3A]'],
                ['icon' => '📢', 'label' => 'Lapor Pengaduan', 'desc' => 'Sampaikan keluhan', 'route' => 'pengaduan.create', 'color' => 'bg-[#E31E24]/10 text-[#E31E24]'],
                ['icon' => '🏞️', 'label' => 'Wisata Okura', 'desc' => 'Jelajahi destinasi', 'route' => 'wisata.index', 'color' => 'bg-[#FFE600]/20 text-[#8A7600]'],
                ['icon' => '🛍️', 'label' => 'UMKM Warga', 'desc' => 'Dukung usaha lokal', 'route' => 'umkm.index', 'color' => 'bg-[#009B3A]/10 text-[#009B3A]'],
            ];
        @endphp

        @foreach ($quickLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-5 transition-all duration-300 hover:-translate-y-1 border border-slate-100">
                <div class="w-12 h-12 rounded-xl {{ $link['color'] }} flex items-center justify-center text-2xl mb-3">
                    {{ $link['icon'] }}
                </div>
                <h3 class="font-semibold text-slate-800 text-sm sm:text-base">{{ $link['label'] }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $link['desc'] }}</p>
            </a>
        @endforeach
    </div>
</section>

{{-- ================= PENGUMUMAN ================= --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-[#E31E24] font-semibold text-sm uppercase tracking-wide">
                Informasi Resmi
            </span>

            <h2 class="text-3xl font-bold text-[#151515] mt-2"
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Pengumuman Kelurahan
            </h2>

            <p class="text-sm text-slate-500 mt-2">
                Informasi dan pemberitahuan terbaru dari Kelurahan Tebing Tinggi Okura.
            </p>
        </div>

        <a href="{{ route('pengumuman.index') }}"
           class="hidden sm:block text-[#009B3A] font-medium text-sm hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @forelse ($pengumumans ?? [] as $pengumuman)

            <a href="{{ route('pengumuman.show', $pengumuman->id) }}"
               class="group bg-white rounded-2xl border border-slate-100 shadow-md
                      hover:shadow-xl transition-all duration-300 p-6">

                <div class="flex items-start justify-between gap-3 mb-4">

                    <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                 bg-emerald-50 text-emerald-700 text-xs font-semibold">
                        {{ ucfirst($pengumuman->kategori) }}
                    </span>

                    <span class="text-xs text-slate-400">
                        {{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->translatedFormat('d F Y') }}
                    </span>

                </div>

                <h3 class="font-semibold text-slate-800 text-lg
                           group-hover:text-[#009B3A] transition-colors">
                    {{ $pengumuman->judul }}
                </h3>

                <p class="text-sm text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                    {{ $pengumuman->isi }}
                </p>

                <div class="mt-5 text-sm font-medium text-[#009B3A]">
                    Baca Selengkapnya →
                </div>

            </a>

        @empty

            <div class="md:col-span-3 text-center py-10">
                <p class="text-sm text-slate-400">
                    Belum ada pengumuman terbaru.
                </p>
            </div>

        @endforelse
    </div>

    {{-- Tombol lihat semua untuk mobile --}}
    <div class="mt-6 text-center sm:hidden">
        <a href="{{ route('pengumuman.index') }}"
           class="inline-block text-[#009B3A] font-medium text-sm hover:underline">
            Lihat Semua Pengumuman →
        </a>
    </div>
</section>

{{-- ================= BENTO GRID: PROFIL & INFO CEPAT ================= --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="mb-10 text-center">
        <span class="text-[#009B3A] font-semibold text-sm uppercase tracking-wide">Selayang Pandang</span>
        <h2 class="text-3xl font-bold text-[#151515] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Mengenal Kelurahan Kami
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-4">
        {{-- Card besar: Peta --}}
        <div class="md:col-span-2 md:row-span-2 bg-white rounded-2xl shadow-md p-6 border border-slate-100">
            <h3 class="font-semibold text-slate-800 mb-3">📍 Peta Wilayah</h3>
            <div id="peta-kelurahan" class="w-full h-64 md:h-80 rounded-xl bg-slate-100"></div>
            <p class="text-xs text-slate-500 mt-3">Kelurahan Tebing Tinggi Okura, Kec. Rumbai Pesisir, Pekanbaru.</p>
        </div>

        {{-- Card: Visi Misi --}}
        <div class="md:col-span-2 bg-[#009B3A] rounded-2xl shadow-md p-6 text-white">
            <h3 class="font-semibold mb-2">🎯 Visi Kelurahan</h3>
            <p class="text-sm text-slate-200 leading-relaxed">
                Terwujudnya Kelurahan Tebing Tinggi Okura sebagai pusat pariwisata, pertanian, perikanan, dan kebudayaan Melayu di Kota Pekanbaru.
            </p>
            <a href="{{ route('profil') }}" class="inline-block mt-4 text-[#FFE600] text-sm font-medium hover:underline">
                Selengkapnya →
            </a>
        </div>

        {{-- Card: Berita Terbaru --}}
        <div class="md:col-span-2 bg-white rounded-2xl shadow-md p-6 border border-slate-100">

            <div class="flex items-center justify-between mb-5">
                <h3 class="font-semibold text-slate-800 text-lg">
                    📰 Berita Terbaru
                </h3>

                <a href="{{ route('berita.index') }}"
                class="text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="space-y-3">

                {{-- Berita 1 --}}
                <a href="{{ route('berita.index') }}"
                class="flex items-center justify-between gap-4 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">
                            Kegiatan Kelurahan Tebing Tinggi Okura
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            26 Agustus 2026
                        </p>
                    </div>

                    <span class="text-slate-300">→</span>
                </a>

                {{-- Berita 2 --}}
                <a href="{{ route('berita.index') }}"
                class="flex items-center justify-between gap-4 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">
                            Informasi Pelayanan Kelurahan
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            24 Agustus 2026
                        </p>
                    </div>

                    <span class="text-slate-300">→</span>
                </a>
            </div>

        </div>
        
    </div>
</section>

{{-- ================= WISATA OKURA ================= --}}
<section class="bg-[#F8F8F6] py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-[#009B3A] font-semibold text-sm uppercase tracking-wide">Jelajahi</span>
                <h2 class="text-3xl font-bold text-[#151515] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Potensi Wisata Okura
                </h2>
            </div>
            <a href="{{ route('wisata.index') }}" class="hidden sm:block text-[#009B3A] font-medium text-sm hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($wisatas ?? [] as $wisata)
                <a href="{{ route('wisata.show', $wisata->slug) }}"
                   class="group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $wisata->thumbnail ? asset('storage/' . $wisata->thumbnail) : asset('images/placeholder.jpg') }}"
                             alt="{{ $wisata->nama }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-800">{{ $wisata->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $wisata->deskripsi }}</p>
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-400 col-span-3 text-center py-10">Belum ada data wisata.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ================= UMKM WARGA ================= --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="text-[#E31E24] font-semibold text-sm uppercase tracking-wide">Dukung Lokal</span>
            <h2 class="text-3xl font-bold text-[#151515] mt-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                UMKM Warga Okura
            </h2>
        </div>
        <a href="{{ route('umkm.index') }}" class="hidden sm:block text-[#009B3A] font-medium text-sm hover:underline">
            Lihat Semua →
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse ($umkms ?? [] as $umkm)
            <a href="{{ route('umkm.show', $umkm->id) }}"
               class="rounded-2xl bg-white shadow-md hover:shadow-xl transition p-4 border border-slate-100">
                <div class="h-28 rounded-xl overflow-hidden mb-3">
                    <img src="{{ $umkm->foto ? asset('storage/' . $umkm->foto) : asset('images/placeholder.jpg') }}"
                         class="w-full h-full object-cover" alt="{{ $umkm->nama_usaha }}">
                </div>
                <h3 class="font-semibold text-sm text-slate-800 truncate">{{ $umkm->nama_usaha }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $umkm->kategori }}</p>
            </a>
        @empty
            <p class="text-sm text-slate-400 col-span-4 text-center py-10">Belum ada data UMKM.</p>
            <section class="max-w-2xl mx-auto px-4 sm:px-6 py-16">
                @include('frontend.partials.widget-survei')
            </section>
        @endforelse
    </div>

</section>

{{-- ================= GALERI KEGIATAN ================= --}}
<section class="bg-[#F8F8F6] py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-[#E31E24] font-semibold text-sm uppercase tracking-wide">
                    Dokumentasi
                </span>

                <h2 class="text-3xl font-bold text-[#151515] mt-2"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Galeri Kegiatan
                </h2>

                <p class="text-sm text-slate-500 mt-2">
                    Dokumentasi kegiatan dan aktivitas Kelurahan Tebing Tinggi Okura.
                </p>
            </div>

            <a href="{{ route('galeri.index') }}"
               class="hidden sm:block text-[#009B3A] font-medium text-sm hover:underline">
                Lihat Semua →
            </a>
        </div>

        {{-- Grid Galeri --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

            @forelse ($galeris ?? [] as $galeri)

                <a href="{{ route('galeri.index') }}"
                   class="group relative aspect-square rounded-2xl overflow-hidden bg-slate-100">

                    <img src="{{ asset('storage/' . $galeri->foto) }}"
                         alt="{{ $galeri->judul }}"
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300"></div>

                    {{-- Judul --}}
                    <div class="absolute inset-x-0 bottom-0 p-3 translate-y-2 opacity-0
                                group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <p class="text-white text-xs font-medium line-clamp-2">
                            {{ $galeri->judul }}
                        </p>
                    </div>

                </a>

            @empty

                <div class="col-span-2 sm:col-span-3 lg:col-span-6 text-center py-10">
                    <p class="text-sm text-slate-400">
                        Belum ada foto kegiatan.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- Tombol mobile --}}
        <div class="mt-6 text-center sm:hidden">
            <a href="{{ route('galeri.index') }}"
               class="inline-block text-[#009B3A] font-medium text-sm hover:underline">
                Lihat Semua Galeri →
            </a>
        </div>

    </div>
</section>

{{-- ================= FLOATING WHATSAPP BUTTON ================= --}}
<a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kelurahan%20Tebing%20Tinggi%20Okura"
   target="_blank"
   class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 rounded-full bg-[#009B3A] shadow-xl hover:bg-[#007F2F] transition-all hover:scale-110">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.86 9.86 0 004.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.13a8.2 8.2 0 01-4.18-1.14l-.3-.18-3.11.82.83-3.04-.2-.31a8.22 8.22 0 01-1.26-4.37c0-4.54 3.7-8.24 8.24-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 012.41 5.83c0 4.54-3.7 8.21-8.26 8.21z"/>
    </svg>
</a>

@endsection

@push('scripts')
{{-- ================= COUNTER ANIMATION ================= --}}
<script>
    document.addEventListener('alpine:init', () => {

        Alpine.data('counter', (target, useSeparator = false) => ({
            target: Number(target) || 0,
            current: 0,
            displayValue: '0',
            started: false,

            start() {
                if (this.started) return;

                this.started = true;

                const duration = 1600;
                const startTime = performance.now();

                const animate = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Ease out: awal cepat, kemudian melambat
                    const easeOut = 1 - Math.pow(1 - progress, 3);

                    this.current = Math.floor(this.target * easeOut);

                    this.displayValue = this.current.toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        this.current = this.target;
                        this.displayValue = this.target.toLocaleString('id-ID');
                    }
                };

                requestAnimationFrame(animate);
            }
        }));

    });
</script>


{{-- ================= PETA KELURAHAN ================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const mapElement = document.getElementById('peta-kelurahan');

        if (!mapElement) {
            return;
        }

        const kantorLurah = [
            0.5712465050879031,
            101.53889059635989
        ];

        const map = L.map('peta-kelurahan').setView(kantorLurah, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);


        // Marker Kantor Lurah
        L.marker(kantorLurah)
            .addTo(map)
            .bindPopup('<b>Kantor Lurah Tebing Tinggi Okura</b>');


        // Batas wilayah dari GeoJSON
        fetch('{{ asset('geojson/tebing-tinggi-okura.geojson') }}')
            .then(response => {

                if (!response.ok) {
                    throw new Error('File GeoJSON tidak ditemukan');
                }

                return response.json();
            })
            .then(data => {

                const batasWilayah = L.geoJSON(data, {
                    style: {
                        color: '#009B3A',
                        weight: 3,
                        fillColor: '#009B3A',
                        fillOpacity: 0.10
                    }
                }).addTo(map);

                map.fitBounds(batasWilayah.getBounds(), {
                    padding: [20, 20]
                });

            })
            .catch(error => {
                console.error('Gagal memuat GeoJSON:', error);
            });

    });
</script>

@endpush