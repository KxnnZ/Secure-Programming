<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request and apply CSP header.
     *
     * The policy below is intentionally restrictive but allows
     * necessary sources for this app (self, data:, font, img, styles, scripts).
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $policy = collect([
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdn.jsdelivr.net/npm",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "img-src 'self' data: https://images.tmdb.org https://via.placeholder.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "connect-src 'self' https://api.themoviedb.org",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ])->implode('; ');

        $response->headers->set('Content-Security-Policy', $policy);

        // Optionally add additional security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Permissions-Policy', 'geolocation=(), camera=()');

        return $response;
    }
}
