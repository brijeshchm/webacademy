<?php

namespace App\Support;

/**
 * JSON-LD structured-data builders mirroring the React PageSEO.tsx builders.
 * Origin comes from config('services.site.origin').
 */
class JsonLd
{
    /**
     * json_encode flags for embedding structured data inside an inline
     * <script type="application/ld+json"> tag.
     *
     * JSON_HEX_TAG hex-escapes `<` and `>` (so a stored `</script>` payload
     * becomes `\u003C/script\u003E` and can never terminate the script tag),
     * JSON_HEX_AMP/APOS/QUOT escape the remaining HTML-significant characters,
     * and JSON_UNESCAPED_UNICODE keeps non-ASCII text readable. We deliberately
     * do NOT use JSON_UNESCAPED_SLASHES — escaped slashes are valid JSON and
     * add a second layer of `</script>` safety.
     */
    public const ENCODE_FLAGS = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE;

    /**
     * json_encode a JSON-LD schema for safe inline embedding in a <script> tag.
     *
     * @param  array<string,mixed>  $schema
     */
    public static function encode(array $schema): string
    {
        return (string) json_encode($schema, self::ENCODE_FLAGS);
    }

    public static function siteUrl(): string
    {
        return rtrim((string) config('services.site.origin'), '/');
    }

    /**
     * @param  array<int,array{question:string,answer:string}>  $faqs
     * @return array<string,mixed>
     */
    public static function faq(array $faqs): array
    {
        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(static fn ($f) => [
                '@type'          => 'Question',
                'name'           => $f['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $f['answer'],
                ],
            ], array_values($faqs)),
        ];
    }

    /**
     * @param  array<int,array{name:string,url:string}>  $items
     * @return array<string,mixed>
     */
    public static function breadcrumb(array $items): array
    {
        $out = [];
        foreach (array_values($items) as $i => $item) {
            $out[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => $item['url'],
            ];
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $out,
        ];
    }

    /**
     * @param  iterable<object>  $courses  each having ->title and ->slug
     * @return array<string,mixed>
     */
    public static function courseList(iterable $courses): array
    {
        $site = self::siteUrl();
        $out = [];
        $i = 0;
        foreach ($courses as $c) {
            if ($i >= 50) {
                break;
            }
            $out[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'url'      => $site . '/courses/' . $c->slug,
                'name'     => $c->title,
            ];
            $i++;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'itemListElement' => $out,
        ];
    }

    /**
     * @param  array<string,mixed>  $course
     * @return array<string,mixed>
     */
    public static function course(array $course): array
    {
        $site = self::siteUrl();
        $mode = $course['mode'] ?? '';
        $courseMode = $mode === 'Online Live' ? 'online' : ($mode === 'Self-Paced' ? 'onDemand' : 'blended');

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Course',
            'name'        => $course['title'],
            'description' => $course['description'] ?: $course['summary'],
            'url'         => $site . '/courses/' . $course['slug'],
            'image'       => $course['imageUrl'] ?: ($site . '/og-image.jpg'),
            'provider'    => [
                '@type'  => 'Organization',
                'name'   => 'Corporate Academy',
                'sameAs' => $site,
                '@id'    => $site . '/#organization',
            ],
            'offers' => [
                '@type'         => 'Offer',
                'availability'  => 'https://schema.org/InStock',
                'url'           => $site . '/courses/' . $course['slug'],
                'priceCurrency' => 'INR',
                'category'      => 'Professional Training',
            ],
            'hasCourseInstance' => [
                '@type'      => 'CourseInstance',
                'courseMode' => $courseMode,
                'duration'   => $course['durationHours'] . 'H',
                'inLanguage' => 'en-IN',
            ],
            'educationalLevel'   => $course['level'],
            'timeRequired'       => 'PT' . $course['durationHours'] . 'H',
            'inLanguage'         => 'en-IN',
            'isAccessibleForFree' => false,
        ];

        if (($course['reviewCount'] ?? 0) > 0) {
            $schema['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => $course['rating'],
                'reviewCount' => $course['reviewCount'],
                'bestRating'  => 5,
                'worstRating' => 1,
            ];
        }
        if (!empty($course['course_name'])) {
            $schema['about'] = ['@type' => 'Thing', 'name' => $course['course_name']];
        }
        if (!empty($course['skills'])) {
            $schema['teaches'] = implode(', ', $course['skills']);
        }

        return $schema;
    }
}
