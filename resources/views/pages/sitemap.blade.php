<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc>https://www.corporatesacademy.com/</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod>
<changefreq>daily</changefreq>
<priority>1.00</priority>
</url>
<url>
<loc>{{ route('aboutUs') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>{{ route('contactUs') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>{{ route('corporate-training') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod>
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>{{ route('privacy.policy') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>{{ route('terms.conditions') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>{{ route('refund.cancellation.policy') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>{{ route('scholarship') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>{{ route('courses') }}</loc>
<lastmod>2026-10-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

   
@if($keywords)
 @foreach ($keywords as $keyword)         
    <url>
        <loc>{{ route('courses.show', $keyword->slug) }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.80</priority>
    </url>
@endforeach
@endif
</urlset>