<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

/**
 * GET /api/sitemap.xml
 *
 * Dynamic sitemap listing every course from the database — mirrors the
 * Express route at artifacts/api-server/src/routes/sitemap.ts.
 *
 * robots.txt declares both this endpoint and the static public_html
 * sitemap.xml (core pages + categories), so search engines get the full
 * picture without course URLs ever going stale.
 *
 * The domain used in <loc> values comes from config('services.site.origin')
 * (SITE_ORIGIN env var, read via config() so it survives `config:cache`).
 */
class SitemapController extends Controller
{
    public function courses(): Response
    {
        $origin = rtrim((string) config('services.site.origin'), '/');

        $slugs = Course::query()
            ->orderBy('id')
            ->pluck('slug');

        $entries = $slugs->map(function (string $slug) use ($origin): string {
            $loc = htmlspecialchars($origin . '/courses/' . $slug, ENT_QUOTES | ENT_XML1, 'UTF-8');

            return "  <url>\n"
                . "    <loc>{$loc}</loc>\n"
                . "    <changefreq>weekly</changefreq>\n"
                . "    <priority>0.8</priority>\n"
                . '  </url>';
        })->implode("\n");

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
            . "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n"
            . $entries . "\n"
            . '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            // Cache for 1 hour in CDN/proxies; fresh fetch every time from origin
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
        ]);
    }
}
