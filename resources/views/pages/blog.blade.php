@extends('layouts.app')
@section('title', 'Blog |  Business, Education & Local Service Insights')
@section('description', 'Explore the blog for the latest updates, business tips, education guides, career advice, local service insights, digital marketing trends, technology news, and helpful articles to grow your business and stay informed.')
@section('keywords', 'blog, business blog India, local business tips, education articles, career guidance, digital marketing tips, technology news, startup tips, local services blog, IT training guides, business growth strategies, online business directory blog, articles')
@section('content') 
@include('client.components.banner-section')
<style>

#scroll-progress {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--accent);
    transform-origin: left;
    transform: scaleX(0);
    z-index: 9999;
    transition: transform 0.1s linear;
    border-radius: 0 2px 2px 0;
}

/* ══════════════════════════════════════════
   TICKER
══════════════════════════════════════════ */
@keyframes ticker-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.ticker-track {
    display: inline-block;
    white-space: nowrap;
    animation: ticker-scroll 28s linear infinite;
    will-change: transform;
}
@media (prefers-reduced-motion: reduce) {
    .ticker-track { animation: none; }
}

/* ══════════════════════════════════════════
   CARD REVEAL (replaces Framer Motion)
══════════════════════════════════════════ */
.reveal-item {
    opacity: 0;
    transform: translateY(24px) scale(0.97);
    transition: opacity 0.5s cubic-bezier(0.22,1,0.36,1),
                transform 0.5s cubic-bezier(0.22,1,0.36,1);
}
.reveal-item.visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}
.reveal-item:nth-child(1) { transition-delay: 0.00s; }
.reveal-item:nth-child(2) { transition-delay: 0.10s; }
.reveal-item:nth-child(3) { transition-delay: 0.20s; }
.reveal-item:nth-child(4) { transition-delay: 0.30s; }
.reveal-item:nth-child(5) { transition-delay: 0.40s; }
.reveal-item:nth-child(n+6) { transition-delay: 0.48s; }

/* Sidebar reveal */
.sidebar-reveal {
    opacity: 0;
    transform: translateX(-20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.sidebar-reveal.visible {
    opacity: 1;
    transform: translateX(0);
}

/* ══════════════════════════════════════════
   IMAGE ZOOM EFFECT
══════════════════════════════════════════ */
.image-zoom {
    transition: transform 0.6s cubic-bezier(0.22,1,0.36,1);
    background-size: cover;
    background-position: center;
}
.group:hover .image-zoom {
    transform: scale(1.04);
}

/* ══════════════════════════════════════════
   CARD GLOW BORDER
══════════════════════════════════════════ */
.card-glow {
    transition: box-shadow 0.35s ease, transform 0.25s ease;
}
.card-glow:hover {
    box-shadow: 0 8px 40px rgba(37,99,235,0.12),
                0 0 0 1px rgba(37,99,235,0.08);
    transform: translateY(-3px);
}

/* ══════════════════════════════════════════
   FEATURED HERO
══════════════════════════════════════════ */
.hero-card {
    transition: box-shadow 0.5s ease, transform 0.3s ease;
}
.hero-card:hover {
    box-shadow: 0 20px 60px rgba(37,99,235,0.15);
    transform: scale(1.006);
}

/* ══════════════════════════════════════════
   SHIMMER HEADING
══════════════════════════════════════════ */
.shimmer-heading {
    background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 50%, var(--primary) 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer-h 3s linear infinite;
}
@keyframes shimmer-h {
    to { background-position: 200% center; }
}

/* ══════════════════════════════════════════
   SKELETON PULSE
══════════════════════════════════════════ */
.skeleton {
    background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
    background-size: 200% 100%;
    animation: pulse-sk 1.5s ease-in-out infinite;
    border-radius: 6px;
}
@keyframes pulse-sk {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ══════════════════════════════════════════
   LOADING DOTS (replaces AnimatePresence spinner)
══════════════════════════════════════════ */
.dot-bounce {
    display: inline-block;
    width: 10px; height: 10px;
    border-radius: 50%;
    background: var(--accent);
    animation: dot-b 0.7s ease-in-out infinite both;
}
.dot-bounce:nth-child(2) { animation-delay: 0.15s; }
.dot-bounce:nth-child(3) { animation-delay: 0.30s; }
@keyframes dot-b {
    0%,100% { transform: translateY(0);   opacity: 0.4; }
    50%      { transform: translateY(-10px); opacity: 1; }
}

/* ══════════════════════════════════════════
   TAG HOVER SPRING
══════════════════════════════════════════ */
.tag-chip {
    display: inline-block;
    transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1),
                background 0.2s ease, color 0.2s ease;
}
.tag-chip:hover {
    transform: scale(1.1) translateY(-2px);
    background: var(--accent) !important;
    color: white !important;
    border-color: var(--accent) !important;
}

/* ══════════════════════════════════════════
   SCROLLBAR THIN (sidebar)
══════════════════════════════════════════ */
.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

/* ══════════════════════════════════════════
   POPULAR POSTS HOVER SLIDE
══════════════════════════════════════════ */
.popular-item {
    transition: transform 0.25s ease;
}
.popular-item:hover { transform: translateX(4px); }
</style>

 

{{-- ═══════════════════════════════
     SCROLL PROGRESS BAR
════════════════════════════════ --}}
<div id="scroll-progress"></div>

{{-- ═══════════════════════════════
     LIVE TICKER
════════════════════════════════ --}}
@if(count($tickerArticles))
<div class="bg-blue-900 text-white overflow-hidden py-2 flex items-center gap-3 text-xs font-medium">
    <div class="shrink-0 flex items-center gap-1.5 bg-blue-500 text-white px-3 py-1 rounded-sm font-bold uppercase tracking-widest ml-4">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
        </svg>
        Live
    </div>
    <div class="overflow-hidden flex-1">
        <div class="ticker-track">
            {{-- Duplicated for seamless loop --}}
            @foreach([$tickerArticles, $tickerArticles] as $group)
                @foreach($group as $item)
                <span class="inline-flex items-center mr-12">
                    <span class="text-blue-400 mr-2">•</span>
                    <a href="{{ route('blog.details', $item['url']) }}"
                       class="hover:text-blue-300 transition-colors">
                        {{ $item['title'] ?? '' }}
                    </a>
                </span>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════
     MAIN LAYOUT
════════════════════════════════ --}}
<main class="container mx-auto px-4 lg:px-8 py-8 lg:py-12">
  <div class="mx-auto max-w-3xl px-4 py-6 text-center ">
    <h1 id="rotating-heading"
        class="sm:text-2xl transition-opacity duration-500 text-slate-900">
       What Would You Like to Learn Today?
    </h1>
</div>


    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- ══════════════════════════════════════
             MAIN CONTENT — 8 cols, order 2
        ══════════════════════════════════════ --}}
        <div class="lg:col-span-8 lg:order-2 space-y-12">

            {{-- ── FEATURED HERO ── --}}
            @if($firstBlog)
            <article class="group hero-card rounded-xl overflow-hidden bg-white shadow-sm border border-gray-200 cursor-pointer">
                <a href="{{ route('blog.details', $firstBlog['url']) }}" class="block">

                    {{-- Thumbnail / gradient fallback --}}
                    <div class="aspect-[2/1] w-full overflow-hidden relative">
                        @if(!empty($firstBlog['img']))
                            <div class="image-zoom w-full h-full"
                                 style="background-image: url('{{ $firstBlog['img'] }}');
                                        background-size: cover; background-position: center;">
                            </div>
                        @else
                            <div class="image-zoom w-f  ull h-full flex items-center justify-center"
                                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #0891b2 100%);">
                                <span class="text-white/20 text-[8rem] font-black select-none leading-none">
                                   {{ strtoupper(substr($firstBlog['name'] ?? 'Q', 0, 1)) }}
                                </span>
                            </div>
                        @endif

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-80"></div>

                        {{-- Badge on image --}}
                        <div class="absolute bottom-6 left-6">
                            <span class="inline-flex items-center bg-blue-500 text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow">
                                Featured &bull; {{ $firstBlog['name'] ?? '' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 md:p-8 bg-white">
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900 mb-4 leading-tight
                                   group-hover:text-blue-600 transition-colors duration-300">
                            {{ $firstBlog['title'] ?? '' }}
                        </h2>
                        @if(!empty($firstBlog['excerpt']))
                        <p class="text-slate-500 text-lg mb-6 line-clamp-3">
                            {{ strip_tags($firstBlog['excerpt']) }}
                        </p>
                        @endif
                        <div class="flex items-center text-sm text-slate-400 font-medium space-x-6">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $firstBlog['created_at'] ?? '' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $firstBlog['updated_at'] ?? '' }}
                            </span>
                        </div>
                    </div>

                </a>
            </article>
            @endif

            {{-- ── LATEST ARTICLES ── --}}
            <div>
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <span class="w-8 h-1 bg-blue-500 mr-3 inline-block rounded-full"></span>
                    <span class="shimmer-heading">Latest Articles</span>
                </h3>

                {{-- Article list — rendered server-side, JS handles infinite scroll --}}
                <div id="articles-container" class="space-y-6">
                    @foreach($listArticles as $index => $article)
                    @php
                        $gradients = [
                            'linear-gradient(135deg,#1e3a5f 0%,#2563eb 50%,#0891b2 100%)',
                            'linear-gradient(135deg,#14532d 0%,#16a34a 50%,#0d9488 100%)',
                            'linear-gradient(135deg,#4c1d95 0%,#7c3aed 50%,#db2777 100%)',
                            'linear-gradient(135deg,#7c2d12 0%,#ea580c 50%,#d97706 100%)',
                            'linear-gradient(135deg,#1e3a5f 0%,#0f172a 50%,#2563eb 100%)',
                            'linear-gradient(135deg,#064e3b 0%,#0f766e 50%,#0284c7 100%)',
                            'linear-gradient(135deg,#581c87 0%,#a21caf 50%,#db2777 100%)',
                            'linear-gradient(135deg,#1e3a5f 0%,#1d4ed8 50%,#7c3aed 100%)',
                        ];
                        $grad = $gradients[$index % count($gradients)];
                        // Hide articles beyond first 10 — JS will reveal via infinite scroll
                        $hidden = $index >= 10;
                    @endphp
                    <article data-article-index="{{ $index }}"
                             class="article-item reveal-item group flex flex-col sm:flex-row gap-6
                                    bg-white border border-gray-200 p-4 rounded-xl cursor-pointer
                                    card-glow {{ $hidden ? 'hidden' : '' }}">
                        <a href="{{ route('blog.details', $article['url']) }}" class="contents">
                            {{-- Thumbnail --}}
                            <div class="w-full sm:w-[38%] aspect-[3/2] overflow-hidden rounded-lg shrink-0">
                                @if(!empty($article['img']))
                                    <div class="image-zoom w-full h-full"
                                         style="background-image: url('{{ $article['img'] }}');
                                                background-size: cover; background-position: center;">
                                    </div>
                                @else
                                    <div class="image-zoom w-full h-full flex items-center justify-center"
                                         style="background: {{ $grad }};">
                                        <span class="text-white/20 text-6xl font-black select-none">
                                            {{ strtoupper(substr($article['name'] ?? 'Q', 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="flex flex-col justify-center flex-grow py-1 sm:py-2">
                                <div class="mb-3">
                                    <span class="inline-flex items-center text-xs font-semibold text-blue-600
                                                 border border-blue-200 bg-blue-50 px-2.5 py-0.5 rounded-full
                                                 group-hover:bg-blue-600 group-hover:text-white
                                                 transition-colors duration-300">
                                        {{ $article['name'] ?? '' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2
                                           group-hover:text-blue-600 transition-colors duration-300
                                           line-clamp-2 leading-snug">
                                    {{ $article['title'] ?? '' }}
                                </h3>
                                @if(!empty($article['excerpt']))
                                <p class="text-slate-500 text-sm mb-4 line-clamp-2">
                                    {{ strip_tags($article['excerpt']) }}
                                </p>
                                @endif
                                <div class="flex items-center text-xs text-slate-400 font-medium space-x-4 mt-auto">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        {{ $article['created_at'] ?? '' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $article['updated_at'] ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                {{-- Infinite scroll sentinel --}}
                <div id="scroll-sentinel" class="pt-8 flex flex-col items-center gap-3">
                    <div id="loading-dots" class="hidden flex items-center gap-2 py-4">
                        <span class="dot-bounce"></span>
                        <span class="dot-bounce"></span>
                        <span class="dot-bounce"></span>
                    </div>
                    <p id="end-message"
                       class="hidden text-xs text-slate-400 py-4 font-medium tracking-widest uppercase">
                        — You've reached the end —
                    </p>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════
             SIDEBAR — 4 cols, order 1
        ══════════════════════════════════════ --}}
        <aside class="lg:col-span-4 lg:order-1">
            <div class="sticky top-6 space-y-8 max-h-[calc(100vh-3rem)] overflow-y-auto
                        pr-1 scrollbar-thin">

                {{-- ── CATEGORIES ── --}}
                <div class="sidebar-reveal bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="text-lg font-bold text-slate-900 mb-4 border-b border-gray-100 pb-3">
                        Topics
                    </h4>
                    <ul class="space-y-1">

                   
                        @if($categories)
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('category.blog', ['url' => Str::slug($cat->name)]) }}"
                               class="group flex items-center justify-between py-2 text-sm
                                      text-slate-500 hover:text-blue-600 transition-colors">
                                <span class="flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-300 mr-2.5
                                                 group-hover:bg-blue-500 transition-colors"></span>
                                  {{ ucfirst(str_replace('-', ' ', $cat['name'])) }}


                                </span>
                                <span class="bg-slate-100 text-slate-500 rounded-md px-2 py-0.5
                                             text-xs font-medium">
                                    {{ $cat['count'] }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                {{-- ── POPULAR POSTS ── --}}
                @if(count($popularArticles))
                <div class="sidebar-reveal bg-white p-6 rounded-xl border border-gray-200 shadow-sm"
                     style="transition-delay: 0.12s;">
                    <h4 class="text-lg font-bold text-slate-900 mb-4 border-b border-gray-100 pb-3">
                        Popular Reads
                    </h4>
                    <div class="space-y-5 mt-2">
                        @foreach($popularArticles as $i => $article)
                        @php
                            $popGrads = [
                                'linear-gradient(135deg,#1e3a5f,#2563eb)',
                                'linear-gradient(135deg,#14532d,#16a34a)',
                                'linear-gradient(135deg,#4c1d95,#7c3aed)',
                            ];
                            $pg = $popGrads[$i % count($popGrads)];
                        @endphp
                        <div class="popular-item">
                            <a href="{{ route('blog.details', $article['url']) }}"
                               class="group flex gap-4 items-center cursor-pointer">
                                {{-- Thumb --}}
                                <div class="w-20 h-20 rounded-md overflow-hidden shrink-0">
                                    @if(!empty($article['img']))
                                        <div class="w-full h-full image-zoom"
                                             style="background-image: url('{{ $article['img'] }}');
                                                    background-size: cover; background-position: center;">
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"
                                             style="background: {{ $pg }};">
                                            <span class="text-white/25 text-3xl font-black select-none">
                                                {{ strtoupper(substr($article['name'] ?? 'Q', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-slate-900 mb-1 line-clamp-2
                                               group-hover:text-blue-600 transition-colors leading-tight">
                                        {{ $article['title'] ?? '' }}
                                    </h5>
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $article['created_at'] ?? '' }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── TAGS ── --}}
                <div class="sidebar-reveal bg-white p-6 rounded-xl border border-gray-200 shadow-sm"
                     style="transition-delay: 0.24s;">
                    <h4 class="text-lg font-bold text-slate-900 mb-4 border-b border-gray-100 pb-3
                               flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Tags
                    </h4>
                    <div class="flex flex-wrap gap-2">
                         @if($tags)
                        @foreach($tags as $tag)
                        <a href="{{ route('blog.show') }}"
                           class=" px-3 py-1.5 bg-slate-100 text-slate-500 text-xs font-medium                                  rounded-md border border-slate-200 cursor-pointer hover:text-blue-600 transition-colors">
                            {{ $tag }}
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </aside>

    </div>
</main>

 
 
<script>
(function () {
    /* ── Scroll Progress Bar ── */
    const bar = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const total    = document.documentElement.scrollHeight - window.innerHeight;
        const pct      = total > 0 ? scrolled / total : 0;
        bar.style.transform = `scaleX(${pct})`;
    }, { passive: true });

    /* ── Reveal on scroll (IntersectionObserver) ── */
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObserver.unobserve(e.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal-item:not(.hidden)')
            .forEach(el => revealObserver.observe(el));

    /* ── Sidebar reveal ── */
    document.querySelectorAll('.sidebar-reveal').forEach((el, i) => {
        el.style.transitionDelay = (i * 0.12) + 's';
        revealObserver.observe(el);
    });

    /* ── Infinite Scroll ── */
    const PAGE        = 10;
    const allArticles = document.querySelectorAll('.article-item');
    let   visible     = PAGE;   // already showing first 10
    let   loading     = false;

    const sentinel    = document.getElementById('scroll-sentinel');
    const dots        = document.getElementById('loading-dots');
    const endMsg      = document.getElementById('end-message');

    // Show end message immediately if <= PAGE articles
    if (allArticles.length <= PAGE) {
        endMsg.classList.remove('hidden');
    }

    function showMore() {
        if (loading || visible >= allArticles.length) return;
        loading = true;
        dots.classList.remove('hidden');

        setTimeout(() => {
            const next = Math.min(visible + PAGE, allArticles.length);
            for (let i = visible; i < next; i++) {
                const el = allArticles[i];
                el.classList.remove('hidden');
                // Small stagger per newly-shown card
                setTimeout(() => {
                    revealObserver.observe(el);
                }, (i - visible) * 60);
            }
            visible  = next;
            loading  = false;
            dots.classList.add('hidden');

            if (visible >= allArticles.length) {
                endMsg.classList.remove('hidden');
            }
        }, 800);
    }

    const sentinelObserver = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) showMore();
    }, { rootMargin: '200px' });

    sentinelObserver.observe(sentinel);
})();
</script>

 @endsection
