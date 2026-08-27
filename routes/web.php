<?php

use Illuminate\Support\Facades\Route;

// Import Controllers - Frontend
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\WisataController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Frontend\PengaduanController;
use App\Http\Controllers\Frontend\LayananSuratController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\JanjiTemuController;
use App\Http\Controllers\Frontend\ResiController;
use App\Http\Controllers\Frontend\UniversalTrackingController;
use App\Http\Controllers\Frontend\PendaftaranController;
use App\Http\Controllers\Frontend\PengumumanController as FrontendPengumumanController;
use App\Http\Controllers\Frontend\GaleriController as FrontendGaleriController;
use App\Http\Controllers\Frontend\AgendaController as FrontendAgendaController;

// Import Controllers - Auth
use App\Http\Controllers\Auth\LoginController;

// Import Controllers - Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\WisataController as AdminWisataController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\AdminPengaduanController;
use App\Http\Controllers\Admin\LayananSuratController as AdminLayananSuratController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroBannerController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\SocialPostController;
use App\Http\Controllers\Admin\SiteSettingController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (PUBLIK)
|--------------------------------------------------------------------------
*/

// Home & General
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/cari', [SearchController::class, 'index'])->name('search');

// Pengumuman
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    Route::get('/', [FrontendPengumumanController::class, 'index'])->name('index');
    Route::get('/{pengumuman}', [FrontendPengumumanController::class, 'show'])->name('show');
});

// Galeri & Agenda (FRONTEND)
Route::get('/galeri', [FrontendGaleriController::class, 'index'])->name('galeri.index');
Route::get('/agenda', [FrontendAgendaController::class, 'index'])->name('agenda.index');

// Janji Temu
Route::get('/janji-temu', [JanjiTemuController::class, 'create'])->name('janji-temu.create');
Route::post('/janji-temu', [JanjiTemuController::class, 'store'])->name('janji-temu.store');

// Resi & Tracking
Route::get('/resi/{kodeTiket}', [ResiController::class, 'show'])->name('resi.show');
Route::get('/resi/{kodeTiket}/download', [ResiController::class, 'download'])->name('resi.download');
Route::post('/lacak', [UniversalTrackingController::class, 'track'])->name('tracking.universal');

// Wisata
Route::prefix('wisata')->name('wisata.')->group(function () {
    Route::get('/', [WisataController::class, 'index'])->name('index');
    Route::get('/{slug}', [WisataController::class, 'show'])->name('show');
});

// UMKM
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
    Route::get('/{id}', [UmkmController::class, 'show'])->name('show');
});

// Berita
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [FrontendBeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [FrontendBeritaController::class, 'show'])->name('show');
});

// Layanan Surat
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [LayananSuratController::class, 'index'])->name('index');
    Route::get('/ajukan/{jenis?}', [LayananSuratController::class, 'create'])->name('create');
    Route::post('/ajukan', [LayananSuratController::class, 'store'])->name('store');
    Route::get('/lacak', [LayananSuratController::class, 'trackForm'])->name('track.form');
    Route::post('/lacak', [LayananSuratController::class, 'track'])->name('track');
});

// Pengaduan
Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
    Route::get('/', [PengaduanController::class, 'create'])->name('create');
    Route::post('/', [PengaduanController::class, 'store'])->name('store');
    Route::get('/lacak', [PengaduanController::class, 'trackForm'])->name('track.form');
    Route::post('/lacak', [PengaduanController::class, 'track'])->name('track');
});

// Pendaftaran
Route::prefix('daftar')->name('pendaftaran.')->group(function () {
    Route::get('/wisata', [PendaftaranController::class, 'createWisata'])->name('wisata.create');
    Route::post('/wisata', [PendaftaranController::class, 'storeWisata'])->name('wisata.store');
    Route::get('/umkm', [PendaftaranController::class, 'createUmkm'])->name('umkm.create');
    Route::post('/umkm', [PendaftaranController::class, 'storeUmkm'])->name('umkm.store');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Emergency Contact
    Route::resource('emergency-contact', EmergencyContactController::class)
        ->except(['create', 'edit', 'show']);

    Route::put('/emergency-contact/{emergencyContact}/toggle',
        [EmergencyContactController::class, 'toggle'])
        ->name('emergency-contact.toggle');

    // Agenda Admin
    Route::resource('agenda', AgendaController::class)->except(['show']);

    // Berita
    Route::resource('berita', BeritaController::class)->parameters([
        'berita' => 'berita',
    ]);

    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class);

    // Wisata
    Route::resource('wisata', AdminWisataController::class)
        ->parameters([
            'wisata' => 'wisata',
    ]);

    // UMKM
    Route::resource('umkm', AdminUmkmController::class);

    // Layanan Surat Admin
    Route::get('/layanan-surat', [AdminLayananSuratController::class, 'index'])
        ->name('layanan-surat.index');

    Route::get('/layanan-surat/{layananSurat}', [AdminLayananSuratController::class, 'show'])
        ->name('layanan-surat.show');

    Route::put('/layanan-surat/{layananSurat}', [AdminLayananSuratController::class, 'update'])
        ->name('layanan-surat.update');

    Route::post('/layanan-surat/{layananSurat}/mark-notified', [AdminLayananSuratController::class, 'markNotified'])
        ->name('layanan-surat.mark-notified');

    Route::delete('/layanan-surat/{layananSurat}', [AdminLayananSuratController::class, 'destroy'])
        ->name('layanan-surat.destroy');

    // Gallery untuk Wisata, UMKM, dan Berita
    Route::get('/gallery/{type}/{id}', [GalleryController::class, 'index'])
        ->name('gallery.index');

    Route::post('/gallery/{type}/{id}', [GalleryController::class, 'store'])
        ->name('gallery.store');

    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])
        ->name('gallery.destroy');

    // Pegawai
    Route::resource('pegawai', PegawaiController::class);

    // Galeri
    Route::resource('galeri', GaleriController::class)
        ->except(['show', 'edit', 'update']);

    // Pengaduan Admin
    Route::get('/pengaduan-export/excel', [AdminPengaduanController::class, 'exportExcel'])
        ->name('pengaduan.export.excel');

    Route::get('/pengaduan-export/pdf', [AdminPengaduanController::class, 'exportPdf'])
        ->name('pengaduan.export.pdf');

    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])
        ->name('pengaduan.index');

    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])
        ->name('pengaduan.show');

    Route::put('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'update'])
        ->name('pengaduan.update');

    Route::post('/pengaduan/{pengaduan}/mark-notified', [AdminPengaduanController::class, 'markNotified'])
        ->name('pengaduan.mark-notified');

    Route::delete('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'destroy'])
        ->name('pengaduan.destroy');

    // Hero Banner
    Route::post('hero-banner/reorder', [HeroBannerController::class, 'reorder'])
        ->name('hero-banner.reorder');

    Route::resource('hero-banner', HeroBannerController::class)
        ->except(['show']);
    
    // Pengaturan
    Route::get('/pengaturan', [SiteSettingController::class, 'index'])
        ->name('pengaturan.index');

    Route::put('/pengaturan', [SiteSettingController::class, 'update'])
        ->name('pengaturan.update');
});