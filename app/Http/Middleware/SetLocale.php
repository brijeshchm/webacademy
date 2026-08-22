<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Selects the active UI locale for server-rendered pages.
 *
 * Priority: ?lng= query param -> `lng` cookie -> default `en`.
 * When ?lng= is present and valid, persist it in a 1-year cookie.
 */
class SetLocale
{
    public const SUPPORTED = ['en', 'hi', 'zh', 'fr', 'es', 'de', 'ru', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        $queryLng = $request->query('lng');
        $cookieLng = $request->cookie('lng');

        $locale = 'en';
        $shouldPersist = false;

        if (is_string($queryLng) && in_array($queryLng, self::SUPPORTED, true)) {
            $locale = $queryLng;
            $shouldPersist = true;
        } elseif (is_string($cookieLng) && in_array($cookieLng, self::SUPPORTED, true)) {
            $locale = $cookieLng;
        }

        app()->setLocale($locale);

        $response = $next($request);

        if ($shouldPersist) {
            // 1 year, unencrypted (see EncryptCookies except-list).
            $response->headers->setCookie(
                Cookie::make('lng', $locale, 525600)
            );
        }

        return $response;
    }
}
