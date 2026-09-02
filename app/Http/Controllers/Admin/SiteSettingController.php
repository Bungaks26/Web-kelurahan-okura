<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $keys = [
            'jumlah_penduduk',

            'nama_kelurahan',
            'kecamatan',
            'kota',
            'provinsi',
            'kode_pos',
            'alamat_kantor',
            'deskripsi_kelurahan',

            'telepon',
            'whatsapp',
            'email',

            'jam_senin',
            'jam_selasa',
            'jam_rabu',
            'jam_kamis',
            'jam_jumat',
            'jam_sabtu',
            'jam_minggu',

            'instagram',
            'facebook',
            'youtube',
            'tiktok',

            'layanan_surat_aktif',
            'pengaduan_aktif',
            'janji_temu_aktif',
        ];

        $settings = [];

        foreach ($keys as $key) {
            $settings[$key] = SiteSetting::get($key);
        }

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'jumlah_penduduk' => 'required|integer|min:0',

            'nama_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:20',
            'alamat_kantor' => 'nullable|string|max:500',
            'deskripsi_kelurahan' => 'nullable|string|max:1000',

            'telepon' => 'nullable|string|max:30',
            'whatsapp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',

            'jam_senin' => 'nullable|string|max:100',
            'jam_selasa' => 'nullable|string|max:100',
            'jam_rabu' => 'nullable|string|max:100',
            'jam_kamis' => 'nullable|string|max:100',
            'jam_jumat' => 'nullable|string|max:100',
            'jam_sabtu' => 'nullable|string|max:100',
            'jam_minggu' => 'nullable|string|max:100',

            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',

            'layanan_surat_aktif' => 'nullable|boolean',
            'pengaduan_aktif' => 'nullable|boolean',
            'janji_temu_aktif' => 'nullable|boolean',
        ]);

        $checkboxes = [
            'layanan_surat_aktif',
            'pengaduan_aktif',
            'janji_temu_aktif',
        ];

        foreach ($validated as $key => $value) {
            if (!in_array($key, $checkboxes)) {
                SiteSetting::set($key, $value);
            }
        }

        foreach ($checkboxes as $key) {
            SiteSetting::set(
                $key,
                $request->boolean($key) ? '1' : '0'
            );
        }

        return redirect()
            ->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}