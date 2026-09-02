{{-- resources/views/frontend/layanan/track-result.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Hasil Lacak Surat')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">

    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 border border-slate-100">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <p class="text-xs text-slate-400">Kode Tiket</p>
                <p class="font-mono font-bold text-lg text-[#0B1F3A]">
                    {{ $surat->kode_tiket }}
                </p>
            </div>

            <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $surat->statusBadgeColor() }}">
                {{ ucfirst($surat->status) }}
            </span>

        </div>


        {{-- Detail Pengajuan --}}
        <div class="space-y-5">

            <div>
                <p class="text-xs text-slate-400">Jenis Surat</p>
                <p class="text-sm font-semibold text-slate-800">
                    {{ $surat->jenis_surat }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Nama Pemohon</p>
                <p class="text-sm text-slate-700">
                    {{ $surat->nama_pemohon }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Keperluan</p>
                <p class="text-sm text-slate-700 leading-relaxed">
                    {{ $surat->keperluan }}
                </p>
            </div>

        </div>


        {{-- Download Surat --}}
        @if ($surat->status === 'selesai' && $surat->file_hasil)

            <div class="mt-8 rounded-xl bg-emerald-50 border border-emerald-100 p-5">

                <p class="text-sm font-semibold text-emerald-700">
                    Surat telah selesai diproses
                </p>

                <p class="text-sm text-slate-600 mt-1">
                    Surat Anda sudah diterbitkan dan siap diunduh.
                </p>

                @if ($downloadUrl)
                    <a href="{{ $downloadUrl }}"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v11a2 2 0 01-2 2z"/>
                        </svg>

                        Unduh Surat (PDF)

                    </a>
                @endif

            </div>

        @else

            <div class="mt-8 rounded-xl bg-slate-50 border border-slate-200 p-5">

                <p class="text-sm font-semibold text-slate-700">
                    Pengajuan sedang diproses
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Silakan simpan kode tiket Anda dan lakukan pengecekan kembali secara berkala.
                </p>

            </div>

        @endif

    </div>

</section>
@endsection

