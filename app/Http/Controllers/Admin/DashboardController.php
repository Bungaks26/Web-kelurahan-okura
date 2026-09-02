<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\JanjiTemu;
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use App\Models\SiteSetting;
use App\Models\Umkm;
use App\Models\Wisata;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            // Pengaduan
            'pengaduan_masuk' => Pengaduan::where('status', 'diterima')->count(),
            'pengaduan_proses' => Pengaduan::where('status', 'diproses')->count(),

            // Layanan Surat
            'surat_diajukan' => LayananSurat::where('status', 'diajukan')->count(),
            'surat_proses' => LayananSurat::where('status', 'diproses')->count(),

            // Janji Temu
            'janji_temu_menunggu' => JanjiTemu::where('status', 'menunggu')->count(),

            // Konten
            'total_berita' => Berita::count(),
            'berita_published' => Berita::where('status', 'published')->count(),
            'total_wisata' => Wisata::where('status', 'aktif')->count(),
            'total_umkm' => Umkm::where('status', 'aktif')->count(),

            // Statistik Website
            'jumlah_penduduk' => SiteSetting::get('jumlah_penduduk', 0),

            // Status layanan
            'layanan_surat_aktif' => SiteSetting::get('layanan_surat_aktif', '1'),
            'pengaduan_aktif' => SiteSetting::get('pengaduan_aktif', '1'),
            'janji_temu_aktif' => SiteSetting::get('janji_temu_aktif', '1'),
        ];

        /*
         * Grafik pengaduan masuk 7 hari terakhir
         */
        $aduanChart = Pengaduan::query()
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->where(
                'created_at',
                '>=',
                now()->subDays(6)->startOfDay()
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');

            $chartLabels[] = now()
                ->subDays($i)
                ->translatedFormat('d M');

            $chartData[] = $aduanChart[$date]->total ?? 0;
        }

        /*
         * Distribusi kategori pengaduan
         */
        $kategoriAduan = Pengaduan::query()
            ->select(
                'kategori',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        /*
         * Data terbaru
         */
        $pengaduanTerbaru = Pengaduan::latest()
            ->take(5)
            ->get();

        $suratTerbaru = LayananSurat::latest()
            ->take(5)
            ->get();

        $janjiTemuTerbaru = JanjiTemu::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'summary',
            'chartLabels',
            'chartData',
            'kategoriAduan',
            'pengaduanTerbaru',
            'suratTerbaru',
            'janjiTemuTerbaru'
        ));
    }
}