@extends('layouts.app')
@section('title', 'Professional Technology Training & Certification | Corporate Academy')
@section('description', 'Corporate Academy delivers expert-led tech training in Cloud, Data Science, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow and more. 490+ courses, 63,000+ professionals trained, globally recognized certifications')
@php

    $origin = rtrim(config('services.site.origin'), '/');
    $title = 'Scholarships — Up to 50% Off';
    $desc = 'Apply for Corporate Academy scholarships and save up to 50% on your course. Merit, need-based, women in tech, early enrolment and more. 4,200+ scholars supported. Decisions in 48 hours.';
    $canonical = $origin . '/scholarship';
    $ogImage = $origin . '/api/og-image';

    $faqKeys = ['1', '2', '3', '4', '5', '6', '7', '8'];
    $faqs = array_map(fn ($k) => ['q' => t("scholarshipPage.faqs.$k.q"), 'a' => t("scholarshipPage.faqs.$k.a")], $faqKeys);

    $organizationJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'EducationalOrganization'],
        '@id' => $origin . '/#organization',
        'name' => 'Corporate Academy',
        'url' => $origin,
        'logo' => ['@type' => 'ImageObject', 'url' => $origin . '/favicon.svg', 'width' => 200, 'height' => 200],
        'image' => $origin . '/api/og-image',
        'description' => 'Corporate Academy is a professional technology training and certification institute offering 490+ courses across IT, business, and management. 63,000+ professionals trained with globally recognized certifications.',
        'foundingDate' => '2018',
        'areaServed' => ['@type' => 'Country', 'name' => 'India'],
        'contactPoint' => [[
            '@type' => 'ContactPoint',
            'telephone' => '+91-88001-82225',
            'contactType' => 'customer service',
            'availableLanguage' => ['English', 'Hindi'],
        ]],
        'sameAs' => [],
        'offers' => ['@type' => 'AggregateOffer', 'offerCount' => '490', 'priceCurrency' => 'INR'],
    ];
    $faqJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];

    // Icon path helper (lucide) — returns inner SVG markup.
    $icon = function (string $name, string $cls) {
        $paths = [
            'sparkles' => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"></path>',
            'arrow-right' => '<line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline>',
            'trophy' => '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>',
            'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
            'percent' => '<line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle>',
            'award' => '<circle cx="12" cy="8" r="6"></circle><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>',
            'clock' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
            'check-circle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
            'heart' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>',
            'zap' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
            'book' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>',
            'medal' => '<path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15"></path><path d="M11 12 5.12 2.2"></path><path d="m13 12 5.88-9.8"></path><path d="M8 7h8"></path><circle cx="12" cy="17" r="5"></circle><path d="M12 18v-2h-.5"></path>',
            'trending-up' => '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline>',
            'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>',
            'lightbulb' => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5C17.7 10.2 18 9 18 7.5a6 6 0 0 0-12 0c0 1.5.5 2.7 1.5 4C8.3 12.3 8.8 13 9 14"></path><path d="M9 18h6"></path><path d="M10 22h4"></path>',
            'target' => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle>',
            'graduation-cap' => '<path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path>',
            'file-text' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line>',
            'bar-chart' => '<line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line>',
            'mail' => '<rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 5L2 7"></path>',
            'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
            'quote' => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"></path>',
            'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
            'badge-check' => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m9 12 2 2 4-4"></path>',
            'thumbs-up' => '<path d="M7 10v12"></path><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"></path>',
        ];
        $inner = $paths[$name] ?? '';
        $fillStar = in_array($name, ['star'], true);
        return '<svg class="' . $cls . '" viewBox="0 0 24 24" fill="' . ($fillStar ? 'currentColor' : 'none') . '" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $inner . '</svg>';
    };

    $scholarships = [
        ['icon' => 'trophy', 'color' => 'from-amber-400 to-orange-500', 'bg' => 'bg-amber-50', 'border' => 'border-amber-100', 'badgeColor' => 'bg-amber-400 text-[#060e24]', 'k' => 'merit', 'courses' => ['course1', 'course2', 'course3', 'course4'], 'elig' => ['elig1', 'elig2', 'elig3']],
        ['icon' => 'heart', 'color' => 'from-rose-500 to-pink-600', 'bg' => 'bg-rose-50', 'border' => 'border-rose-100', 'badgeColor' => 'bg-rose-100 text-rose-700', 'k' => 'aid', 'courses' => ['course1', 'course2', 'course3', 'course4'], 'elig' => ['elig1', 'elig2', 'elig3']],
        ['icon' => 'users', 'color' => 'from-violet-500 to-purple-600', 'bg' => 'bg-violet-50', 'border' => 'border-violet-100', 'badgeColor' => 'bg-violet-100 text-violet-700', 'k' => 'women', 'courses' => ['course1', 'course2', 'course3'], 'elig' => ['elig1', 'elig2', 'elig3']],
        ['icon' => 'zap', 'color' => 'from-emerald-500 to-teal-600', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-100', 'badgeColor' => 'bg-emerald-100 text-emerald-700', 'k' => 'early', 'courses' => ['course1', 'course2'], 'elig' => ['elig1', 'elig2', 'elig3']],
        ['icon' => 'book', 'color' => 'from-sky-500 to-blue-600', 'bg' => 'bg-sky-50', 'border' => 'border-sky-100', 'badgeColor' => 'bg-sky-100 text-sky-700', 'k' => 'referral', 'courses' => ['course1'], 'elig' => ['elig1', 'elig2', 'elig3']],
        ['icon' => 'medal', 'color' => 'from-indigo-500 to-blue-700', 'bg' => 'bg-indigo-50', 'border' => 'border-indigo-100', 'badgeColor' => 'bg-indigo-100 text-indigo-700', 'k' => 'doctoral', 'courses' => ['course1', 'course2'], 'elig' => ['elig1', 'elig2', 'elig3']],
    ];

    $stats = [
        ['value' => '₹2Cr+', 'labelKey' => 'scholarshipPage.stats.awarded', 'icon' => 'trophy'],
        ['value' => '4,200+', 'labelKey' => 'scholarshipPage.stats.supported', 'icon' => 'users'],
        ['value' => '50%', 'labelKey' => 'scholarshipPage.stats.maxDiscount', 'icon' => 'percent'],
        ['value' => '6', 'labelKey' => 'scholarshipPage.stats.types', 'icon' => 'award'],
        ['value' => '48h', 'labelKey' => 'scholarshipPage.stats.decisionTime', 'icon' => 'clock'],
    ];
    $impactNumbers = [
        ['value' => '63K+', 'labelKey' => 'scholarshipPage.impact.careers'],
        ['value' => '85%', 'labelKey' => 'scholarshipPage.impact.salary'],
        ['value' => '92%', 'labelKey' => 'scholarshipPage.impact.placement'],
        ['value' => '4.8★', 'labelKey' => 'scholarshipPage.impact.rating'],
    ];
    $benefits = [
        ['icon' => 'trending-up', 'k' => 'career'],
        ['icon' => 'shield', 'k' => 'placement'],
        ['icon' => 'lightbulb', 'k' => 'faculty'],
        ['icon' => 'target', 'k' => 'curriculum'],
        ['icon' => 'award', 'k' => 'recognised'],
        ['icon' => 'users', 'k' => 'alumni'],
    ];
    $steps = [
        ['n' => '01', 'icon' => 'file-text', 'k' => '1'],
        ['n' => '02', 'icon' => 'bar-chart', 'k' => '2'],
        ['n' => '03', 'icon' => 'mail', 'k' => '3'],
        ['n' => '04', 'icon' => 'graduation-cap', 'k' => '4'],
    ];
    $testimonials = [
        ['name' => 'Ananya Krishnan', 'role' => 'Data Analyst @ Infosys', 'location' => 'Bengaluru', 'avatar' => 'AK', 'color' => 'from-violet-500 to-purple-600', 'k' => '1'],
        ['name' => 'Rohan Mehta', 'role' => 'Workday Consultant @ Deloitte', 'location' => 'Mumbai', 'avatar' => 'RM', 'color' => 'from-emerald-500 to-teal-600', 'k' => '2'],
        ['name' => 'Priya Nair', 'role' => 'Salesforce Developer @ Accenture', 'location' => 'Pune', 'avatar' => 'PN', 'color' => 'from-rose-500 to-pink-600', 'k' => '3'],
        ['name' => 'Kiran Patel', 'role' => 'Cloud Architect @ TCS', 'location' => 'Ahmedabad', 'avatar' => 'KP', 'color' => 'from-sky-500 to-blue-600', 'k' => '4'],
        ['name' => 'Dr. Sunita Verma', 'role' => 'DBA Candidate, Ex-VP Ops', 'location' => 'Delhi NCR', 'avatar' => 'SV', 'color' => 'from-indigo-500 to-blue-700', 'k' => '5'],
        ['name' => 'Arjun Sharma', 'role' => 'PMP-Certified PM @ Wipro', 'location' => 'Hyderabad', 'avatar' => 'AS', 'color' => 'from-amber-500 to-orange-600', 'k' => '6'],
    ];
    $educationLabelKeys = [
        'scholarshipPage.education.1', 'scholarshipPage.education.2', 'scholarshipPage.education.3',
        'scholarshipPage.education.4', 'scholarshipPage.education.5', 'scholarshipPage.education.6',
        'scholarshipPage.education.7', 'scholarshipPage.education.8', 'scholarshipPage.education.9',
        'scholarshipPage.education.10', 'scholarshipPage.education.11',
    ];
    $educationOptions = [
        '10th (Secondary)', '12th (Higher Secondary)', 'Diploma',
        "Bachelor's Degree (B.A / B.Sc / B.Com)", "Bachelor's Degree (B.Tech / B.E)",
        "Bachelor's Degree (BBA / BCA)", "Master's Degree (M.A / M.Sc / M.Com)",
        "Master's Degree (M.Tech / M.E)", 'MBA', 'PhD / Doctorate', 'Other',
    ];
    $eligible = array_map(fn ($i) => t("scholarshipPage.eligible.q$i"), range(1, 8));
    $trustBadges = [
        ['icon' => 'shield', 'text' => t('scholarshipPage.form.trustSecure')],
        ['icon' => 'clock', 'text' => t('scholarshipPage.form.trustResponse')],
        ['icon' => 'thumbs-up', 'text' => t('scholarshipPage.form.trustNoDocs')],
    ];
@endphp
@section('title','"Course Catalog Professional Technology Courses')
@push('seo')
    <title>{{ $title }} | Corporate Academy</title>
    <meta name="description" content="{{ $desc }}">
    <meta name="keywords" content="corporate academy scholarship, IT course scholarship India, technology training scholarship, merit scholarship, women in tech scholarship, education scholarship India">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $title }} | Corporate Academy">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $title }} | Corporate Academy">
    <meta property="og:site_name" content="Corporate Academy">
    <meta property="og:locale" content="en_IN">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }} | Corporate Academy">
    <meta name="twitter:description" content="{{ $desc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="twitter:image:alt" content="{{ $title }} | Corporate Academy">
    <script type="application/ld+json">{!! json_ld($organizationJsonLd) !!}</script>
    <script type="application/ld+json">{!! json_ld($faqJsonLd) !!}</script>
@endpush

@section('content')
<div class="min-h-screen bg-background overflow-hidden">
    {{-- HERO --}}
    <section class="relative bg-[#060e24] overflow-hidden pt-12 pb-14">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image:linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:40px 40px"></div>
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] rounded-full bg-primary/20 blur-[100px]"></div>
        <div class="absolute -bottom-32 right-0 w-[450px] h-[450px] rounded-full bg-violet-600/20 blur-[100px]"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <div>
                <span class="inline-flex items-center gap-2 bg-amber-400/10 border border-amber-400/25 text-amber-400 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-full mb-6">
                    {!! $icon('sparkles', 'h-3 w-3') !!} {{ t('scholarshipPage.hero.badge') }}
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-4">
                    {{ t('scholarshipPage.hero.title1') }}<br>
                    <span class="bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400 bg-clip-text text-transparent">{{ t('scholarshipPage.hero.title2') }}</span>
                </h1>
                <p class="text-base sm:text-lg text-white/55 max-w-xl mx-auto mb-2 leading-relaxed">
                    {!! str_replace(['<strong>', '</strong>'], ['<strong class="text-amber-400">', '</strong>'], t('scholarshipPage.hero.subtitle')) !!}
                </p>
                <p class="text-xs text-white/35 mb-7">{{ t('scholarshipPage.hero.stats') }}</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="#apply">
                        <button class="inline-flex items-center justify-center h-12 px-8 font-black bg-gradient-to-r from-amber-400 to-orange-500 text-[#060e24] shadow-xl shadow-amber-500/25 rounded-xl hover:opacity-90">
                            {{ t('scholarshipPage.hero.ctaApply') }} {!! $icon('arrow-right', 'ml-2 h-4 w-4') !!}
                        </button>
                    </a>
                    <a href="#scholarships">
                        <button class="inline-flex items-center justify-center h-12 px-8 font-semibold border border-white/20 text-white bg-white/5 hover:bg-white/10 rounded-xl">
                            {{ t('scholarshipPage.hero.ctaView') }}
                        </button>
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="mt-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5">
                @foreach ($stats as $s)
                    <div class="bg-white/5 border border-white/10 rounded-2xl px-2 py-4 backdrop-blur-sm">
                        {!! $icon($s['icon'], 'h-3.5 w-3.5 text-amber-400 mx-auto mb-1.5') !!}
                        <p class="text-xl sm:text-2xl font-black text-white">{{ $s['value'] }}</p>
                        <p class="text-[10px] text-white/40 font-medium leading-tight mt-0.5">{{ t($s['labelKey']) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- IMPACT STRIP --}}
    <section class="bg-primary py-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-wrap justify-center sm:justify-between gap-5">
            @foreach ($impactNumbers as $n)
                <div class="text-center">
                    <p class="text-xl font-black text-white">{{ $n['value'] }}</p>
                    <p class="text-[11px] text-white/60 font-medium">{{ t($n['labelKey']) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- WHY APPLY --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
        <div class="text-center mb-8">
            <p class="text-xs font-black uppercase tracking-widest text-primary mb-1">{{ t('scholarshipPage.why.eyebrow') }}</p>
            <h2 class="text-2xl sm:text-3xl font-black text-foreground mb-2">{{ t('scholarshipPage.why.title') }}</h2>
            <p class="text-sm text-muted-foreground max-w-lg mx-auto">{{ t('scholarshipPage.why.subtitle') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($benefits as $b)
                <div class="flex gap-3 p-4 rounded-xl bg-white border border-gray-100 hover:shadow-md hover:border-primary/20 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-primary/8 flex items-center justify-center shrink-0">
                        {!! $icon($b['icon'], 'h-4 w-4 text-primary') !!}
                    </div>
                    <div>
                        <h3 class="font-bold text-foreground text-sm mb-0.5">{{ t("scholarshipPage.benefits.{$b['k']}.title") }}</h3>
                        <p class="text-xs text-muted-foreground leading-relaxed">{{ t("scholarshipPage.benefits.{$b['k']}.desc") }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SCHOLARSHIP CARDS --}}
    <section id="scholarships" class="bg-gray-50/80 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <p class="text-xs font-black uppercase tracking-widest text-primary mb-1">{{ t('scholarshipPage.cardsSection.eyebrow') }}</p>
                <h2 class="text-2xl sm:text-3xl font-black text-foreground mb-2">{{ t('scholarshipPage.cardsSection.title') }}</h2>
                <p class="text-sm text-muted-foreground max-w-lg mx-auto">{{ t('scholarshipPage.cardsSection.subtitle') }}</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($scholarships as $s)
                    <div class="rounded-2xl border {{ $s['border'] }} {{ $s['bg'] }} p-5 flex flex-col gap-3 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center shadow-md">
                                {!! $icon($s['icon'], 'h-5 w-5 text-white') !!}
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full {{ $s['badgeColor'] }}">{{ t("scholarshipPage.cards.{$s['k']}.badge") }}</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-foreground leading-tight">{{ t("scholarshipPage.cards.{$s['k']}.title") }}</h3>
                            <p class="text-xl font-black bg-gradient-to-r {{ $s['color'] }} bg-clip-text text-transparent">{{ t("scholarshipPage.cards.{$s['k']}.discount") }}</p>
                        </div>
                        <p class="text-xs text-muted-foreground leading-relaxed">{{ t("scholarshipPage.cards.{$s['k']}.desc") }}</p>
                        <ul class="space-y-1">
                            @foreach ($s['elig'] as $ek)
                                <li class="flex items-start gap-1.5 text-xs text-foreground/70 font-medium">
                                    {!! $icon('check-circle', 'h-3 w-3 text-emerald-500 shrink-0 mt-0.5') !!}{{ t("scholarshipPage.cards.{$s['k']}.$ek") }}
                                </li>
                            @endforeach
                        </ul>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($s['courses'] as $ck)
                                <span class="text-[10px] font-medium bg-white border border-gray-200 px-1.5 py-0.5 rounded-full text-foreground/55">{{ t("scholarshipPage.cards.{$s['k']}.$ck") }}</span>
                            @endforeach
                        </div>
                        <a href="#apply" class="mt-auto">
                            <button class="w-full inline-flex items-center justify-center rounded-lg bg-gradient-to-r {{ $s['color'] }} text-white border-0 hover:opacity-90 text-xs font-bold h-8">
                                {{ t('scholarshipPage.cardsSection.apply') }} {!! $icon('arrow-right', 'ml-1 h-3 w-3') !!}
                            </button>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="bg-gradient-to-br from-[#060e24] to-[#0c1f5c] py-14">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <p class="text-xs font-black uppercase tracking-widest text-amber-400 mb-1">{{ t('scholarshipPage.stepsSection.eyebrow') }}</p>
                <h2 class="text-2xl sm:text-3xl font-black text-white">{{ t('scholarshipPage.stepsSection.title') }}</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($steps as $i => $step)
                    <div class="relative text-center">
                        @if ($i < count($steps) - 1)
                            <div class="hidden lg:block absolute top-6 left-[calc(50%+26px)] w-[calc(100%-52px)] h-px bg-white/10"></div>
                        @endif
                        <div class="w-12 h-12 rounded-xl bg-white/8 border border-white/15 flex items-center justify-center mx-auto mb-3 relative z-10">
                            {!! $icon($step['icon'], 'h-5 w-5 text-amber-400') !!}
                        </div>
                        <span class="text-[10px] font-black text-amber-400/60 uppercase tracking-widest">{{ $step['n'] }}</span>
                        <h3 class="text-sm font-bold text-white mt-0.5 mb-1.5">{{ t("scholarshipPage.steps.{$step['k']}.title") }}</h3>
                        <p class="text-xs text-white/45 leading-relaxed">{{ t("scholarshipPage.steps.{$step['k']}.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
        <div class="text-center mb-8">
            <p class="text-xs font-black uppercase tracking-widest text-primary mb-1">{{ t('scholarshipPage.testimonialsSection.eyebrow') }}</p>
            <h2 class="text-2xl sm:text-3xl font-black text-foreground mb-2">{{ t('scholarshipPage.testimonialsSection.title') }}</h2>
            <p class="text-sm text-muted-foreground max-w-lg mx-auto">{{ t('scholarshipPage.testimonialsSection.subtitle') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($testimonials as $ts)
                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col gap-3 hover:shadow-md transition-shadow">
                    {!! $icon('quote', 'h-5 w-5 text-primary/20') !!}
                    <p class="text-xs text-foreground/75 leading-relaxed flex-1 italic">"{{ t("scholarshipPage.testimonials.{$ts['k']}.text") }}"</p>
                    <div class="flex gap-0.5">
                        @for ($i = 0; $i < 5; $i++)
                            {!! $icon('star', 'h-3 w-3 text-amber-400 fill-amber-400') !!}
                        @endfor
                    </div>
                    <div class="border-t border-gray-50 pt-3 flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br {{ $ts['color'] }} flex items-center justify-center shrink-0">
                            <span class="text-[10px] font-black text-white">{{ $ts['avatar'] }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-black text-foreground leading-tight">{{ $ts['name'] }}</p>
                            <p class="text-[11px] text-muted-foreground truncate">{{ $ts['role'] }} · {{ $ts['location'] }}</p>
                            <p class="text-[10px] text-primary font-bold">{{ t("scholarshipPage.testimonials.{$ts['k']}.scholarship") }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- AM I ELIGIBLE --}}
    <section class="bg-gradient-to-r from-amber-50 to-orange-50 border-y border-amber-100 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div>
                <div class="flex justify-center mb-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-400 flex items-center justify-center shadow-lg shadow-amber-200">
                        {!! $icon('badge-check', 'h-6 w-6 text-white') !!}
                    </div>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-foreground mb-2 text-center">{{ t('scholarshipPage.eligible.title') }}</h2>
                <p class="text-sm text-muted-foreground max-w-xl mx-auto mb-6 text-center">
                    {!! t('scholarshipPage.eligible.subtitle') !!}
                </p>
                <div class="grid sm:grid-cols-2 gap-2.5">
                    @foreach ($eligible as $q)
                        <div class="flex items-start gap-2.5 bg-white rounded-xl border border-amber-100 px-4 py-3 shadow-sm">
                            {!! $icon('check-circle', 'h-4 w-4 text-amber-500 shrink-0 mt-0.5') !!}
                            <p class="text-sm text-foreground/80 font-medium leading-snug">{{ $q }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-6">
                    <a href="#apply">
                        <button class="inline-flex items-center justify-center h-11 px-8 font-black bg-gradient-to-r from-amber-400 to-orange-500 text-[#060e24] shadow-lg shadow-amber-200 rounded-xl hover:opacity-90">
                            {{ t('scholarshipPage.eligible.cta') }} {!! $icon('arrow-right', 'ml-2 h-4 w-4') !!}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="max-w-3xl mx-auto px-4 sm:px-6 py-12">
        <div class="text-center mb-7">
            <p class="text-xs font-black uppercase tracking-widest text-primary mb-1">{{ t('scholarshipPage.faqSection.eyebrow') }}</p>
            <h2 class="text-2xl sm:text-3xl font-black text-foreground">{{ t('scholarshipPage.faqSection.title') }}</h2>
        </div>
        <div class="space-y-2">
            @foreach ($faqs as $f)
                <details class="group border border-gray-100 bg-white rounded-xl overflow-hidden [&[open]]:border-primary/30 [&[open]]:bg-primary/[0.02]">
                    <summary class="w-full flex items-center justify-between px-5 py-4 text-left gap-3 cursor-pointer list-none">
                        <span class="text-sm font-bold text-foreground leading-snug">{{ $f['q'] }}</span>
                        <svg class="h-4 w-4 text-muted-foreground shrink-0 group-open:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        <svg class="h-4 w-4 text-primary shrink-0 hidden group-open:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </summary>
                    <div class="px-5 pb-4"><p class="text-sm text-muted-foreground leading-relaxed">{{ $f['a'] }}</p></div>
                </details>
            @endforeach
        </div>
        <p class="text-center text-sm text-muted-foreground mt-6">
            {{ t('scholarshipPage.faqSection.stillQuestions') }}
            <a href="{{ route('contactUs')}}" class="text-primary font-bold hover:underline">{{ t('scholarshipPage.faqSection.contactTeam') }}</a>
            {{ t('scholarshipPage.faqSection.orCall') }}
            <a href="tel:+918800182225" class="text-primary font-bold hover:underline">+91 88001 82225</a>
        </p>
    </section>

    {{-- APPLICATION FORM --}}
    <section id="apply" class="bg-gradient-to-br from-[#060e24] via-[#0a1535] to-[#060e24] py-14">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-7">
                <span class="inline-flex items-center gap-1.5 bg-amber-400/10 border border-amber-400/20 text-amber-400 text-xs font-black uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-4">
                    {!! $icon('sparkles', 'h-3 w-3') !!} {{ t('scholarshipPage.applySection.badge') }}
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ t('scholarshipPage.applySection.title') }}</h2>
                <p class="text-sm text-white/45 max-w-md mx-auto">{{ t('scholarshipPage.applySection.subtitle') }}</p>
            </div>

            @if (session('success'))
                <div data-testid="scholarship-success" class="bg-white/5 border border-white/15 rounded-2xl p-10 text-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mx-auto mb-4 shadow-xl shadow-emerald-500/20">
                        {!! $icon('badge-check', 'h-8 w-8 text-white') !!}
                    </div>
                    <h3 class="text-xl font-black text-white mb-2">{{ t('scholarshipPage.applySuccess.title') }}</h3>
                    <p class="text-sm text-white/50 max-w-xs mx-auto mb-5">{!! str_replace(['<strong>', '</strong>'], ['<strong class="text-white">', '</strong>'], t('scholarshipPage.applySuccess.body')) !!}</p>
                    <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 text-xs font-semibold px-4 py-2 rounded-full">
                        {!! $icon('mail', 'h-3.5 w-3.5') !!} {{ t('scholarshipPage.applySuccess.checkInbox') }}
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('leads.store') }}" class="bg-white rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    @csrf
                    <input type="hidden" name="form_type" value="scholarship">
                    {{-- Header bar --}}
                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 px-6 py-4 flex items-center gap-3">
                        {!! $icon('award', 'h-5 w-5 text-[#060e24]') !!}
                        <div>
                            <p class="font-black text-[#060e24] text-sm">{{ t('scholarshipPage.form.headerTitle') }}</p>
                            <p class="text-[#060e24]/55 text-xs">{{ t('scholarshipPage.form.headerSub') }}</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Step 1 — Personal --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center">1</div>
                                <p class="text-xs font-black uppercase tracking-widest text-primary">{{ t('scholarshipPage.form.personalInfo') }}</p>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.fullName') }} <span class="text-red-400">*</span></label>
                                    <input name="name" value="{{ old('name') }}" placeholder="{{ t('scholarshipPage.form.fullNamePlaceholder') }}" required
                                        class="w-full h-10 rounded-lg text-sm border border-input bg-background px-3 outline-none focus:ring-2 focus:ring-primary/30">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.email') }} <span class="text-red-400">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required
                                        class="w-full h-10 rounded-lg text-sm border border-input bg-background px-3 outline-none focus:ring-2 focus:ring-primary/30">
                                </div>
                                <div class="space-y-1 sm:col-span-2">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.phone') }} <span class="text-red-400">*</span></label>
                                    @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'w-full h-10 rounded-lg text-sm border border-input bg-background px-3 outline-none focus:ring-2 focus:ring-primary/30', 'selectClass' => 'rounded-lg'])
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- Step 2 — Academic --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center">2</div>
                                <p class="text-xs font-black uppercase tracking-widest text-primary">{{ t('scholarshipPage.form.academicBackground') }}</p>
                            </div>
                            <div class="space-y-3">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.qualification') }} <span class="text-red-400">*</span></label>
                                    <select name="lastEducation" required
                                        class="w-full h-10 rounded-lg border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                        <option value="">{{ t('scholarshipPage.form.qualificationSelect') }}</option>
                                        @foreach ($educationOptions as $oi => $o)
                                            <option value="{{ $o }}">{{ t($educationLabelKeys[$oi]) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label class="text-xs font-semibold text-foreground/60 flex items-center gap-1">{!! $icon('percent', 'h-3 w-3') !!} {{ t('scholarshipPage.form.percentage') }}</label>
                                        <div class="relative">
                                            <input type="number" min="0" max="100" step="0.01" name="percentage" value="{{ old('percentage') }}" placeholder="e.g. 78.5" class="w-full h-10 rounded-lg text-sm pr-7 border border-input bg-background px-3 outline-none focus:ring-2 focus:ring-primary/30">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground font-bold">%</span>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-xs font-semibold text-foreground/60 flex items-center gap-1">{!! $icon('graduation-cap', 'h-3 w-3') !!} {{ t('scholarshipPage.form.cgpa') }}</label>
                                        <div class="relative">
                                            <input type="number" min="0" max="10" step="0.01" name="cgpa" value="{{ old('cgpa') }}" placeholder="e.g. 8.4" class="w-full h-10 rounded-lg text-sm pr-12 border border-input bg-background px-3 outline-none focus:ring-2 focus:ring-primary/30">
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground font-bold">/ 10</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        {{-- Step 3 — Course & Statement --}}
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center">3</div>
                                <p class="text-xs font-black uppercase tracking-widest text-primary">{{ t('scholarshipPage.form.courseStatement') }}</p>
                            </div>
                            <div class="space-y-3">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.courseInterest') }}</label>
                                    <select name="courseInterest"
                                        class="w-full h-10 rounded-lg border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                        <option value="">{{ t('scholarshipPage.form.courseInterestSelect') }}</option>
                                        @foreach ($courses as $courseTitle)
                                            <option value="{{ $courseTitle }}">{{ $courseLabels[$courseTitle] ?? $courseTitle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-foreground/60">{{ t('scholarshipPage.form.whyDeserve') }}</label>
                                    <textarea rows="3" name="message" placeholder="{{ t('scholarshipPage.form.whyDeservePlaceholder') }}"
                                        class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full h-12 rounded-xl bg-gradient-to-r from-amber-400 to-orange-500 text-[#060e24] font-black text-sm hover:opacity-90 shadow-lg shadow-amber-100 disabled:opacity-60 transition-all hover:-translate-y-0.5 inline-flex items-center justify-center gap-2">
                            {{ t('scholarshipPage.form.submit') }} {!! $icon('sparkles', 'h-4 w-4') !!}
                        </button>

                        <div class="grid grid-cols-3 gap-2 pt-0.5">
                            @foreach ($trustBadges as $tb)
                                <div class="flex flex-col items-center gap-1">
                                    {!! $icon($tb['icon'], 'h-3.5 w-3.5 text-muted-foreground/40') !!}
                                    <p class="text-[10px] text-muted-foreground text-center">{{ $tb['text'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section class="bg-white border-t border-gray-100 py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-foreground mb-2">{{ t('scholarshipPage.finalCta.title') }}</h2>
                <p class="text-sm text-muted-foreground mb-5 max-w-md mx-auto">{{ t('scholarshipPage.finalCta.subtitle') }}</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="tel:+918800182225">
                        <button class="inline-flex items-center justify-center h-11 px-7 rounded-xl bg-[#060e24] text-white font-bold hover:bg-[#0c1f5c] text-sm">
                            {!! $icon('phone', 'mr-2 h-4 w-4') !!} {{ t('scholarshipPage.finalCta.call') }}
                        </button>
                    </a>
                    <a href="/enquiry">
                        <button class="inline-flex items-center justify-center h-11 px-7 rounded-xl font-bold border border-gray-200 hover:border-primary hover:text-primary text-sm">
                            {!! $icon('mail', 'mr-2 h-4 w-4') !!} {{ t('scholarshipPage.finalCta.sendMessage') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
