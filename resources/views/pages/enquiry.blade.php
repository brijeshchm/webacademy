@extends('layouts.app')

@php

    $origin = rtrim(config('services.site.origin'), '/');
    $title = 'Enquire Now';
    $desc = 'Tell us your learning goals and our certified training consultants will design the right programme for you or your team. Group pricing available for 5 or more. Response within 24 hours.';
    $canonical = $origin . '/enquiry';
    $ogImage = $origin . '/api/og-image';

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

    $benefits = [
        ['icon' => 'clock', 'titleKey' => 'enquiryX.benefitFastResponseTitle', 'descKey' => 'enquiryX.benefitFastResponseDesc'],
        ['icon' => 'award', 'titleKey' => 'enquiryX.benefitExpertTitle', 'descKey' => 'enquiryX.benefitExpertDesc'],
        ['icon' => 'users', 'titleKey' => 'enquiryX.benefitGroupTitle', 'descKey' => 'enquiryX.benefitGroupDesc'],
        ['icon' => 'book', 'titleKey' => 'enquiryX.benefitCustomTitle', 'descKey' => 'enquiryX.benefitCustomDesc'],
    ];

    $fieldsRequired = t('enquiryX.fieldsRequiredNote');
@endphp

@push('seo')
    <title>{{ $title }} | Corporate Academy</title>
    <meta name="description" content="{{ $desc }}">
    <meta name="keywords" content="course enquiry, corporate academy enquiry, training enquiry India, group training pricing">
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
@endpush

@section('content')
<div class="min-h-screen bg-background pb-24 relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-[700px] h-[700px] rounded-full bg-primary/8 blur-[120px] ca-float"></div>
        <div class="absolute top-1/2 -left-60 w-[500px] h-[500px] rounded-full bg-secondary/10 blur-[100px] ca-float-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] rounded-full bg-primary/5 blur-[80px] ca-float"></div>
    </div>

    {{-- Hero banner --}}
    <div class="relative z-10 border-b border-white/30 bg-gradient-to-br from-primary/5 via-transparent to-secondary/5">
        <div class="px-4 md:px-6 py-20 max-w-7xl mx-auto">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-6">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"></path></svg>
                    {{ t('enquiryX.getInTouch') }}
                </div>
                <h1 class="text-4xl md:text-6xl font-display font-bold leading-tight mb-6">
                    {{ t('enquiryX.startYour') }}
                    <span class="bg-[linear-gradient(90deg,#1d4ed8,#2563eb,#38bdf8)] ca-gradient-pan bg-clip-text text-transparent">
                        {{ t('enquiryX.learningJourney') }}
                    </span>
                </h1>
                <p class="text-xl text-muted-foreground leading-relaxed max-w-xl">
                    {{ t('enquiryX.heroDesc') }}
                </p>
            </div>
        </div>
    </div>

    <div class="relative z-10 px-4 md:px-6 max-w-7xl mx-auto mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">

            {{-- Benefits sidebar --}}
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-2xl font-display font-bold mb-8">{{ t('enquiryX.whyEnquire') }}</h2>
                @foreach ($benefits as $b)
                    <div class="flex gap-4 p-5 bg-white/50 backdrop-blur-md border border-white/70 rounded-2xl shadow-sm hover:shadow-md hover:bg-white/70 transition-all duration-300 group">
                        <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-colors">
                            @switch($b['icon'])
                                @case('clock')
                                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    @break
                                @case('award')
                                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg>
                                    @break
                                @case('users')
                                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            @endswitch
                        </div>
                        <div>
                            <h3 class="font-bold text-sm mb-1">{{ t($b['titleKey']) }}</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed">{{ t($b['descKey']) }}</p>
                        </div>
                    </div>
                @endforeach

                {{-- Testimonial snippet --}}
                <div class="mt-6 p-6 bg-gradient-to-br from-primary/10 to-secondary/10 border border-primary/20 rounded-2xl">
                    <p class="text-sm text-foreground/80 italic leading-relaxed mb-4">
                        “{{ t('enquiryX.testimonialQuote') }}”
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Ravi Sharma</p>
                            <p class="text-xs text-muted-foreground">{{ t('enquiryX.testimonialRole') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form card --}}
            <div class="lg:col-span-3">
                @if (session('success'))
                    <div data-testid="enquiry-success" class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-14 shadow-xl text-center">
                        <div class="w-20 h-20 rounded-full bg-green-100 border-4 border-green-200 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <h2 class="text-2xl font-display font-bold mb-3">{{ t('enquiryX.enquiryReceived') }}</h2>
                        <p class="text-muted-foreground mb-8 max-w-sm mx-auto">{{ t('enquiryX.enquiryReceivedDesc') }}</p>
                        <a href="/enquiry" class="inline-flex items-center justify-center h-11 px-6 rounded-xl border border-input bg-background text-sm font-semibold hover:bg-muted transition-colors">
                            {{ t('enquiryX.submitAnother') }}
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('leads.store') }}" class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-10 shadow-xl">
                        @csrf
                        <input type="hidden" name="form_type" value="enquiry">
                        <h2 class="text-2xl font-display font-bold mb-2">{{ t('enquiryX.sendAnEnquiry') }}</h2>
                        <p class="text-sm text-muted-foreground mb-8">{!! str_replace(['&lt;0&gt;', '&lt;/0&gt;'], ['<span class="text-primary font-semibold">', '</span>'], e($fieldsRequired)) !!}</p>

                        <div class="space-y-5">
                            {{-- Name --}}
                            <div>
                                <label class="text-sm font-semibold mb-1.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    {{ t('enquiryX.fullName') }} <span class="text-primary">*</span>
                                </label>
                                <input name="name" value="{{ old('name') }}" placeholder="{{ t('enquiryX.namePlaceholder') }}" required
                                    class="w-full bg-white/70 border border-white/60 h-11 rounded-xl px-3 focus:ring-2 focus:ring-primary/20 transition-shadow outline-none">
                            </div>

                            {{-- Email + Phone --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 5L2 7"></path></svg>
                                        {{ t('enquiryX.email') }} <span class="text-primary">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ t('enquiryX.emailPlaceholder') }}" required
                                        class="w-full bg-white/70 border border-white/60 h-11 rounded-xl px-3 focus:ring-2 focus:ring-primary/20 transition-shadow outline-none">
                                </div>
                                <div>
                                    <label class="text-sm font-semibold mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        {{ t('enquiryX.phone') }} <span class="text-primary">*</span>
                                    </label>
                                    @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'w-full bg-white/70 border border-white/60 h-11 rounded-xl px-3 focus:ring-2 focus:ring-primary/20 transition-shadow outline-none', 'selectClass' => 'h-11 bg-white/70 border-white/60'])
                                </div>
                            </div>

                            {{-- Course Interest --}}
                            <div>
                                <label class="text-sm font-semibold mb-1.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                    {{ t('enquiryX.courseOfInterest') }}
                                </label>
                                <div class="relative">
                                    <select name="courseInterest"
                                        class="w-full h-11 rounded-xl border border-white/60 bg-white/70 px-3 pr-10 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20 appearance-none transition-shadow">
                                        <option value="">{{ t('enquiryX.selectCourse') }}</option>
                                        @foreach ($courses as $courseTitle)
                                            <option value="{{ $courseTitle }}">{{ $courseLabels[$courseTitle] ?? $courseTitle }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground">
                                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div>
                                <label class="text-sm font-semibold mb-1.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    {{ t('enquiryX.message') }}
                                </label>
                                <textarea name="message" rows="4" placeholder="{{ t('enquiryX.messagePlaceholder') }}"
                                    class="w-full bg-white/70 border border-white/60 rounded-xl px-3 py-2 focus:ring-2 focus:ring-primary/20 resize-none transition-shadow outline-none">{{ old('message') }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full h-13 text-base inline-flex items-center justify-center bg-primary hover:bg-primary/90 text-white shadow-xl shadow-primary/25 rounded-xl transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 hover:shadow-2xl hover:shadow-primary/30 gap-2 group">
                                    {{ t('enquiryX.sendEnquiry') }}
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </button>
                                <p class="text-xs text-muted-foreground text-center mt-3">
                                    {{ t('enquiryX.privacyNote') }}
                                </p>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
