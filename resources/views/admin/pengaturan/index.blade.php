@extends('layouts.admin')

@section('page-title', 'Pengaturan Website')

@section('content')

<div class="max-w-5xl space-y-6">

    {{-- INFORMASI KELURAHAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">

        <div class="mb-6">
            <h2 class="text-lg font-bold text-slate-800">
                Informasi Kelurahan
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Informasi utama yang digunakan pada website.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nama Kelurahan
                </label>

                <input
                    type="text"
                    name="nama_kelurahan"
                    form="pengaturan-form"
                    value="{{ old('nama_kelurahan', $settings['nama_kelurahan'] ?? 'Tebing Tinggi Okura') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Kecamatan
                </label>

                <input
                    type="text"
                    name="kecamatan"
                    form="pengaturan-form"
                    value="{{ old('kecamatan', $settings['kecamatan'] ?? 'Rumbai Pesisir') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Kota
                </label>

                <input
                    type="text"
                    name="kota"
                    form="pengaturan-form"
                    value="{{ old('kota', $settings['kota'] ?? 'Pekanbaru') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Provinsi
                </label>

                <input
                    type="text"
                    name="provinsi"
                    form="pengaturan-form"
                    value="{{ old('provinsi', $settings['provinsi'] ?? 'Riau') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Kode Pos
                </label>

                <input
                    type="text"
                    name="kode_pos"
                    form="pengaturan-form"
                    value="{{ old('kode_pos', $settings['kode_pos'] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Alamat Kantor
                </label>

                <input
                    type="text"
                    name="alamat_kantor"
                    form="pengaturan-form"
                    value="{{ old('alamat_kantor', $settings['alamat_kantor'] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>

            <div class="md:col-span-2">

                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Deskripsi Singkat
                </label>

                <textarea
                    name="deskripsi_kelurahan"
                    form="pengaturan-form"
                    rows="4"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('deskripsi_kelurahan', $settings['deskripsi_kelurahan'] ?? '') }}</textarea>

            </div>

        </div>

    </div>


    {{-- KONTAK --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-800">
                Kontak & Pelayanan
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Kontak resmi dan informasi jam pelayanan kelurahan.
            </p>

        </div>


        <div class="grid md:grid-cols-3 gap-5 mb-6">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Telepon
                </label>

                <input
                    type="text"
                    name="telepon"
                    form="pengaturan-form"
                    value="{{ old('telepon', $settings['telepon'] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    WhatsApp
                </label>

                <input
                    type="text"
                    name="whatsapp"
                    form="pengaturan-form"
                    value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    form="pengaturan-form"
                    value="{{ old('email', $settings['email'] ?? '') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>

        </div>


        <div>

            <h3 class="text-sm font-semibold text-slate-700 mb-3">
                Jam Pelayanan
            </h3>

            <div class="grid md:grid-cols-2 gap-3">

                @foreach ([
                    'senin' => 'Senin',
                    'selasa' => 'Selasa',
                    'rabu' => 'Rabu',
                    'kamis' => 'Kamis',
                    'jumat' => 'Jumat',
                    'sabtu' => 'Sabtu',
                    'minggu' => 'Minggu',
                ] as $key => $label)

                    <div class="flex items-center gap-3">

                        <label class="w-20 text-sm text-slate-600">
                            {{ $label }}
                        </label>

                        <input
                            type="text"
                            name="jam_{{ $key }}"
                            form="pengaturan-form"
                            value="{{ old('jam_'.$key, $settings['jam_'.$key] ?? '') }}"
                            placeholder="08.00 - 15.00"
                            class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm">

                    </div>

                @endforeach

            </div>

        </div>

    </div>


    {{-- MEDIA SOSIAL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-800">
                Media Sosial
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Masukkan URL akun resmi kelurahan. Kosongkan jika tidak digunakan.
            </p>

        </div>


        <div class="grid md:grid-cols-2 gap-5">

            @foreach ([
                'instagram' => 'Instagram',
                'facebook' => 'Facebook',
                'youtube' => 'YouTube',
                'tiktok' => 'TikTok',
            ] as $key => $label)

                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ $label }}
                    </label>

                    <input
                        type="url"
                        name="{{ $key }}"
                        form="pengaturan-form"
                        value="{{ old($key, $settings[$key] ?? '') }}"
                        placeholder="https://..."
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">

                </div>

            @endforeach

        </div>

    </div>


    {{-- LAYANAN ONLINE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-800">
                Layanan Online
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Aktifkan atau nonaktifkan layanan yang tersedia untuk masyarakat.
            </p>

        </div>


        <div class="space-y-4">

            @foreach ([
                'layanan_surat_aktif' => 'Layanan Surat',
                'pengaduan_aktif' => 'Pengaduan Masyarakat',
                'janji_temu_aktif' => 'Janji Temu',
            ] as $key => $label)

                <label class="flex items-center justify-between
                              p-4 rounded-xl border border-slate-100
                              hover:bg-slate-50 transition cursor-pointer">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            {{ $label }}
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Izinkan masyarakat menggunakan layanan ini.
                        </p>

                    </div>

                    <div class="relative">

                        <input
                            type="checkbox"
                            name="{{ $key }}"
                            form="pengaturan-form"
                            value="1"
                            class="peer sr-only"
                            {{ old($key, $settings[$key] ?? '1') == '1' ? 'checked' : '' }}>

                        <div class="w-11 h-6 bg-slate-200 rounded-full
                                    peer-checked:bg-emerald-600 transition">
                        </div>

                        <div class="absolute top-1 left-1
                                    w-4 h-4 rounded-full bg-white
                                    transition-all
                                    peer-checked:translate-x-5">
                        </div>

                    </div>

                </label>

            @endforeach

        </div>

    </div>


    {{-- STATISTIK --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">

        <div class="mb-5">

            <h2 class="text-lg font-bold text-slate-800">
                Statistik
            </h2>

            <p class="text-sm text-slate-400 mt-1">
                Data yang ditampilkan pada homepage.
            </p>

        </div>


        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            Jumlah Penduduk
        </label>

        <input
            type="number"
            name="jumlah_penduduk"
            form="pengaturan-form"
            value="{{ old('jumlah_penduduk', $settings['jumlah_penduduk'] ?? 0) }}"
            required
            min="0"
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">

        <p class="text-xs text-slate-400 mt-1.5">
            Angka ini ditampilkan pada counter homepage.
        </p>

    </div>


    {{-- FORM SIMPAN --}}
    <form
        id="pengaturan-form"
        action="{{ route('admin.pengaturan.update') }}"
        method="POST">

        @csrf
        @method('PUT')

        <button
            type="submit"
            class="w-full py-3 rounded-xl
                   bg-emerald-600 hover:bg-emerald-700
                   text-white text-sm font-semibold
                   transition">

            Simpan Semua Pengaturan

        </button>

    </form>

</div>

@endsection