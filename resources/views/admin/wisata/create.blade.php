{{-- resources/views/admin/wisata/create.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Tambah Wisata')

@section('content')
<div class="max-w-3xl">

    <form action="{{ route('admin.wisata.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-5">

        @csrf

        {{-- Nama Wisata --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Nama Wisata <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                required
                placeholder="Contoh: Wisata Sungai Siak"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">

            @error('nama')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Deskripsi <span class="text-red-500">*</span>
            </label>

            <textarea
                name="deskripsi"
                rows="5"
                required
                placeholder="Jelaskan mengenai wisata ini..."
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                       outline-none resize-none">{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Alamat --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Alamat <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="alamat"
                value="{{ old('alamat') }}"
                required
                placeholder="Masukkan alamat/lokasi wisata"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">

            @error('alamat')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Lokasi di Peta --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Lokasi di Peta
            </label>

            <div
                id="peta-pilih-lokasi"
                class="w-full h-72 rounded-xl border border-slate-200 mb-3 overflow-hidden">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">
                        Latitude
                    </label>

                    <input
                        type="text"
                        id="latitude"
                        name="latitude"
                        value="{{ old('latitude') }}"
                        placeholder="Latitude"
                        readonly
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200
                               text-sm bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1">
                        Longitude
                    </label>

                    <input
                        type="text"
                        id="longitude"
                        name="longitude"
                        value="{{ old('longitude') }}"
                        placeholder="Longitude"
                        readonly
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200
                               text-sm bg-slate-50">
                </div>

            </div>

            <p class="text-xs text-slate-400 mt-1.5">
                Klik pada peta untuk menentukan lokasi wisata.
            </p>

            @error('latitude')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror

            @error('longitude')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Harga & Jam Operasional --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Harga Tiket
                </label>

                <input
                    type="text"
                    name="harga_tiket"
                    value="{{ old('harga_tiket') }}"
                    placeholder="Contoh: Rp10.000"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Jam Operasional
                </label>

                <input
                    type="text"
                    name="jam_operasional"
                    value="{{ old('jam_operasional') }}"
                    placeholder="Contoh: 08.00 - 17.00"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
            </div>

        </div>


        {{-- Kontak --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Kontak
            </label>

            <input
                type="text"
                name="kontak"
                value="{{ old('kontak') }}"
                placeholder="Nomor telepon/WhatsApp pengelola"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
        </div>


        {{-- Status --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Status <span class="text-red-500">*</span>
            </label>

            <select
                name="status"
                required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                       focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">

                <option value="aktif"
                    {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="nonaktif"
                    {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>

            </select>
        </div>


        {{-- Thumbnail --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Thumbnail
            </label>

            <input
                type="file"
                name="thumbnail"
                accept="image/*"
                class="w-full text-sm text-slate-500
                       file:mr-4 file:py-2 file:px-4 file:rounded-xl
                       file:border-0 file:bg-emerald-50 file:text-emerald-700
                       file:font-medium hover:file:bg-emerald-100">

            <p class="text-xs text-slate-400 mt-1.5">
                Gunakan gambar JPG, JPEG, PNG, atau WEBP.
            </p>

            @error('thumbnail')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Tombol --}}
        <div class="flex items-center gap-3 pt-3">

            <button
                type="submit"
                class="px-5 py-2.5 rounded-xl bg-emerald-600
                       hover:bg-emerald-700 text-white text-sm font-semibold
                       transition">
                Simpan Wisata
            </button>

            <a
                href="{{ route('admin.wisata.index') }}"
                class="px-5 py-2.5 rounded-xl border border-slate-200
                       text-slate-600 text-sm font-medium hover:bg-slate-50
                       transition">
                Batal
            </a>

        </div>

    </form>

</div>
@endsection


@push('scripts')

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Posisi awal: Kantor Kelurahan Tebing Tinggi Okura
        const defaultLat = 0.5712465050879031;
        const defaultLng = 101.53889059635989;

        const oldLat = "{{ old('latitude') }}";
        const oldLng = "{{ old('longitude') }}";

        const lat = oldLat ? parseFloat(oldLat) : defaultLat;
        const lng = oldLng ? parseFloat(oldLng) : defaultLng;

        const map = L.map('peta-pilih-lokasi').setView(
            [lat, lng],
            15
        );

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        let marker = null;

        // Jika sebelumnya sudah memilih lokasi
        if (oldLat && oldLng) {
            marker = L.marker([lat, lng]).addTo(map);
        }

        map.on('click', function (e) {

            const selectedLat = e.latlng.lat.toFixed(7);
            const selectedLng = e.latlng.lng.toFixed(7);

            document.getElementById('latitude').value = selectedLat;
            document.getElementById('longitude').value = selectedLng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([
                e.latlng.lat,
                e.latlng.lng
            ]).addTo(map);

        });

        // Memastikan ukuran map terbaca dengan benar
        setTimeout(function () {
            map.invalidateSize();
        }, 200);

    });
</script>

@endpush