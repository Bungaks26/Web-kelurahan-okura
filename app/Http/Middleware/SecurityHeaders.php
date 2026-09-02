<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        $response->headers->set(
            'Permissions-Policy',
            'geolocation=()'
        );

        // $response->headers->set(
        //     'Content-Security-Policy',
        //     "default-src 'self'; " .
        //     "script-src 'self' 'unsafe-inline' https://unpkg.com https://cdn.jsdelivr.net; " .
        //     "style-src 'self' 'unsafe-inline' https://unpkg.com https://fonts.googleapis.com; " .
        //     "font-src 'self' https://fonts.gstatic.com data:; " .
        //     "img-src 'self' data: blob: https://*.tile.openstreetmap.org https://*.openstreetmap.org; " .
        //     "connect-src 'self' https://*.tile.openstreetmap.org https://*.openstreetmap.org; " .
        //     "frame-ancestors 'self'; " .
        //     "base-uri 'self'; " .
        //     "form-action 'self' https://wa.me;"
        // );

        return $response;
    }
}