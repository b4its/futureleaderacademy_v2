<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsPengajar
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'pengajar'])) {
            abort(403, 'Akses ditolak. Hanya pengajar yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
