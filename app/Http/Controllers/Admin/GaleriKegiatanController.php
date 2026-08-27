<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriKegiatanController extends Controller
{
    public function index()
    {
        $galeri = GaleriKegiatan::latest('tanggal')
            ->latest('id')
            ->get();

        return view('admin.galeri.index', compact('galeri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:1000',

            // Maksimal 3 foto sekaligus
            'foto' => 'required|array|max:3',

            // Maksimal 10 MB per foto
            'foto.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'judul.required' => 'Judul kegiatan wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'foto.required' => 'Minimal satu foto harus dipilih.',
            'foto.max' => 'Maksimal 3 foto sekaligus.',
            'foto.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 10 MB.',
        ]);

        foreach ($request->file('foto') as $file) {
            $path = $file->store('galeri-kegiatan', 'public');

            GaleriKegiatan::create([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'foto' => $path,
            ]);
        }

        return redirect()
            ->route('admin.galeri-kegiatan.index')
            ->with('success', count($request->file('foto')) . ' foto berhasil ditambahkan ke galeri.');
    }

    public function destroy(GaleriKegiatan $galeriKegiatan)
    {
        if ($galeriKegiatan->foto) {
            Storage::disk('public')->delete($galeriKegiatan->foto);
        }

        $galeriKegiatan->delete();

        return redirect()
            ->route('admin.galeri-kegiatan.index')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}