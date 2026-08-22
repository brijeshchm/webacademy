<?php

namespace App\Http\Middleware;

use App\Services\AdminAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin routes require a valid, unexpired session token obtained via
 * POST /api/admin/login — the same x-admin-token flow the React admin
 * panel already uses against the Node API.
 */
class CheckAdminToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = AdminAuth::extractToken($request);
        if (!$token || !AdminAuth::verifyToken($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
