@props([
    'title',
    'description',
    'keywords' => null,
    'ogType' => 'website',
    'ogImage' => '/api/og-image',
    'path' => '',
    'noIndex' => false,
])
@php
    $origin = rtrim((string) config('services.site.origin'), '/');
    $siteName = 'Corporate Academy';
    $fullTitle = $title === $siteName ? $title : $title . ' | ' . $siteName;
    $canonical = $origin . $path;
    $ogImageFull = str_starts_with($ogImage, 'http') ? $ogImage : $origin . $ogImage;
@endphp
<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="robots" content="{{ $noIndex ? 'noindex, nofollow' : 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1' }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImageFull }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $fullTitle }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="en_IN">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImageFull }}">
<meta name="twitter:image:alt" content="{{ $fullTitle }}">

{{ $slot }}
