<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $wisatas = Wisata::when(
            $request->search,
            fn ($query) => $query->where(
                'nama',
                'like',
                '%' . $request->search . '%'
            )
        )
        ->latest()
        ->paginate(10);

        return view('staf.wisata.index', compact('wisatas'));
    }

    public function create()
    {
        return view('staf.wisata.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'harga_tiket' => 'nullable|string|max:100',
            'jam_operasional' => 'nullable|string|max:100',
            'kontak' => 'nullable|string|max:100',
        ]);

        $validated['slug'] =
            Str::slug($validated['nama']) . '-' . Str::random(5);

        // Wisata dari Staf wajib menunggu persetujuan Super Admin
        $validated['status'] = 'pending';

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] =
                $request->file('thumbnail')->store('wisata', 'public');
        }

        Wisata::create($validated);

        return redirect()
            ->route('staf.wisata.index')
            ->with(
                'success',
                'Data wisata berhasil diajukan dan menunggu persetujuan Super Admin.'
            );
    }
}