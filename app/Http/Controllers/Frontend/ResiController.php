<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\LayananSurat;
use App\Models\Pengaduan;
use App\Models\Wisata;
use App\Models\Umkm;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ResiController extends Controller
{
    /**
     * Deteksi jenis tiket dan mengambil data terkait.
     */
    protected function resolveTiket(string $kodeTiket): ?array
    {
        $prefix = strtoupper(substr($kodeTiket, 0, 3));

        return match (true) {
            $prefix === 'ADU' => $this->wrap(
                'pengaduan',
                Pengaduan::where('kode_tiket', $kodeTiket)->first()
            ),

            $prefix === 'JTM' => $this->wrap(
                'janji_temu',
                JanjiTemu::where('kode_tiket', $kodeTiket)->first()
            ),

            in_array($prefix, ['SKT', 'SKU', 'DOM', 'LHR', 'SRT']) => $this->wrap(
                'layanan_surat',
                LayananSurat::where('kode_tiket', $kodeTiket)->first()
            ),

            default => null,
        };
    }

    protected function wrap(string $jenis, $data): ?array
    {
        return $data
            ? [
                'jenis' => $jenis,
                'data' => $data,
            ]
            : null;
    }

    /**
     * Memastikan user memiliki akses yang sah ke resi ini.
     *
     * Ada dua kondisi:
     * 1. Akses baru saja diberikan setelah submit.
     * 2. Akses diberikan setelah verifikasi tracking.
     */
    protected function authorizeResi(string $kodeTiket): void
    {
        $kodeTiket = strtoupper(trim($kodeTiket));

        // Akses tracking
        if (
            session('tracking_expires_at') &&
            now()->timestamp > session('tracking_expires_at')
        ) {
            session()->forget([
                'tracking_verified',
                'tracking_kode_tiket',
                'tracking_jenis',
                'tracking_expires_at',
            ]);
        }

        // Akses resi setelah submit
        if (
            session('resi_expires_at') &&
            now()->timestamp > session('resi_expires_at')
        ) {
            session()->forget([
                'resi_kode_tiket',
                'resi_expires_at',
            ]);
        }

        $hasTrackingAccess =
            session('tracking_verified') === true &&
            session('tracking_kode_tiket') === $kodeTiket &&
            session('tracking_expires_at') &&
            now()->timestamp <= session('tracking_expires_at');

        $hasResiAccess =
            session('resi_kode_tiket') === $kodeTiket &&
            session('resi_expires_at') &&
            now()->timestamp <= session('resi_expires_at');

        abort_unless(
            $hasTrackingAccess || $hasResiAccess,
            403
        );
    }

    public function show(string $kodeTiket)
    {
        $kodeTiket = strtoupper(trim($kodeTiket));

        $this->authorizeResi($kodeTiket);

        $tiket = $this->resolveTiket($kodeTiket);

        if (! $tiket) {
            abort(404, 'Kode tiket tidak ditemukan.');
        }

        $trackingUrl = route('resi.show', $kodeTiket);
        $qrCode = QrCode::size(200)->generate($trackingUrl);

        return view('frontend.resi.show', [
            'jenis' => $tiket['jenis'],
            'item' => $tiket['data'],
            'qrCode' => $qrCode,
            'trackingUrl' => $trackingUrl,
        ]);
    }

    public function download(string $kodeTiket)
    {
        $kodeTiket = strtoupper(trim($kodeTiket));

        $this->authorizeResi($kodeTiket);

        $tiket = $this->resolveTiket($kodeTiket);

        if (! $tiket) {
            abort(404, 'Kode tiket tidak ditemukan.');
        }

        $trackingUrl = route('resi.show', $kodeTiket);

        $qrCodeBase64 = base64_encode(
            QrCode::size(180)->generate($trackingUrl)
        );

        $pdf = Pdf::loadView('frontend.resi.pdf', [
            'jenis' => $tiket['jenis'],
            'item' => $tiket['data'],
            'qrCodeBase64' => $qrCodeBase64,
        ])->setPaper([0, 0, 400, 600]);

        return $pdf->download("resi-{$kodeTiket}.pdf");
    }
}