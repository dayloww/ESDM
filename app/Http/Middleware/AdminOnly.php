<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Izinkan hanya admin mengakses route tertentu.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Akses ini hanya tersedia untuk Admin.');
        }

        return $next($request);
    }
}
