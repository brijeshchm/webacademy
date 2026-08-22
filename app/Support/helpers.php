<?php

use App\Support\JsonLd;
use Illuminate\Support\Facades\App;

if (!function_exists('json_ld')) {
    /**
     * json_encode a JSON-LD schema array for safe inline embedding inside a
     * <script type="application/ld+json"> tag. Hex-escapes HTML-significant
     * characters so a stored '</script>' payload cannot break out of the tag.
     *
     * @param  array<string,mixed>  $schema
     */
    function json_ld(array $schema): string
    {
        return JsonLd::encode($schema);
    }
}

if (!function_exists('locale_messages')) {
    /**
     * Load and cache the decoded locale JSON for a given code (in-process).
     *
     * @return array<string,mixed>
     */
    function locale_messages(string $locale): array
    {
        static $cache = [];

        if (array_key_exists($locale, $cache)) {
            return $cache[$locale];
        }

        $path = base_path("lang/i18n/{$locale}.json");
        if (!is_file($path)) {
            return $cache[$locale] = [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return $cache[$locale] = is_array($decoded) ? $decoded : [];
    }
}

if (!function_exists('t')) {
    /**
     * i18next-style translation lookup against the active locale JSON.
     *
     * - Nested dot-key resolution (e.g. "nav.courses").
     * - {{var}} placeholder interpolation from $replace.
     * - Falls back to English, then to the key itself.
     *
     * @param  array<string,scalar>  $replace
     */
    function t(string $key, array $replace = []): string
    {
        $active = App::getLocale() ?: 'en';

        $resolve = static function (string $locale) use ($key) {
            $node = locale_messages($locale);
            foreach (explode('.', $key) as $segment) {
                if (is_array($node) && array_key_exists($segment, $node)) {
                    $node = $node[$segment];
                } else {
                    return null;
                }
            }

            return is_string($node) ? $node : null;
        };

        $value = $resolve($active);
        if ($value === null && $active !== 'en') {
            $value = $resolve('en');
        }
        if ($value === null) {
            $value = $key;
        }

        foreach ($replace as $name => $val) {
            $value = str_replace('{{' . $name . '}}', (string) $val, $value);
        }

        return $value;
    }
}
