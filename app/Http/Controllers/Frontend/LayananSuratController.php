<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LayananSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\SiteSetting;

class LayananSuratController extends Controller
{
        // Daftar jenis surat yang bisa diajukan, dengan syarat masing-masing
        public array $jenisSurat = [
        'sktm' => [
            'label' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'syarat' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            'template' => 'templates/sktm-template.pdf',
        ],

        'sku' => [
            'label' => 'Surat Keterangan Usaha (SKU)',
            'syarat' => ['KTP', 'KK', 'Foto Usaha'],
            'template' => 'templates/sku-template.pdf',
        ],

        'domisili' => [
            'label' => 'Surat Keterangan Domisili',
            'syarat' => ['KTP', 'KK'],
            'template' => 'templates/domisili-template.pdf',
        ],

        'nikah' => [
            'label' => 'Surat Pengantar Nikah',
            'syarat' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            'template' => 'templates/nikah-template.pdf',
        ],

        'ahli-waris' => [
            'label' => 'Surat Keterangan Ahli Waris',
            'syarat' => ['KTP Ahli Waris', 'KK', 'KTP Pewaris', 'Surat Kematian'],
            'template' => 'templates/ahli-waris-template.pdf',
        ],

        'skck' => [
            'label' => 'Surat Keterangan SKCK',
            'syarat' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            'template' => 'templates/skck-template.pdf',
        ],
    ];

    public function index()
    {
        if (SiteSetting::get('layanan_surat_aktif', '1') !== '1') {
            abort(503, 'Layanan Surat sedang dinonaktifkan.');
        }
        $jenisSurat = $this->jenisSurat;
        return view('frontend.layanan.index', compact('jenisSurat'));
    }

    public function create(?string $jenis = null)
    {
        if (SiteSetting::get('layanan_surat_aktif', '1') !== '1') {
            abort(503, 'Layanan Surat sedang dinonaktifkan.');
        }

        if ($jenis && ! array_key_exists($jenis, $this->jenisSurat)) {
            abort(404);
        }

        $jenisSurat = $this->jenisSurat;
        return view('frontend.layanan.create', compact('jenisSurat', 'jenis'));
    }

    public function store(Request $request)
    {
        if (SiteSetting::get('layanan_surat_aktif', '1') !== '1') {
        abort(503, 'Layanan Surat sedang dinonaktifkan.');
        }

        $validated = $request->validate([
            'jenis_surat' => 'required|in:' . implode(',', array_keys($this->jenisSurat)),
            'nama_pemohon' => 'required|string|max:255',
            'nik'          => 'required|string|size:16',
            'no_hp'        => 'required|string|max:20',
            'keperluan'    => 'required|string|min:10',
            'berkas.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:20048',
        ], [
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
        ]);

        $validated['kode_tiket'] = LayananSurat::generateKodeTiket();
        $validated['status'] = 'diajukan';
        $validated['jenis_surat'] = $this->jenisSurat[$validated['jenis_surat']]['label'];

        // Upload multi-file persyaratan
        $berkasPaths = [];
        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $file) {
                $berkasPaths[] = $file->store('layanan-surat', 'local');
            }
        }
        $validated['berkas_persyaratan'] = $berkasPaths;

        $surat = LayananSurat::create($validated);

        session([
            'resi_kode_tiket' => $surat->kode_tiket,
            'resi_expires_at' => now()->addMinutes(15)->timestamp,
        ]);

        return redirect()
            ->route('resi.show', $surat->kode_tiket)
            ->with('success', "Pengajuan berhasil dikirim! Kode tiket Anda: {$surat->kode_tiket}. Simpan kode ini untuk melacak status.")
            ->with('kode_tiket', $surat->kode_tiket);
    }

    public function trackForm()
    {
        return view('frontend.layanan.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
            'nik'        => 'required|string',
        ]);

        $surat = LayananSurat::where('kode_tiket', $request->kode_tiket)
            ->where('nik', $request->nik)
            ->first();

        if (! $surat) {
            return back()
                ->withInput()
                ->withErrors(['kode_tiket' => 'Kode tiket atau NIK tidak ditemukan. Periksa kembali data Anda.']);
        }

        $downloadUrl = null;

        if ($surat->status === 'selesai' && $surat->file_hasil) {
            $downloadUrl = URL::temporarySignedRoute(
                'layanan.download',
                now()->addMinutes(10),
                ['kodeTiket' => $surat->kode_tiket]
            );
        }

        return view(
            'frontend.layanan.track-result',
            compact('surat', 'downloadUrl')
        );
    }

    public function download(string $kodeTiket)
    {
        $surat = LayananSurat::where('kode_tiket', $kodeTiket)->firstOrFail();

        abort_unless(
            $surat->status === 'selesai' &&
            $surat->file_hasil,
            404
        );

        abort_unless(
            \Storage::disk('local')->exists($surat->file_hasil),
            404
        );

        return \Storage::disk('local')->download(
            $surat->file_hasil,
            'surat-' . $surat->kode_tiket . '.pdf'
        );
    }
}
