<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminPassword = env('ADMIN_PASSWORD');

        // Fail closed: if ADMIN_PASSWORD is not configured, refuse all admin access.
        if (empty($adminPassword)) {
            return response()->json([
                'error' => 'Server configuration error: ADMIN_PASSWORD is not set.',
            ], 500);
        }

        $provided = (string) ($request->header('x-admin-password') ?? '');

        // Timing-safe comparison to prevent timing attacks.
        if (!hash_equals($adminPassword, $provided)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
