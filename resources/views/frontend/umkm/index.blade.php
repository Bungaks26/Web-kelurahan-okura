{{-- resources/views/frontend/umkm/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'UMKM Warga')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full
                        bg-[#009B3A]/10 text-[#009B3A]
                        text-xs sm:text-sm font-semibold mb-4">
                UMKM Kelurahan
            </span>

            <h1 class="text-4xl sm:text-5xl font-bold text-[#151515] tracking-tight"
                style="font-family: 'Plus Jakarta Sans', sans-serif;">
                UMKM Warga Tebing Tinggi Okura
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base text-slate-500 leading-relaxed">
                Dukung produk lokal masyarakat dan temukan berbagai usaha unggulan
                Kelurahan Tebing Tinggi Okura.
            </p>

        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            @foreach (['' => 'Semua', 'kuliner' => 'Kuliner', 'kerajinan' => 'Kerajinan', 'jasa' => 'Jasa', 'pertanian' => 'Pertanian', 'lainnya' => 'Lainnya'] as $val => $label)
                <a href="{{ route('umkm.index', ['kategori' => $val]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('kategori', '') == $val ? 'bg-[#009B3A] text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-[#009B3A] hover:text-[#009B3A]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            @forelse ($umkms as $umkm)
                <a href="{{ route('umkm.show', $umkm->id) }}"
                    class="group flex flex-col rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 p-4 h-full">
                    <div class="h-40 rounded-xl overflow-hidden mb-4">
                        <img src="{{ $umkm->foto_produk
                            ? asset('storage/'.$umkm->foto_produk)
                            : ($umkm->foto
                                ? asset('storage/'.$umkm->foto)
                                : asset('images/placeholder.jpg')) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            alt="{{ $umkm->nama_usaha }}"
                            loading="lazy">
                    </div>
                    <div class="flex-1 flex flex-col">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-semibold text-base text-slate-800 line-clamp-2 group-hover:text-[#009B3A] transition-colors">
                                {{ $umkm->nama_usaha }}
                            </h3>
                        </div>

                        <p class="text-xs text-[#009B3A] font-semibold mt-2 capitalize">
                            {{ $umkm->kategori }}
                        </p>

                        @if($umkm->alamat)
                            <p class="text-sm text-slate-500 mt-3 line-clamp-2">
                                {{ $umkm->alamat }}
                            </p>
                        @endif

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">

                            <span class="text-xs font-medium text-slate-500">
                                Produk Lokal
                            </span>

                            <span class="text-sm font-semibold text-[#009B3A]">
                                Detail →
                            </span>

                        </div>

                    </div>
                </a>
            @empty
                <p class="col-span-4 text-center text-slate-400 text-sm py-16">Belum ada data UMKM.</p>
            @endforelse
        </div>

        @if ($umkms->hasPages())
            <div class="mt-10">{{ $umkms->links() }}</div>
        @endif
    </div>
</section>
@endsection
