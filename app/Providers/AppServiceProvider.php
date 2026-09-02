<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EmergencyContact;
use App\Models\Pengumuman;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rate limit login admin
        RateLimiter::for('login', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return Limit::perMinute(5)
                ->by($email . '|' . $request->ip());
        });

        RateLimiter::for('tracking', function (Request $request) {
            $kodeTiket = strtoupper(trim((string) $request->input('kode_tiket')));

            return Limit::perMinute(5)
                ->by($request->ip() . '|' . $kodeTiket);
        });

        // Data yang digunakan bersama oleh seluruh layout frontend
        View::composer('*', function ($view) {
            $view->with(
                'siteSettings',
                SiteSetting::pluck('value', 'key')->toArray()
            );
        });

        View::composer('layouts.frontend', function ($view) {
            $view->with([
                'emergencyContacts' => EmergencyContact::active()->get(),

                'pengumumanDarurat' => Pengumuman::active()
                    ->where('kategori', 'darurat')
                    ->latest()
                    ->first(),
            ]);
        });
    }
}