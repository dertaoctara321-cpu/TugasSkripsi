<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if (!$request->user()->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki hak akses untuk halaman ini.',
                ], 403);
            }

            // Redirect user to their default landing page based on their role
            $user = $request->user();
            if ($user->isDapur() || $user->isKasir()) {
                return redirect()->route('orders.index')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk membuka halaman tersebut.');
            }

            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk membuka halaman tersebut.');
        }

        return $next($request);
    }
}
