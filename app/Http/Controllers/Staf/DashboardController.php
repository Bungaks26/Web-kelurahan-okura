<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\Pengaduan;
use App\Models\LayananSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            'aduan_baru' => Pengaduan::where('status', 'diterima')->count(),

            'surat_masuk' => LayananSurat::where('status', 'diajukan')->count(),

            'janji_temu_menunggu' => JanjiTemu::where('status', 'menunggu')->count(),

            'sedang_diproses' =>
                Pengaduan::where('status', 'diproses')->count()
                + LayananSurat::where('status', 'diproses')->count(),

            'selesai' =>
                Pengaduan::where('status', 'selesai')->count()
                + LayananSurat::where('status', 'selesai')->count(),
        ];

        $pengaduanTerbaru = Pengaduan::latest()
            ->take(5)
            ->get();

        $suratTerbaru = LayananSurat::latest()
            ->take(5)
            ->get();

        $janjiTemuTerbaru = JanjiTemu::latest()
            ->take(5)
            ->get();

        return view('staf.dashboard', compact(
            'summary',
            'pengaduanTerbaru',
            'suratTerbaru',
            'janjiTemuTerbaru'
        ));
    }
}