@php
    $siteName = 'Corporate Academy';
    $origin = rtrim((string) config('services.site.origin'), '/');
    $fullTitle = ($seoTitle === $siteName) ? $seoTitle : ($seoTitle . ' | ' . $siteName);
    $canonical = $origin . ($seoPath ?? '');
    $ogImage = $origin . '/api/og-image';
    $schemas = $seoJsonLd ?? [];
@endphp
<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $seoDescription }}"> 
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $fullTitle }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="{{ $fullTitle }}">
@foreach($schemas as $schema)
<script type="application/ld+json">{!! json_ld($schema) !!}</script>
@endforeach
