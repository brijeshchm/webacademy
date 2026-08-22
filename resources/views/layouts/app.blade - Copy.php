@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/app.css">

    @stack('seo')
</head>
<body>
    <div class="flex flex-col min-h-screen bg-background text-foreground transition-colors duration-300">
    
{{-- ── TOP TICKER BAR ──────────────────────────────────── --}}
<div class="bg-primary text-white text-[11px] py-2 overflow-hidden font-medium">
    <div class="flex whitespace-nowrap animate-ticker">
        <span class="px-10">🚀 New Batch: SAP FICO | SAP HANA | SAP MM | SAP SD | SAP BTP | SuccessFactors</span>
        <span class="px-10 text-orange-300">📞 Call: +91 70426 93052</span>
        <span class="px-10">🎓 22,401+ Students Placed | 1,000+ Hiring Partners | 120+ SAP Modules</span>
        <span class="px-10 text-yellow-300">✅ 98.28% Placement Rate | 8+ Countries</span>
        <span class="px-10">🚀 New Batch: SAP FICO | SAP HANA | SAP MM | SAP SD | SAP BTP | SuccessFactors</span>
        <span class="px-10 text-orange-300">📞 Call: +91 70426 93052</span>
        <span class="px-10">🎓 22,401+ Students Placed | 1,000+ Hiring Partners | 120+ SAP Modules</span>
        <span class="px-10 text-yellow-300">✅ 98.28% Placement Rate | 8+ Countries</span>
    </div>
</div>

{{-- ── MAIN NAVBAR ─────────────────────────────────────── --}}
<header class="fixed top-7 left-0 right-0 z-50 bg-white border-b border-transparent shadow-sm transition-all duration-300" id="main-header">
    <div class="w-full px-6 md:px-12 h-20 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group flex-shrink-0">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-blue-700 flex items-center justify-center text-white font-black text-lg shadow-md shadow-primary/30 group-hover:shadow-primary/50 transition-all">S</div>
          
        </a>

        {{-- ── SEARCH BOX (center) ─────────────────────────── --}}
        <div class="hidden md:flex flex-1 max-w-md mx-4">
            <div class="relative w-full" id="search-wrapper">
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                        <input
                            type="text"
                            id="header-search"
                            placeholder="Search SAP courses…"
                            autocomplete="off"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border-0 bg-slate-100 focus:bg-white focus:outline-none focus:ring-2 focus:ring-accent text-slate-800 text-sm transition-all"
                        >
                        {{-- Search Results Dropdown --}}
                        <div id="search-results"></div>
                    </div>
                    <button id="search-btn"
                        class="rounded-xl px-5 py-3 font-bold text-sm text-white shadow-lg shrink-0 transition-all hover:scale-105 active:scale-95"
                        style="background:linear-gradient(135deg,#FF6B00,#FF9500);box-shadow:rgba(255,107,0,.4) 0 4px 18px;">
                        Search
                    </button>
                </div>
            </div>
        </div>

        {{-- Desktop Nav --}}
        <nav class="lg:flex items-center gap-1 flex-shrink-0">
            <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium transition-colors text-slate-600 hover:text-primary hover:bg-slate-50 {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('courses') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium transition-colors text-slate-600 hover:text-primary hover:bg-slate-50 {{ request()->is('courses*') ? 'active' : '' }}">Courses</a>
        
            
            <a href="{{ url('/ebooks') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium transition-colors text-slate-600 hover:text-primary hover:bg-slate-50 {{ request()->is('ebooks*') ? 'active' : '' }}">E-Books</a>
                <a href="{{ url('/interviews') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium transition-colors text-slate-600 hover:text-primary hover:bg-slate-50 {{ request()->is('interviews*') ? 'active' : '' }}">Interview Q&A</a>
                <a href="{{ url('/quizzes') }}" class="nav-link px-4 py-2 rounded-lg text-sm font-medium transition-colors text-slate-600 hover:text-primary hover:bg-slate-50 {{ request()->is('quizzes*') ? 'active' : '' }}">Quiz</a>
                          
        </nav>

        {{-- CTA Buttons --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- Free Demo --}}
            <button class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold border transition-all text-primary border-primary/30 hover:bg-primary hover:text-white hover:border-primary"
                    onclick="document.getElementById('demo-modal').classList.remove('hidden')">
                <i class="fa fa-video text-xs"></i> Free Demo
            </button>

            @auth
            <a href=""
               class="hidden sm:inline-flex items-center gap-1.5 bg-accent hover:bg-orange-600 text-white font-bold rounded-full px-5 py-2 text-sm transition-all hover:shadow-lg">
                Dashboard
            </a>
            @else
            <button onclick="document.getElementById('enquiry-modal').classList.remove('hidden')"
                    class="hidden sm:inline-flex items-center gap-1.5 bg-accent hover:bg-orange-600 text-white font-bold rounded-full px-5 py-2 text-sm shadow-md shadow-accent/30 transition-all hover:shadow-accent/50">
                Enquire Now
            </button>
            @endauth

            {{-- Mobile menu btn --}}
            <button id="menu-btn" class="lg:hidden w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors">
                <i class="fa fa-bars text-base"></i>
            </button>
        </div>
    </div>

    {{-- ── MOBILE MENU ──────────────────────────────────── --}}
    <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-100 bg-white">
        {{-- Mobile Search --}}
        <div class="px-4 pt-3 pb-2">
            <div class="relative" id="mobile-search-wrapper">
                <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text" id="mobile-search" placeholder="Search SAP courses…" autocomplete="off"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-primary text-sm">
                <div id="mobile-search-results"></div>
            </div>
        </div>
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="block text-sm font-medium text-gray-700 hover:text-primary py-2 px-2 rounded-lg hover:bg-slate-50">Home</a>
            <a href="{{ route('courses') }}" class="block text-sm font-medium text-gray-700 hover:text-primary py-2 px-2 rounded-lg hover:bg-slate-50">Courses</a>
            <a href="{{ route('aboutUs') }}" class="block text-sm font-medium text-gray-700 hover:text-primary py-2 px-2 rounded-lg hover:bg-slate-50">About</a>
            <a href="{{ route('contactUs') }}" class="block text-sm font-medium text-gray-700 hover:text-primary py-2 px-2 rounded-lg hover:bg-slate-50">Contact</a>
            <div class="pt-2 flex gap-3">
                <button onclick="document.getElementById('enquiry-modal').classList.remove('hidden')"
                        class="flex-1 text-center bg-accent text-white text-sm font-bold py-2.5 rounded-full">
                    Enquire Now
                </button>
                <a href="tel:+917042693052" class="flex-1 text-center border border-primary text-primary text-sm font-bold py-2.5 rounded-full">
                    Call Us
                </a>
            </div>
        </div>
    </div>
</header>

{{-- Spacer for fixed header --}}
<div class="h-[108px]"></div>
    
    
    
    @include('partials.navbar')

        <main class="flex-1 mt-[72px]">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        @include('partials.footer')
        @include('partials.floating-widgets')
       <!-- @include('partials.lead-popup')-->
    </div>

    <script src="/assets/app.js" defer></script>
</body>
</html>
