<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Pegawai;
use App\Models\Umkm;
use App\Models\Wisata;
use App\Models\Pengumuman;
use App\Models\Galeri;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $banners = \App\Models\HeroBanner::active()->ordered()->get();
        $wisatas = Wisata::active()->latest()->take(6)->get();
        $umkms = Umkm::active()->latest()->take(8)->get();
        $emergencyContacts = \App\Models\EmergencyContact::active()->get();

        // Data untuk counter homepage
        $jumlahWisata = Wisata::active()->count();
        $jumlahUmkm = Umkm::active()->count();
        $jumlahPenduduk = SiteSetting::get('jumlah_penduduk', 0);

        // Pengumuman darurat untuk emergency bar
        $pengumumanDarurat = Pengumuman::active()
            ->where('kategori', 'darurat')
            ->latest()
            ->first();

        // Pengumuman umum untuk ditampilkan di halaman utama
        $pengumumans = Pengumuman::active()
            ->where('kategori', '!=', 'darurat')
            ->latest('tanggal_mulai')
            ->take(3)
            ->get();

        $galeris = Galeri::latest()->take(6)->get();

        $siteSettings = SiteSetting::pluck('value', 'key')->toArray();

        return view('frontend.index', compact(
            'banners',
            'wisatas',
            'umkms',
            'jumlahWisata',
            'jumlahUmkm',
            'jumlahPenduduk',
            'emergencyContacts',
            'pengumumanDarurat',
            'pengumumans',
            'galeris'
        ));
    }

    public function profil()
    {
        $pegawais = Pegawai::active()->ordered()->get();
        $agendas = Agenda::upcoming()->take(5)->get();

        return view('frontend.profil', compact('pegawais', 'agendas'));
    }
}