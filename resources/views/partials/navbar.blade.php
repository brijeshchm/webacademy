@php
    $current = request()->path();
    $activeLng = app()->getLocale();
    $languages = [
        ['code' => 'en', 'name' => 'English'],
        ['code' => 'hi', 'name' => 'हिन्दी'],
        ['code' => 'zh', 'name' => '中文'],
        ['code' => 'fr', 'name' => 'Français'],
        ['code' => 'es', 'name' => 'Español'],
        ['code' => 'de', 'name' => 'Deutsch'],
        ['code' => 'ru', 'name' => 'Русский'],
        ['code' => 'ar', 'name' => 'العربية'],
    ];
    // Build a language-switch URL preserving other query params.
    $lngUrl = function (string $code) {
        $params = request()->query();
        $params['lng'] = $code;
        return url(request()->path()) . '?' . http_build_query($params);
    };
    $isActive = function (string $href) use ($current) {
        $path = '/' . ltrim($current, '/');
        return $path === $href || str_starts_with($path, $href . '/');
    };
    $navLinkBase = 'px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200';
    $navLinkOn = 'text-white bg-white/10';
    $navLinkOff = 'text-white/70 hover:text-white hover:bg-white/8';
@endphp

{{-- ── ANNOUNCEMENT BAR ─────────────────────────────── --}}
<!-- <div data-announcement class="fixed top-0 left-0 right-0 z-[60] bg-gradient-to-r from-primary via-[#2563eb] to-violet-600 text-white text-xs font-semibold overflow-hidden">
    <div class="flex items-center justify-center gap-2 sm:gap-3 px-3 sm:px-4 h-8">
        <svg class="h-3.5 w-3.5 text-yellow-300 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
        <span class="min-w-0 truncate whitespace-nowrap">
            {{ t('navX.announcement') }}
            <a href="{{ route('courses')}}" class="underline underline-offset-2 ml-1 hover:text-yellow-200 transition-colors">{{ t('navX.explorePrograms') }}</a>
            <span class="hidden sm:inline">&nbsp;·&nbsp;
            <a href="/enquiry" class="underline underline-offset-2 hover:text-yellow-200 transition-colors inline-block px-1 py-0.5">{{ t('navX.bookDemo') }}</a></span>
        </span>
        <button type="button" data-announcement-dismiss class="ml-2 sm:ml-4 shrink-0 w-8 h-8 -my-1 flex items-center justify-center text-white/60 hover:text-white transition-colors" aria-label="{{ t('navX.dismiss') }}">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
</div> -->

{{-- ── MAIN HEADER ──────────────────────────────────── --}}
<header data-navbar style="top:0px;height:72px" class="fixed left-0 right-0 z-50 transition-all duration-300 bg-[#060e24]/85 backdrop-blur-md border-b border-white/5">
    <div class="w-full px-4 md:px-6 xl:px-12">
        <div class="flex items-center h-[68px] gap-3 xl:gap-6">

            {{-- LOGO --}}
            <a href="/" class="flex items-center shrink-0 group" aria-label="Corporate Academy home">
                <img loading="eager" decoding="async" src="/images/logo-academy.webp" alt="Corporates Academy" width="802" height="205" class="h-10 w-auto max-w-[200px] object-contain transition-all duration-300 group-hover:scale-[1.04]">
            </a>

            {{-- DESKTOP NAV --}}
            <nav class="hidden xl:flex items-center gap-1 flex-1">

                {{-- Courses (dropdown) --}}
                <div class="relative" data-dropdown>
                    <button type="button" data-dropdown-toggle class="flex items-center gap-1 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isActive('/courses') || $isActive('/categories') ? $navLinkOn : $navLinkOff }}">
                        {{ t('nav.courses') }}
                        <svg class="h-3.5 w-3.5 transition-transform duration-200" data-dropdown-caret viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div data-dropdown-panel class="hidden absolute top-full left-0 mt-2 w-[520px] bg-white rounded-2xl shadow-2xl shadow-black/30 border border-gray-100 overflow-hidden z-50">
                        <div class="p-5">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">{{ t('navX.popularCategories') }}</p>
                            <div class="grid grid-cols-2 gap-1.5">
                                @foreach ([
                                    ['navX.catData',route('courses.show','data-science-training')],
                                    ['navX.catAI', route('courses.show','artificial-intelligence-training')],
                                    ['navX.catML', route('courses.show','machine-learning-training')],
                                    ['navX.catWorkday', route('courses.show','workday-training')],
                                    ['navX.catServiceNow', route('courses.show','servicenow-training')],
                                    ['navX.catSalesforce', route('courses.show','salesforce-training')],
                                    ['navX.catSixSigma', route('courses.show','six-sigma-training')],
                                ] as [$labelKey, $href])
                                    <a href="{{ $href }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                        <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">{{ t($labelKey) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="border-t border-gray-50 bg-gradient-to-r from-primary/5 to-violet-50 px-5 py-3 flex items-center justify-between">
                            <span class="text-xs text-gray-400 font-medium">{{ t('navX.programmesCount') }}</span>
                            <a href="{{ route('courses')}}" class="flex items-center gap-1 text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                                {{ t('navX.viewAll') }}
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Simple links --}}
                
                <a href="{{ route('aboutUs')}}" class="{{ $navLinkBase }} {{ $isActive('/about-us') ? $navLinkOn : $navLinkOff }}">{{ t('nav.about') }}</a>

                {{-- Corporate Training (dropdown) --}}
                <div class="relative" data-dropdown>
                    <button type="button" data-dropdown-toggle class="flex items-center gap-1 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isActive('/corporate-training') || $isActive('/doctorate') ? $navLinkOn : $navLinkOff }}">
                        {{ t('navX.corporate') }}
                        <svg class="h-3.5 w-3.5 transition-transform duration-200" data-dropdown-caret viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div data-dropdown-panel class="hidden absolute top-full left-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl shadow-black/30 border border-gray-100 overflow-hidden z-50">
                        <div class="p-3">
                            @foreach ([
                                ['navX.corpTeamTitle', 'navX.corpTeamDesc'],
                                ['navX.corpLeadershipTitle', 'navX.corpLeadershipDesc'],
                                ['navX.corpEnterpriseTitle', 'navX.corpEnterpriseDesc'],
                            ] as [$labelKey, $descKey])
                                <a href="/corporate-training" class="flex flex-col gap-0.5 p-3.5 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <span class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">{{ t($labelKey) }}</span>
                                    <span class="text-xs text-gray-400">{{ t($descKey) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            

                <a href="{{ route('scholarship')}}" class="{{ $navLinkBase }} {{ $isActive('/scholarship') ? $navLinkOn : 'text-amber-400/90 hover:text-amber-300 hover:bg-amber-400/10' }}">{{ t('navX.scholarship') }}</a>
                <a href="{{ route('contactUs')}}" class="{{ $navLinkBase }} {{ $isActive('/contact-us') ? $navLinkOn : $navLinkOff }}">{{ t('nav.contact') }}</a>

                <a href="/enquiry" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-bold text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10 transition-all duration-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    {{ t('navX.freeDemo') }}
                </a>
            </nav>

            {{-- RIGHT ACTIONS --}}
            <div class="hidden xl:flex items-center gap-2 shrink-0 ml-auto">
               

                <a href="/enquiry" class="hidden min-[1420px]:block px-3 py-2 text-sm font-semibold text-white/70 hover:text-white transition-colors rounded-xl hover:bg-white/8">{{ t('navX.enquire') }}</a>
                <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 px-3.5 py-2 text-sm font-bold rounded-xl bg-amber-500 hover:bg-amber-400 text-white shadow-lg shadow-amber-500/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">{{ t('navX.payNow') }}</a>
                <a href="/courses" class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl bg-primary hover:bg-primary/90 text-white shadow-xl shadow-primary/30 ring-2 ring-primary/30 ring-offset-1 ring-offset-[#060e24] transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">{{ t('nav.explorePrograms') }}</a>
            </div>

            {{-- MOBILE TOGGLE --}}
            <div class="flex xl:hidden items-center gap-2 ml-auto">
               
                <button type="button" data-mobile-toggle class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 text-white border border-white/15 hover:bg-white/15 transition-colors active:scale-90" aria-label="{{ t('navX.openMenu') }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>


        </div>
    </div>
</header>

{{-- ── MOBILE DRAWER ────────────────────────────────── --}}
<div data-mobile-backdrop class="hidden fixed inset-0 z-[45] bg-black/60 backdrop-blur-sm xl:hidden"></div>
<div data-mobile-drawer class="hidden fixed top-0 right-0 bottom-0 z-[48] w-[min(300px,85vw)] bg-[#060e24] border-l border-white/10 shadow-2xl xl:hidden flex-col overflow-y-auto">
    <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
        <img loading="lazy" decoding="async" src="/images/logo-academy.webp" alt="Corporate Academy" width="802" height="205" class="h-8 w-auto">
        <button type="button" data-mobile-close aria-label="{{ t('navX.closeMenu') }}" class="w-11 h-11 -mr-2 flex items-center justify-center rounded-lg text-white/50 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <div class="flex-1 py-4 px-3 space-y-1">
     @php
    $links = [
        ['courses', 'nav.courses'],
        ['aboutUs', 'nav.about'],
        ['corporate-training', 'navX.corporateTraining'],
        ['doctorate', 'navX.doctorateDba'],
        ['scholarship', 'navX.scholarship'],
        ['contactUs', 'nav.contact'],
    ];
@endphp

@foreach ($links as [$routeName, $labelKey])

    <a href="{{ route($routeName) }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-colors
       {{ request()->routeIs($routeName)
            ? 'bg-primary/20 text-white border border-primary/20'
            : 'text-white/60 hover:text-white hover:bg-white/8' }}">

        {{ t($labelKey) }}

    </a>

@endforeach
    </div>
    <div class="border-t border-white/10 p-4 space-y-2.5">
        <a href="/enquiry" class="flex w-full items-center gap-2 justify-start rounded-xl border border-white/20 text-white bg-white/5 hover:bg-white/10 px-4 py-2.5 text-sm font-semibold">{{ t('nav.enquire') }}</a>
        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="flex w-full items-center gap-2 justify-start rounded-xl bg-amber-500 hover:bg-amber-400 text-white font-bold shadow-lg shadow-amber-600/30 px-4 py-2.5 text-sm">{{ t('navX.payNow') }}</a>
        <a href="/courses" class="flex w-full items-center gap-2 justify-start rounded-xl bg-primary hover:bg-primary/90 text-white font-bold shadow-xl shadow-primary/30 ring-2 ring-primary/30 ring-offset-2 ring-offset-[#060e24] px-4 py-2.5 text-sm">{{ t('nav.explorePrograms') }}</a>
    </div>
    <div class="px-5 py-4 border-t border-white/5 text-xs text-white/30 font-medium">{{ t('navX.location') }}</div>
</div>
