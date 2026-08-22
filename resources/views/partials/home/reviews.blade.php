{{-- ReviewsSection — port of src/components/ReviewsSection.tsx.
     Tabs filter by platform; without JS the "all" set (first 6) renders. --}}
@php
    // Dynamic testimonial strings are pre-translated in HomeController and
    // passed as a single "original => translated" lookup map. No per-row
    // translation queries here — just array lookups.
    $tDyn = fn ($v) => $translations[$v] ?? $v;
@endphp
<section class="py-20 bg-gray-50 relative overflow-hidden">
    <div class="px-4 md:px-6 max-w-7xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-display font-bold mb-3">{{ t('reviews.title') }}</h2>
            <p class="text-muted-foreground max-w-xl mx-auto">{{ t('reviews.subtitle') }}</p>
        </div>

        <div class="flex justify-center mb-10">
            <div class="inline-flex items-center gap-1 bg-white rounded-full border border-gray-200 shadow-sm p-1" data-review-tabs>
                <button type="button" data-review-tab="all" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-primary text-white shadow-md shadow-primary/30">{{ t('reviews.allReviews') }}</button>
                <button type="button" data-review-tab="linkedin" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-primary hover:bg-gray-50">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-current" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    LinkedIn
                </button>
                <button type="button" data-review-tab="google" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-primary hover:bg-gray-50">
                    <svg viewBox="0 0 24 24" class="w-4 h-4" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Google
                </button>
                <button type="button" data-review-tab="instagram" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-primary hover:bg-gray-50">
                    <svg viewBox="0 0 24 24" class="w-4 h-4" aria-hidden="true"><defs><linearGradient id="ig-grad" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" stop-color="#f09433"/><stop offset="25%" stop-color="#e6683c"/><stop offset="50%" stop-color="#dc2743"/><stop offset="75%" stop-color="#cc2366"/><stop offset="100%" stop-color="#bc1888"/></linearGradient></defs><path fill="url(#ig-grad)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    Instagram
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" data-review-grid>
            @foreach ($testimonials->take(6) as $r)
                @php
                    $quote = $tDyn($r->quote);
                    $role = $tDyn($r->role);
                    $company = $tDyn($r->company);
                    $title = trim(preg_split('/[.!?]/', $quote)[0] ?? '');
                    $initials = strtoupper(implode('', array_map(fn ($n) => mb_substr($n, 0, 1), array_slice(preg_split('/\s+/', $r->name), 0, 2))));
                @endphp
                <div data-review-card data-review-source="{{ $r->source }}" class="bg-white rounded-2xl border border-gray-100 shadow-md shadow-gray-100/80 p-6 flex flex-col gap-4 hover:shadow-lg hover:shadow-gray-200/60 transition-shadow duration-300">
                    <svg class="w-6 h-6 text-gray-200 fill-gray-200 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/></svg>
                    <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-1">{{ $title }}</h3>
                    <div class="flex gap-0.5">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 {{ $i < $r->rating ? 'fill-yellow-400 text-yellow-400' : 'text-gray-200 fill-gray-200' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed flex-1">{{ $quote }}</p>
                    <hr class="border-gray-100">
                    <div class="flex items-center gap-3">
                        @if ($r->avatar_url)
                            <img loading="lazy" decoding="async" src="{{ $r->avatar_url }}" alt="{{ $r->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center shrink-0 text-sm">{{ $initials }}</div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $r->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $role }}{{ $company ? ' – ' . $company : '' }}</p>
                        </div>
                        @switch($r->source)
                            @case('linkedin')
                                <span class="w-8 h-8 rounded-full bg-[#0A66C2] flex items-center justify-center text-white shrink-0">
                                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-current" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </span>
                                @break
                            @case('google')
                                <span class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center shrink-0">
                                    <svg viewBox="0 0 24 24" class="w-4 h-4" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                </span>
                                @break
                            @case('instagram')
                                <span class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background: linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                                    <svg viewBox="0 0 24 24" class="w-4 h-4 fill-white" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 divide-y-2 md:divide-y-0 md:divide-x divide-gray-100">
                @foreach ($reviewAggregates as $agg)
                    <div class="flex items-center gap-3 pt-4 md:pt-0 first:pt-0 md:px-6 first:pl-0 last:pr-0">
                        <svg class="w-5 h-5 fill-yellow-400 text-yellow-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">
                                {{ $agg['rating'] }}/5
                                <span class="font-normal text-gray-400 ml-1.5">·</span>
                                <span class="font-normal text-gray-500 ml-1.5">{{ t('reviews.reviewsCount', ['count' => $agg['count']]) }}</span>
                            </p>
                            <p class="text-xs text-gray-500 font-semibold mt-0.5" style="color: {{ $agg['color'] }}">{{ $agg['name'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
