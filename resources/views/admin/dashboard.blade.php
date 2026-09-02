{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- ================= SUMMARY ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Penduduk --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 border border-slate-100">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Jumlah Penduduk
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format((int) $summary['jumlah_penduduk'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Data dari Pengaturan
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 flex items-center justify-center text-lg">
                    👥
                </div>
            </div>
        </div>


        {{-- Aduan --}}
        <a href="{{ route('admin.pengaduan.index') }}"
           class="bg-white rounded-2xl shadow-sm hover:shadow-md p-5 border border-slate-100 transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Aduan Baru
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['pengaduan_masuk'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        {{ $summary['pengaduan_proses'] }} sedang diproses
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg">
                    📢
                </div>

            </div>
        </a>


        {{-- Surat --}}
        <a href="{{ route('admin.layanan-surat.index') }}"
           class="bg-white rounded-2xl shadow-sm hover:shadow-md p-5 border border-slate-100 transition">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-xs font-medium text-slate-500">
                        Surat Diajukan
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($summary['surat_diajukan'], 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        {{ $summary['surat_proses'] }} sedang diproses
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-lg">
                    📄
                </div>

            </div>
        </a>


        {{-- Janji Temu --}}
        <a href="{{ route('admin.janji-temu.index') }}"
           class="bg-white rounded-2xl shadow-sm hover:shadow-md p-5 border border-slate-100 transition">

            <div class="flex items-start justify-between gap-4">

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

                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center text-lg">
                    📅
                </div>

            </div>
        </a>

    </div>


    {{-- ================= CONTENT SUMMARY ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">

        {{-- Berita --}}
        <a href="{{ route('admin.berita.index') }}"
           class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-5 transition">

            <p class="text-xs text-slate-500">
                Berita
            </p>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                {{ number_format($summary['total_berita'], 0, ',', '.') }}
            </p>

            <p class="text-xs text-emerald-600 mt-1">
                {{ $summary['berita_published'] }} sudah dipublikasikan
            </p>

        </a>


        {{-- Wisata --}}
        <a href="{{ route('admin.wisata.index') }}"
           class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-5 transition">

            <p class="text-xs text-slate-500">
                Wisata
            </p>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                {{ number_format($summary['total_wisata'], 0, ',', '.') }}
            </p>

            <p class="text-xs text-slate-400 mt-1">
                Destinasi aktif
            </p>

        </a>


        {{-- UMKM --}}
        <a href="{{ route('admin.umkm.index') }}"
           class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md p-5 transition">

            <p class="text-xs text-slate-500">
                UMKM
            </p>

            <p class="text-2xl font-bold text-slate-800 mt-2">
                {{ number_format($summary['total_umkm'], 0, ',', '.') }}
            </p>

            <p class="text-xs text-slate-400 mt-1">
                UMKM aktif
            </p>

        </a>

    </div>


    {{-- ================= STATUS LAYANAN ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">

        <div class="flex items-center justify-between mb-5">

            <div>
                <h3 class="font-semibold text-slate-800">
                    Status Layanan Online
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Status layanan berdasarkan Pengaturan Website.
                </p>
            </div>

            <a href="{{ route('admin.pengaturan.index') }}"
               class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                Kelola Pengaturan →
            </a>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

            @php
                $serviceStatuses = [
                    [
                        'label' => 'Layanan Surat',
                        'value' => $summary['layanan_surat_aktif'],
                    ],
                    [
                        'label' => 'Pengaduan Masyarakat',
                        'value' => $summary['pengaduan_aktif'],
                    ],
                    [
                        'label' => 'Janji Temu',
                        'value' => $summary['janji_temu_aktif'],
                    ],
                ];
            @endphp

            @foreach ($serviceStatuses as $service)

                @php
                    $aktif = $service['value'] === '1';
                @endphp

                <div class="flex items-center justify-between p-4 rounded-xl border
                            {{ $aktif ? 'border-emerald-100 bg-emerald-50/50' : 'border-slate-100 bg-slate-50' }}">

                    <span class="text-sm font-medium text-slate-700">
                        {{ $service['label'] }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $aktif
                            ? 'bg-emerald-100 text-emerald-700'
                            : 'bg-slate-200 text-slate-500' }}">

                        <span class="w-1.5 h-1.5 rounded-full
                            {{ $aktif ? 'bg-emerald-500' : 'bg-slate-400' }}">
                        </span>

                        {{ $aktif ? 'Aktif' : 'Nonaktif' }}

                    </span>

                </div>

            @endforeach

        </div>

    </div>


    {{-- ================= CHARTS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-slate-100">

            <h3 class="font-semibold text-slate-800 mb-4 text-sm">
                Aduan Masuk (7 Hari Terakhir)
            </h3>

            <canvas id="chartAduan" height="90"></canvas>

        </div>


        <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">

            <h3 class="font-semibold text-slate-800 mb-4 text-sm">
                Kategori Aduan
            </h3>

            <canvas id="chartKategori" height="200"></canvas>

        </div>

    </div>


    {{-- ================= TABLES ================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Pengaduan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="flex items-center justify-between p-5 border-b border-slate-100">

                <h3 class="font-semibold text-slate-800 text-sm">
                    Pengaduan Terbaru
                </h3>

                <a href="{{ route('admin.pengaduan.index') }}"
                   class="text-xs text-emerald-600 font-medium hover:underline">
                    Semua
                </a>

            </div>

            <div class="divide-y divide-slate-50">

                @forelse ($pengaduanTerbaru as $item)

                    <a href="{{ route('admin.pengaduan.show', $item) }}"
                       class="block px-5 py-3.5 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-sm font-medium text-slate-700 truncate">
                                    {{ $item->judul_aduan }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $item->nama_pelapor }}
                                    ·
                                    {{ $item->created_at->diffForHumans() }}
                                </p>

                            </div>

                            <span class="px-2 py-1 rounded-full text-[11px] font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                                {{ ucfirst($item->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <p class="text-sm text-slate-400 text-center py-8">
                        Belum ada pengaduan.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Surat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="flex items-center justify-between p-5 border-b border-slate-100">

                <h3 class="font-semibold text-slate-800 text-sm">
                    Pengajuan Surat
                </h3>

                <a href="{{ route('admin.layanan-surat.index') }}"
                   class="text-xs text-emerald-600 font-medium hover:underline">
                    Semua
                </a>

            </div>

            <div class="divide-y divide-slate-50">

                @forelse ($suratTerbaru as $item)

                    <a href="{{ route('admin.layanan-surat.show', $item) }}"
                       class="block px-5 py-3.5 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-sm font-medium text-slate-700 truncate">
                                    {{ $item->jenis_surat }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $item->nama_pemohon }}
                                    ·
                                    {{ $item->created_at->diffForHumans() }}
                                </p>

                            </div>

                            <span class="px-2 py-1 rounded-full text-[11px] font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                                {{ ucfirst($item->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <p class="text-sm text-slate-400 text-center py-8">
                        Belum ada pengajuan surat.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Janji Temu --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="flex items-center justify-between p-5 border-b border-slate-100">

                <h3 class="font-semibold text-slate-800 text-sm">
                    Janji Temu Terbaru
                </h3>

                <a href="{{ route('admin.janji-temu.index') }}"
                   class="text-xs text-emerald-600 font-medium hover:underline">
                    Semua
                </a>

            </div>

            <div class="divide-y divide-slate-50">

                @forelse ($janjiTemuTerbaru as $item)

                    <a href="{{ route('admin.janji-temu.show', $item) }}"
                       class="block px-5 py-3.5 hover:bg-slate-50 transition">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-sm font-medium text-slate-700 truncate">
                                    {{ $item->nama_pemohon }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $item->tanggal_diinginkan?->format('d/m/Y') ?? '-' }}
                                    ·
                                    {{ $item->created_at->diffForHumans() }}
                                </p>

                            </div>

                            <span class="px-2 py-1 rounded-full text-[11px] font-medium flex-shrink-0 {{ $item->statusBadgeColor() }}">
                                {{ ucfirst($item->status) }}
                            </span>

                        </div>

                    </a>

                @empty

                    <p class="text-sm text-slate-400 text-center py-8">
                        Belum ada janji temu.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    new Chart(document.getElementById('chartAduan'), {
        type: 'line',

        data: {
            labels: @json($chartLabels),

            datasets: [{
                label: 'Aduan',
                data: @json($chartData),
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
            }]
        },

        options: {
            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });


    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',

        data: {
            labels: @json($kategoriAduan->keys()),

            datasets: [{
                data: @json($kategoriAduan->values()),

                backgroundColor: [
                    '#059669',
                    '#D97706',
                    '#0284C7',
                    '#DC2626',
                    '#7C3AED'
                ],

                borderWidth: 0,
            }]
        },

        options: {
            plugins: {
                legend: {
                    position: 'bottom',

                    labels: {
                        boxWidth: 10,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>

@endpush