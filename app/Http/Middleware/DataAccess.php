<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user?->canManageData()) {
            return $this->deny($request, 'Akses modul data tidak tersedia untuk role Anda.');
        }

        if ($request->route()?->getActionMethod() === 'destroy' && ! $user->canDeleteData()) {
            return $this->deny($request, 'Hanya Admin yang dapat menghapus data.');
        }

        return $next($request);
    }

    private function deny(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }

        return redirect()->route('dashboard')->with('error', $message);
    }
}
