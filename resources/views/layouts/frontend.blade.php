{{-- resources/views/layouts/frontend.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Dinamis & OpenGraph (Preview WhatsApp / Social Media) --}}
    <title>{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}</title>
    <meta name="description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura - Layanan publik, wisata, dan UMKM warga.' }}">

    <meta property="og:title" content="{{ $seoTitle ?? 'Kelurahan Tebing Tinggi Okura' }}">
    <meta property="og:description" content="{{ $seoDescription ?? 'Portal resmi Kelurahan Tebing Tinggi Okura - Layanan publik, wisata, dan UMKM warga.' }}">
    <meta property="og:image" content="{{ $seoImage ?? asset('images/default-og.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->fullUrl() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind (build via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet (Peta Interaktif) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* ================================
        PAGE TRANSITION
        ================================ */

        #page-transition {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #FAF9F6;
            pointer-events: none;
            opacity: 0;
            transform: translateY(8px);
            transition:
                opacity 220ms ease,
                transform 220ms ease;
        }

        #page-transition.is-leaving {
            opacity: 1;
            transform: translateY(0);
        }

        body.page-ready main {
            animation: pageEnter 420ms cubic-bezier(.22, 1, .36, 1);
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #page-transition,
            body.page-ready main {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="bg-[#FAF9F6] text-slate-800 antialiased">

    {{-- Page Transition --}}
    <div id="page-transition"></div>

{{-- ============ EMERGENCY BAR ============ --}}
@if ($emergencyContacts->count() > 0 || $pengumumanDarurat)
    <div class="bg-[#0B1F3A] text-white text-xs relative z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-2 flex items-center justify-between gap-4">

            {{-- Kontak Darurat --}}
            @if ($emergencyContacts->count() > 0)
                <div class="flex items-center gap-4 flex-shrink-0">

                    @foreach ($emergencyContacts->take(4) as $contact)
                        <a href="tel:{{ $contact->nomor_telepon }}"
                           class="flex items-center gap-1.5 hover:text-amber-300 transition">

                            <svg class="w-3.5 h-3.5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A2 2 0 0121 8.28V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>

                            <span>
                                {{ $contact->label }}
                            </span>
                        </a>
                    @endforeach

                </div>
            @endif


            {{-- Pengumuman Darurat --}}
            @if ($pengumumanDarurat)
                <div class="flex-1 overflow-hidden relative hidden md:block">

                    <div class="whitespace-nowrap animate-marquee text-amber-300">
                        ⚠️ {{ $pengumumanDarurat->judul }}
                        — {{ Str::limit($pengumumanDarurat->isi, 100) }}
                    </div>

                </div>
            @endif

        </div>
    </div>
@endif

<style>
    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    .animate-marquee {
        display: inline-block;
        animation: marquee 20s linear infinite;
    }
</style>

    {{-- ============ NAVBAR ============ --}}
    <header
        x-data="{ 
            open: false, 
            scrolled: false,
            emergency: {{ ($emergencyContacts->count() > 0 || $pengumumanDarurat) ? 'true' : 'false' }}
        }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="[
            emergency ? 'top-8' : 'top-0',
            scrolled ? 'bg-white/95 backdrop-blur shadow-sm' : 'bg-gradient-to-b from-black/40 to-transparent'
        ]"
        class="fixed left-0 right-0 z-40 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo2.png') }}"
                            alt="Logo Kelurahan Tebing Tinggi Okura"
                            class="w-full h-full object-contain">
                    </div>
                    <span :class="scrolled ? 'text-[#0B1F3A]' : 'text-white'" class="font-bold text-sm sm:text-base transition-colors">
                        Tebing Tinggi Okura
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-8">

                    {{-- Profil --}}
                    <a href="{{ route('profil') }}"
                    :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                    class="text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">
                        Profil
                    </a>

                    {{-- Layanan --}}
                    <a href="{{ route('layanan.index') }}"
                    :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                    class="text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">
                        Layanan
                    </a>

                    {{-- Informasi Dropdown --}}
                    <div class="relative" x-data="{ informasiOpen: false }">

                        <button
                            @click="informasiOpen = !informasiOpen"
                            @click.away="informasiOpen = false"
                            :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                            class="flex items-center gap-1.5 text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">

                            Informasi

                            <svg
                                class="w-4 h-4 transition-transform duration-200"
                                :class="informasiOpen ? 'rotate-180' : ''"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div
                            x-show="informasiOpen"
                            x-cloak
                            x-transition
                            class="absolute left-1/2 -translate-x-1/2 top-full mt-4 w-48
                                bg-white rounded-xl shadow-xl border border-slate-100
                                py-2 overflow-hidden">

                            <a href="{{ route('berita.index') }}"
                            class="block px-5 py-3 text-sm text-slate-600
                                    hover:bg-slate-50 hover:text-emerald-600 transition">
                                Berita
                            </a>

                            <a href="{{ route('agenda.index') }}"
                            class="block px-5 py-3 text-sm text-slate-600
                                    hover:bg-slate-50 hover:text-emerald-600 transition">
                                Agenda
                            </a>

                            <a href="{{ route('pengumuman.index') }}"
                            class="block px-5 py-3 text-sm text-slate-600
                                    hover:bg-slate-50 hover:text-emerald-600 transition">
                                Pengumuman
                            </a>

                        </div>
                    </div>

                    {{-- Wisata --}}
                    <a href="{{ route('wisata.index') }}"
                    :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                    class="text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">
                        Wisata
                    </a>

                    {{-- UMKM --}}
                    <a href="{{ route('umkm.index') }}"
                    :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                    class="text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">
                        UMKM
                    </a>

                    {{-- Galeri --}}
                    <a href="{{ route('galeri.index') }}"
                    :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-slate-100 hover:text-amber-300'"
                    class="text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">
                        Galeri
                    </a>

                </nav>

                <a href="{{ route('pengaduan.create') }}"
                   class="hidden md:inline-flex items-center px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition">
                    Lapor Sekarang
                </a>

                <button @click="open = !open" class="md:hidden p-2 rounded-lg" :class="scrolled ? 'text-slate-700' : 'text-white'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak x-transition class="md:hidden bg-white shadow-lg border-t border-slate-100">
            <div class="px-4 py-4 space-y-1">

                <a href="{{ route('profil') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    Profil
                </a>

                <a href="{{ route('layanan.index') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    Layanan
                </a>

                {{-- Informasi --}}
                <div x-data="{ informasiMobileOpen: false }">

                    <button
                        @click="informasiMobileOpen = !informasiMobileOpen"
                        class="w-full flex items-center justify-between px-3 py-2.5
                            rounded-lg text-slate-700 hover:bg-slate-50
                            text-sm font-medium">

                        <span>Informasi</span>

                        <svg
                            class="w-4 h-4 transition-transform"
                            :class="informasiMobileOpen ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="informasiMobileOpen"
                        x-cloak
                        x-transition
                        class="ml-3 mt-1 space-y-1">

                        <a href="{{ route('berita.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm text-slate-500 hover:bg-slate-50 hover:text-emerald-600">
                            Berita
                        </a>

                        <a href="{{ route('agenda.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm text-slate-500 hover:bg-slate-50 hover:text-emerald-600">
                            Agenda
                        </a>

                        <a href="{{ route('pengumuman.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm text-slate-500 hover:bg-slate-50 hover:text-emerald-600">
                            Pengumuman
                        </a>

                    </div>
                </div>

                <a href="{{ route('wisata.index') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    Wisata
                </a>

                <a href="{{ route('umkm.index') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    UMKM
                </a>

                <a href="{{ route('galeri.index') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    Galeri
                </a>

                <a href="{{ route('pengaduan.create') }}"
                class="block px-3 py-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-sm font-medium">
                    Lapor Pengaduan
                </a>

            </div>
        </div>
    </header>

    {{-- ============ FLASH MESSAGES ============ --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-sky-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('info') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition x-cloak
             class="fixed top-20 right-4 z-50 bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- ============ MAIN CONTENT ============ --}}
    <main>
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-[#0B1F3A] text-slate-300 pt-16 pb-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-10 border-b border-white/10">

            {{-- Identitas Kelurahan --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo2.png') }}"
                             alt="Logo Kelurahan Tebing Tinggi Okura"
                             class="w-full h-full object-contain">
                    </div>

                    <div>
                        <p class="font-bold text-white">
                            Kelurahan Tebing Tinggi Okura
                        </p>
                        <p class="text-xs text-slate-400">
                            Kecamatan Rumbai Pesisir, Kota Pekanbaru
                        </p>
                    </div>
                </div>

                <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                    Portal resmi Kelurahan Tebing Tinggi Okura untuk memberikan
                    informasi pemerintahan, pelayanan publik, berita, potensi
                    wisata, dan UMKM kepada masyarakat.
                </p>
            </div>


            {{-- Tautan Cepat --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">
                    Tautan Cepat
                </h4>

                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('profil') }}"
                           class="text-slate-400 hover:text-emerald-400 transition-colors">
                            Profil Kelurahan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('layanan.index') }}"
                           class="text-slate-400 hover:text-emerald-400 transition-colors">
                            Layanan Surat
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('wisata.index') }}"
                           class="text-slate-400 hover:text-emerald-400 transition-colors">
                            Wisata Okura
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('umkm.index') }}"
                    class="text-slate-400 hover:text-emerald-400 transition-colors">
                                Direktori UMKM
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('berita.index') }}"
                            class="text-slate-400 hover:text-emerald-400 transition-colors">
                                Berita & Kegiatan
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('agenda.index') }}"
                            class="text-slate-400 hover:text-emerald-400 transition-colors">
                                Agenda
                            </a>
                        </li>
                    </ul>
                </div>


                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">
                        Kontak
                    </h4>

                    <ul class="space-y-3 text-sm">

                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 mt-0.5 text-emerald-400 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 21l-4.243-4.343a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>

                            <span class="text-slate-400">
                                Jl. Kelurahan Okura, Rumbai Pesisir, Pekanbaru
                            </span>
                        </li>

                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>

                            <span class="text-slate-400">
                                kelurahan.okura@pekanbaru.go.id
                            </span>
                        </li>

                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.45 1.92l-1.27 1.27a16 16 0 006.28 6.28l1.27-1.27a2 2 0 011.92-.45l2.8.7A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C9.61 23 1 14.39 1 4V3a2 2 0 012-2z"/>
                            </svg>

                            <span class="text-slate-400">
                                (0761) 000-000
                            </span>
                        </li>

                    </ul>
                </div>

            </div>


            {{-- Copyright --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-6">

                <p class="text-xs text-slate-500 text-center sm:text-left">
                    &copy; {{ date('Y') }} Kelurahan Tebing Tinggi Okura.
                    Seluruh Hak Dilindungi.
                </p>

                <p class="text-xs text-slate-600 text-center sm:text-right">
                    Website Kelurahan Tebing Tinggi Okura
                </p>

            </div>

        </div>
    </footer>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
            (function () {

                function resetPageTransition() {
                    const transition = document.getElementById('page-transition');

                    if (transition) {
                        transition.classList.remove('is-leaving');
                    }

                    document.body.classList.add('page-ready');
                }

                // Saat halaman pertama kali dibuka
                document.addEventListener('DOMContentLoaded', function () {

                    resetPageTransition();

                    const transition = document.getElementById('page-transition');

                    if (!transition) {
                        return;
                    }

                    document.querySelectorAll('a[href]').forEach(function (link) {

                        link.addEventListener('click', function (event) {

                            const href = this.getAttribute('href');

                            if (
                                !href ||
                                href.startsWith('#') ||
                                href.startsWith('javascript:') ||
                                href.startsWith('mailto:') ||
                                href.startsWith('tel:') ||
                                this.target === '_blank' ||
                                event.ctrlKey ||
                                event.metaKey ||
                                event.shiftKey ||
                                event.altKey
                            ) {
                                return;
                            }

                            const url = new URL(href, window.location.origin);

                            // Jangan animasikan link ke website lain
                            if (url.origin !== window.location.origin) {
                                return;
                            }

                            // Jangan animasikan kalau tetap di halaman yang sama
                            if (
                                url.pathname === window.location.pathname &&
                                url.search === window.location.search
                            ) {
                                return;
                            }

                            event.preventDefault();

                            transition.classList.add('is-leaving');

                            setTimeout(function () {
                                window.location.href = href;
                            }, 220);

                        });

                    });

                });

                // ==========================================
                // FIX BROWSER BACK / FORWARD
                // ==========================================
                window.addEventListener('pageshow', function () {
                    resetPageTransition();
                });

            })();
    });
</script>