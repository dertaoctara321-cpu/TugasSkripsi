<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheHeaders
{
    /**
     * Prevent the browser from caching admin pages so redirects
     * after create/update/delete always show fresh data.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent all forms of browser caching including bfcache (Back-Forward Cache)
        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->header('Surrogate-Control', 'no-store');
    }
}
