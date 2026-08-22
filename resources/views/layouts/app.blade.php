<!DOCTYPE html>
<html lang="En" dir="En">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title> 
<meta name="description" content="@yield('description')">     
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if (request()->is('/'))
<link rel="canonical" href="https://www.corporatesacademy.com/" />
@elseif (View::hasSection('canonical'))
@yield('canonical')
@else
<link rel="canonical" href="{{ url()->current() }}" />
@endif
@if(View::hasSection('meta_robots'))
@yield('meta_robots')
@else
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
@endif
<meta property="og:title" content="@yield('title')">
<meta property="og:description" content="@yield('description')">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="@yield('og_image', asset('images/logo-academy.webp'))">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="@yield('title')">
<meta property="og:site_name" content="Corporate Academy">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title')">
<meta name="twitter:description" content="@yield('description')">
<meta name="twitter:image" content="@yield('og_image', asset('images/logo-academy.webp'))">
<meta name="twitter:image:alt" content="@yield('title')">
<meta name="google-site-verification" content="cdZRjAwe6T9AoQoE-gqxeeMPgs_8FuKWR3GXR2JJI2c" />
<link rel="icon" href="/favicon.ico">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/app.css">  
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PVZ24G2F');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RX53MZVN0M"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-RX53MZVN0M');
</script>
@stack('schema') 
</head>
<body> 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PVZ24G2F"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<div class="flex flex-col min-h-screen bg-background text-foreground transition-colors duration-300">
@include('partials.navbar')
<main class="flex-1 mt-[72px]">
@yield('content')
{{ $slot ?? '' }}
</main>
@include('partials.footer')
@include('partials.floating-widgets')
<!-- @include('partials.lead-popup') -->
</div>
<script src="/assets/app.js" defer></script>
</body>
</html>
