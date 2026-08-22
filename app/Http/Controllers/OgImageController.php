<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

/**
 * Dynamic OG image — generates a 1200×630 PNG with the live course count.
 *
 * Renders from scratch with GD so the stats line is always current.
 * Falls back to the static og-image.jpg if GD is unavailable.
 */
class OgImageController extends Controller
{
    private const W = 1200;
    private const H = 630;

    public function show(): Response
    {
        if (! extension_loaded('gd')) {
            return $this->staticFallback();
        }

        try {
            $totalCourses = Course::count();
        } catch (\Throwable) {
            return $this->staticFallback();
        }

        // Round down to nearest 10 for "490+" style
        $countLabel = (floor($totalCourses / 10) * 10) . '+';
        $statsText  = "{$countLabel} Courses  ·  63,000+ Professionals Trained";

        $font = $this->resolveFont();
        if (! $font) {
            return $this->staticFallback();
        }

        $img = $this->render($countLabel, $statsText, $font);
        if (! $img) {
            return $this->staticFallback();
        }

        ob_start();
        imagepng($img);
        $data = ob_get_clean();
        imagedestroy($img);

        return response($data ?: '', $data ? 200 : 500, [
            'Content-Type'  => 'image/png',
            'Cache-Control' => 'public, max-age=3600, stale-while-revalidate=86400',
        ]);
    }

    // ─── Rendering ────────────────────────────────────────────────────────

    /** @return \GdImage|false */
    private function render(string $countLabel, string $statsText, string $font)
    {
        $img = imagecreatetruecolor(self::W, self::H);
        if (! $img) return false;

        // ── Background: dark navy gradient (top → bottom) ─────────────────
        for ($y = 0; $y < self::H; $y++) {
            $ratio = $y / self::H;
            $r = (int)(4  + $ratio * 2);
            $g = (int)(10 + $ratio * 4);
            $b = (int)(30 + $ratio * 12);
            $col = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, self::W, $y, $col);
        }

        // Subtle right-side radial glow (lighter blue around ring centre x=870)
        $glow = imagecolorallocatealpha($img, 26, 58, 110, 90);
        imagefilledellipse($img, 870, self::H / 2, 500, 500, $glow);

        // ── Decorative concentric rings (right side) ──────────────────────
        $cx = 870; $cy = 315;
        foreach ([200, 160, 120, 80] as $i => $r) {
            $alpha = [90, 80, 70, 90][$i];
            $rc    = imagecolorallocatealpha($img, 30, 80, 180, $alpha);
            imagearc($img, $cx, $cy, $r * 2, $r * 2, 0, 360, $rc);
        }

        // Graduation cap (simplified polygon inside ring)
        $capColour  = imagecolorallocate($img, 93, 168, 250);
        $capColour2 = imagecolorallocate($img, 147, 197, 253);
        // Mortarboard base diamond
        imagefilledpolygon($img, [870,248, 935,280, 870,312, 805,280], $capColour);
        // Brim ellipse on top
        imagefilledellipse($img, 870, 248, 84, 20, $capColour2);
        // Tassel stem
        imagefilledrectangle($img, 907, 279, 913, 318, $capColour);
        imagefilledellipse($img, 910, 322, 14, 14, imagecolorallocate($img, 59, 130, 246));

        // ── Logo mark: partial circle + triangle ──────────────────────────
        $red = imagecolorallocate($img, 229, 62, 62);
        $white = imagecolorallocate($img, 255, 255, 255);

        // Arc (≈ 270° of a circle, leaving a gap on the right)
        imagesetthickness($img, 7);
        imagearc($img, 108, 190, 56, 56, 45, 315, $red);
        imagesetthickness($img, 1);
        // Play triangle pointing right
        imagefilledpolygon($img, [122, 179, 140, 190, 122, 201], $red);

        // ── Brand name ────────────────────────────────────────────────────
        $nameFontSize = 62;
        imagettftext($img, $nameFontSize, 0, 160, 195, $white, $font, 'Corporate');
        imagettftext($img, $nameFontSize, 0, 160, 270, $white, $font, 'Academy');

        // ── Tagline ───────────────────────────────────────────────────────
        $grey = imagecolorallocate($img, 160, 174, 192);
        imagettftext($img, 22, 0, 160, 318, $grey, $font, 'Expert-Led Tech Training & Certifications');

        // ── Red accent underline ──────────────────────────────────────────
        imagesetthickness($img, 4);
        imageline($img, 160, 342, 280, 342, $red);
        imagesetthickness($img, 1);

        // ── Stats line ────────────────────────────────────────────────────
        imagettftext($img, 26, 0, 160, 400, $red, $font, $statsText);

        return $img;
    }

    // ─── Helpers ──────────────────────────────────────────────────────────

    private function resolveFont(): ?string
    {
        $candidates = [
            resource_path('fonts/DejaVuSans-Bold.ttf'),
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
        ];
        foreach ($candidates as $path) {
            if (file_exists($path)) return $path;
        }
        return null;
    }

    /** Stream the static JPEG so OG tags never 404 if GD is unavailable. */
    private function staticFallback(): Response
    {
        $file = public_path('og-image.jpg');
        if (file_exists($file)) {
            return response((string) file_get_contents($file), 200, [
                'Content-Type'  => 'image/jpeg',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }
        return response('', 204);
    }
}
