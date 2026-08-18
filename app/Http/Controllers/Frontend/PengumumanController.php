<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::active()
            ->latest('tanggal_mulai')
            ->paginate(10);

        return view('frontend.pengumuman.index', compact('pengumumans'));
    }

    public function show(Pengumuman $pengumuman)
    {
        // Pastikan hanya pengumuman aktif yang bisa dilihat publik
        if ($pengumuman->status !== 'aktif') {
            abort(404);
        }

        if (
            $pengumuman->tanggal_selesai &&
            $pengumuman->tanggal_selesai->lt(now()->startOfDay())
        ) {
            abort(404);
        }

        return view('frontend.pengumuman.show', compact('pengumuman'));
    }
}