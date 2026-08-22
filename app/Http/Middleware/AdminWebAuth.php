<?php

namespace App\Http\Middleware;

use App\Services\AdminAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Server-rendered admin panel guard. Validates the admin session token stored
 * in the Laravel session via AdminAuth (the same service the API uses). When
 * the token is missing or expired, redirect to the login form with a graceful
 * "session expired" flash instead of a JSON 401.
 */
class AdminWebAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->session()->get('admin_token');

        if (!$token || !AdminAuth::verifyToken($token)) {
            // Clean up a stale token so the login form starts fresh.
            if ($token) {
                $request->session()->forget('admin_token');
            }

            return redirect()
                ->route('admin.login')
                ->with('error', 'Your session expired, please log in again.');
        }

        return $next($request);
    }
}
