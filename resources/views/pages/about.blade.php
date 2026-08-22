@extends('layouts.app')
@section('title', ' About us |  Corporate Academy')
@section('description', 'Corporate Academy trains professionals at every stage — from individual contributors to enterprise teams. 63,000+ professionals trained, 92% placement rate, industry-expert faculty.')
@section('content')
@php

    $origin = rtrim(config('services.site.origin'), '/');
    $metaTitle = 'About Us';
    $metaDescription = 'Corporate Academy trains professionals at every stage — from individual contributors to enterprise teams. 63,000+ professionals trained, 92% placement rate, industry-expert faculty.';
    $canonical = $origin . '/about';
    $ogImage = $origin . '/api/og-image';

    $aboutFaqs = [
        ['q' => t('aboutX.faq1Q'), 'a' => t('aboutX.faq1A')],
        ['q' => t('aboutX.faq2Q'), 'a' => t('aboutX.faq2A')],
        ['q' => t('aboutX.faq3Q'), 'a' => t('aboutX.faq3A')],
        ['q' => t('aboutX.faq4Q'), 'a' => t('aboutX.faq4A')],
    ];

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
        ], $aboutFaqs),
    ];

    $statCards = [
        ['icon' => 'users', 'value' => number_format($stats['careersTransformed'] / 1000, 0) . 'k+', 'label' => t('about.careersTransformed')],
        ['icon' => 'trophy', 'value' => number_format($stats['expertTrainers']), 'label' => t('about.expertTrainers')],
        ['icon' => 'globe', 'value' => number_format($stats['countries']), 'label' => t('about.countriesReached')],
        ['icon' => 'book', 'value' => number_format($stats['totalCourses']), 'label' => t('about.activePrograms')],
    ];
@endphp

@push('schema')
    <script type="application/ld+json">{!! json_ld($organizationJsonLd) !!}</script>
    <script type="application/ld+json">{!! json_ld($faqJsonLd) !!}</script>
@endpush
<div class="min-h-screen bg-background pb-24 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-3xl pointer-events-none ca-float"></div>
    <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-secondary/5 rounded-full blur-3xl pointer-events-none ca-float-slow"></div>

    {{-- Hero --}}
    <section class="relative py-24 border-b border-white/40">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-4xl bg-white/40 backdrop-blur-md p-10 rounded-3xl border border-white/60 shadow-sm">
                <h1 class="text-4xl md:text-6xl font-display font-bold tracking-tight mb-8">
                    {{ t('about.heroTitle') }}
                </h1>
                <p class="text-xl md:text-2xl text-muted-foreground leading-relaxed">
                    {{ t('about.heroDesc') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-20 relative z-10">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($statCards as $stat)
                    <div class="text-center bg-white/50 backdrop-blur-md p-6 rounded-3xl border border-white/80 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="mx-auto w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-4 text-primary shadow-sm border border-white">
                            @switch($stat['icon'])
                                @case('users')
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    @break
                                @case('trophy')
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>
                                    @break
                                @case('globe')
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    @break
                                @default
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            @endswitch
                        </div>
                        <h3 class="text-4xl font-display font-bold mb-2">{{ $stat['value'] }}</h3>
                        <p class="text-sm text-muted-foreground font-bold uppercase tracking-wider">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-20 relative z-10">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-primary/10 to-secondary/10 rounded-[3rem] blur-xl opacity-50 ca-float-slow"></div>
                    <img loading="lazy" decoding="async"
                        src="/images/about-img.webp"
                        alt="Our training team"
                        class="rounded-[2.5rem] shadow-2xl border border-white/60 w-full h-auto aspect-[4/3] object-cover bg-white/50 relative z-10"
                        onerror="this.style.display='none'">
                </div>
                <div class="space-y-10 bg-white/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/80 shadow-xl shadow-primary/5">
                    <div>
                        <h2 class="text-3xl font-display font-bold mb-4">{{ t('about.ourPhilosophy') }}</h2>
                        <p class="text-muted-foreground leading-relaxed text-lg">
                            {{ t('about.ourPhilosophyDesc') }}
                        </p>
                    </div>

                    <div>
                        <h2 class="text-3xl font-display font-bold mb-6">{{ t('about.whyCorporateAcademy') }}</h2>
                        <ul class="space-y-6">
                            <li class="flex gap-4 items-start bg-white/50 p-4 rounded-2xl border border-white/60 transition-all hover:bg-white/80 hover:shadow-md">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-primary/20">1</div>
                                <div>
                                    <h4 class="font-bold mb-1 text-lg">{{ t('about.zeroFluff') }}</h4>
                                    <p class="text-muted-foreground">{{ t('about.zeroFluffDesc') }}</p>
                                </div>
                            </li>
                            <li class="flex gap-4 items-start bg-white/50 p-4 rounded-2xl border border-white/60 transition-all hover:bg-white/80 hover:shadow-md">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-primary/20">2</div>
                                <div>
                                    <h4 class="font-bold mb-1 text-lg">{{ t('about.industryRecognized') }}</h4>
                                    <p class="text-muted-foreground">{{ t('about.industryRecognizedDesc') }}</p>
                                </div>
                            </li>
                            <li class="flex gap-4 items-start bg-white/50 p-4 rounded-2xl border border-white/60 transition-all hover:bg-white/80 hover:shadow-md">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shrink-0 font-bold shadow-md shadow-primary/20">3</div>
                                <div>
                                    <h4 class="font-bold mb-1 text-lg">{{ t('about.enterpriseGrade') }}</h4>
                                    <p class="text-muted-foreground">{{ t('about.enterpriseGradeDesc') }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <a href="/courses" class="inline-flex items-center justify-center w-full sm:w-auto h-14 px-8 bg-primary hover:bg-primary/90 text-white rounded-xl shadow-lg shadow-primary/20 transition-transform duration-300 hover:-translate-y-0.5 active:translate-y-0 font-semibold">
                        {{ t('about.exploreOurPrograms') }} <svg class="w-5 h-5 ml-2 rtl:ml-0 rtl:mr-2 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-8 relative z-10">
        <div class="container mx-auto px-4 md:px-6 max-w-4xl">
            <h2 class="text-3xl font-display font-bold mb-8">{{ t('aboutX.faqSectionTitle') }}</h2>
            <div class="flex flex-col gap-4">
                @foreach ($aboutFaqs as $f)
                    <div class="bg-white/50 backdrop-blur-md p-6 rounded-2xl border border-white/80 shadow-sm">
                        <h3 class="font-bold mb-2 text-lg">{{ $f['q'] }}</h3>
                        <p class="text-muted-foreground leading-relaxed">{{ $f['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
