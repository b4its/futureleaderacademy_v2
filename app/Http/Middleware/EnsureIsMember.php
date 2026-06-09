<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsMember
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'member'])) {
            abort(403, 'Akses ditolak. Hanya member yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
