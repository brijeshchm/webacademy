@extends('layouts.app')
@section('title', 'Corporate Training Programs for Teams | Corporates Academy')
@section('description', 'Upskill your workforce with customized corporate training in Workday, cloud, AI, data, Salesforce and other technologies for modern business teams.')
@php
    $origin = rtrim(config('services.site.origin'), '/');
    $title = 'Corporate Training & Workforce Capability';
    $desc = 'Build measurable workforce capability with customized corporate learning paths, live expert delivery, and multi-location enterprise support from Corporate Academy.';
    $canonical = $origin . '/corporate-training';
    $ogImage = $origin . '/api/og-image';

    $corporateFaqs = [];
    for ($i = 1; $i <= 6; $i++) {
        $corporateFaqs[] = ['q' => t("faq.corporate.q$i"), 'a' => t("faq.corporate.a$i")];
    }

    $serviceJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'Corporate Academy Enterprise Learning',
        'description' => 'Customized workforce capability programmes for ambitious organizations.',
        'provider' => ['@type' => 'Organization', 'name' => 'Corporate Academy'],
        'areaServed' => 'Worldwide',
        'serviceType' => 'Corporate training and workforce capability',
    ];
    $faqJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $corporateFaqs),
    ];

    $icon = function (string $name, string $cls) {
        $paths = [
            'arrow-right' => '<line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline>',
            'arrow-down' => '<line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline>',
            'chevron-right' => '<polyline points="9 18 15 12 9 6"></polyline>',
            'badge-check' => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path><path d="m9 12 2 2 4-4"></path>',
            'globe' => '<circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path>',
            'line-chart' => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="m19 9-5 5-4-4-3 3"></path>',
            'target' => '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle>',
            'layers' => '<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"></path><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"></path><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"></path>',
            'bar-chart' => '<path d="M3 3v16a2 2 0 0 0 2 2h16"></path><rect x="7" y="13" width="3" height="5"></rect><rect x="12" y="9" width="3" height="9"></rect><rect x="17" y="5" width="3" height="13"></rect>',
            'blocks' => '<rect x="7" y="7" width="14" height="14" rx="1"></rect><path d="M3 3v10a2 2 0 0 0 2 2h2V7a2 2 0 0 0-2-2H3"></path>',
            'briefcase' => '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect>',
            'users-round' => '<path d="M18 21a8 8 0 0 0-16 0"></path><circle cx="10" cy="8" r="5"></circle><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"></path>',
            'quote' => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"></path>',
            'check' => '<polyline points="20 6 9 17 4 12"></polyline>',
            'check-circle' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
            'mail' => '<rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 5L2 7"></path>',
            'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
            'map-pin' => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle>',
            'send' => '<line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>',
            'x' => '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>',
            'chevron-down' => '<polyline points="6 9 12 15 18 9"></polyline>',
        ];
        $inner = $paths[$name] ?? '';
        return '<svg class="' . $cls . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
    };

    $capabilityPillars = [
        ['index' => '01', 'icon' => 'target', 'k' => '1'],
        ['index' => '02', 'icon' => 'layers', 'k' => '2'],
        ['index' => '03', 'icon' => 'bar-chart', 'k' => '3'],
    ];
    $programs = [
        ['k' => '1', 'icon' => 'blocks', 'accent' => 'bg-[#dce9ff]'],
        ['k' => '2', 'icon' => 'briefcase', 'accent' => 'bg-[#e4f2ea]'],
        ['k' => '3', 'icon' => 'users-round', 'accent' => 'bg-[#fff0d8]'],
    ];
    $proofPoints = [
        ['value' => '01', 'k' => '1'],
        ['value' => '02', 'k' => '2'],
        ['value' => '03', 'k' => '3'],
    ];
    $cardRows = [
        [t('corporateTraining.card.row1Label'), t('corporateTraining.card.row1Value'), '100%'],
        [t('corporateTraining.card.row2Label'), t('corporateTraining.card.row2Value'), '72%'],
        [t('corporateTraining.card.row3Label'), t('corporateTraining.card.row3Value'), '48%'],
    ];
@endphp
@section('content')
<main class="min-h-[100dvh] overflow-hidden bg-[#f7f9fc] text-foreground">
    <div class="pointer-events-none fixed inset-0 z-0 opacity-[0.28]" aria-hidden="true">
        <div class="absolute -top-56 end-[-10rem] h-[42rem] w-[42rem] rounded-full bg-[#cfe0ff] blur-[100px] ca-float"></div>
        <div class="absolute top-[42rem] start-[-16rem] h-[36rem] w-[36rem] rounded-full bg-[#d9eee7] blur-[100px] ca-float-slow"></div>
    </div>

    {{-- HERO --}}
    <section class="relative z-10 mx-auto max-w-[1440px] px-5 pb-20 pt-14 sm:px-8 md:pb-28 md:pt-20 lg:px-12 lg:pt-24">
        <div class="grid items-center gap-14 lg:grid-cols-[1.05fr_0.95fr] lg:gap-16">
            <div>
                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-3.5 py-2 text-[10px] font-bold uppercase tracking-[0.2em] text-primary"><span class="h-1.5 w-1.5 rounded-full bg-primary ca-glow"></span>{{ t('corporateTraining.hero.badge') }}</div>
                <h1 class="max-w-4xl font-display text-[3.3rem] font-bold leading-[0.96] tracking-[-0.065em] text-[#12223e] sm:text-6xl md:text-7xl lg:text-[5.6rem]">{{ t('corporateTraining.hero.title1') }}<span class="block text-primary">{{ t('corporateTraining.hero.title2') }}</span></h1>
                <p class="mt-7 max-w-xl text-base leading-8 text-muted-foreground sm:text-lg">{{ t('corporateTraining.hero.subtitle') }}</p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="#enquiry" class="inline-flex h-13 items-center justify-center gap-2 rounded-full px-7 text-base font-bold shadow-xl shadow-primary/25 bg-primary text-primary-foreground">{{ t('corporateTraining.hero.ctaPrimary') }} {!! $icon('arrow-right', 'h-4 w-4 rtl:rotate-180') !!}</a>
                    <a href="/enquiry" class="inline-flex h-13 items-center justify-center gap-2 rounded-full border border-primary/20 bg-card/60 px-7 text-base font-bold">{{ t('corporateTraining.hero.ctaSecondary') }} {!! $icon('chevron-right', 'h-4 w-4 rtl:rotate-180') !!}</a>
                </div>
                <div class="mt-11 flex flex-wrap items-center gap-x-7 gap-y-3 text-xs font-bold uppercase tracking-[0.13em] text-muted-foreground"><span class="inline-flex items-center gap-2">{!! $icon('badge-check', 'h-4 w-4 text-primary') !!} {{ t('corporateTraining.hero.trust1') }}</span><span class="inline-flex items-center gap-2">{!! $icon('globe', 'h-4 w-4 text-primary') !!} {{ t('corporateTraining.hero.trust2') }}</span></div>
            </div>
            <div class="relative mx-auto w-full max-w-[570px]">
                <div class="absolute -inset-5 rounded-[2.5rem] bg-primary/10 blur-2xl" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-[2rem] border border-[#c9dafa] bg-[#122a51] p-5 text-white shadow-2xl shadow-[#1e4f9c]/20 sm:p-7">
                    <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full border border-white/10" aria-hidden="true"></div>
                    <div class="absolute -right-4 -top-8 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a9c7f8]">{{ t('corporateTraining.card.eyebrow') }}</p>
                            <h2 class="mt-3 max-w-xs font-display text-3xl font-bold leading-tight tracking-[-0.04em]">{{ t('corporateTraining.card.title') }}</h2>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10">{!! $icon('line-chart', 'h-5 w-5 text-[#9dc2ff]') !!}</span>
                    </div>
                    <div class="relative mt-12 space-y-3">
                        @foreach ($cardRows as $row)
                            <div class="rounded-2xl border border-white/10 bg-white/[0.06] p-4">
                                <div class="flex items-center justify-between gap-4 text-xs"><span class="font-medium text-white/60">{{ $row[0] }}</span><span class="font-mono text-[#b8d1ff]">{{ $row[1] }}</span></div>
                                <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-white/10"><div class="h-full rounded-full bg-[#8bb6ff]" style="width:{{ $row[2] }}"></div></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="relative mt-8 flex items-center justify-between border-t border-white/10 pt-5"><span class="text-xs text-white/50">{{ t('corporateTraining.card.footer') }}</span><span class="inline-flex items-center gap-2 text-xs font-bold text-[#b8d1ff]">{{ t('corporateTraining.card.viewMethod') }} {!! $icon('arrow-right', 'h-3.5 w-3.5 rtl:rotate-180') !!}</span></div>
                </div>
            </div>
        </div>
        <a href="#approach" class="mx-auto mt-20 flex w-fit flex-col items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-muted-foreground hover:text-primary">{{ t('corporateTraining.hero.scroll') }} {!! $icon('arrow-down', 'h-4 w-4 ca-float') !!}</a>
    </section>

    {{-- PROOF POINTS --}}
    <section class="relative z-10 border-y border-[#dbe4f0] bg-card/70">
        <div class="mx-auto grid max-w-[1440px] gap-7 px-5 py-10 sm:px-8 md:grid-cols-3 md:px-12 md:py-12 lg:px-20">
            @foreach ($proofPoints as $point)
                <div class="flex gap-4 border-border md:border-s md:ps-7 first:border-0 first:ps-0"><span class="font-mono text-sm font-bold text-primary">{{ $point['value'] }}</span><div><p class="font-display text-lg font-bold text-[#172b4d]">{{ t("corporateTraining.proof.{$point['k']}.label") }}</p><p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t("corporateTraining.proof.{$point['k']}.copy") }}</p></div></div>
            @endforeach
        </div>
    </section>

    {{-- APPROACH --}}
    <section id="approach" class="relative z-10 mx-auto max-w-[1440px] scroll-mt-10 px-5 py-24 sm:px-8 md:py-32 lg:px-12">
        <div class="grid gap-12 lg:grid-cols-[0.7fr_1.3fr] lg:gap-20">
            <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ t('corporateTraining.method.eyebrow') }}</p><h2 class="mt-5 max-w-md font-display text-4xl font-bold leading-[1.02] tracking-[-0.05em] text-[#12223e] md:text-5xl">{{ t('corporateTraining.method.title') }}</h2><p class="mt-6 max-w-sm text-base leading-7 text-muted-foreground">{{ t('corporateTraining.method.subtitle') }}</p></div>
            <div class="divide-y divide-border border-y border-border">
                @foreach ($capabilityPillars as $pillar)
                    <div class="group grid gap-5 py-7 sm:grid-cols-[60px_1fr_auto] sm:items-start sm:gap-7"><span class="font-mono text-sm font-bold text-primary">{{ $pillar['index'] }}</span><div><h3 class="flex items-center gap-3 font-display text-2xl font-bold tracking-[-0.03em] text-[#172b4d]">{!! $icon($pillar['icon'], 'h-5 w-5 text-primary') !!}{{ t("corporateTraining.pillars.{$pillar['k']}.title") }}</h3><p class="mt-3 max-w-xl text-sm leading-7 text-muted-foreground">{{ t("corporateTraining.pillars.{$pillar['k']}.copy") }}</p></div><span class="hidden h-10 w-10 items-center justify-center rounded-full border border-border text-primary transition-all group-hover:border-primary group-hover:bg-primary group-hover:text-primary-foreground sm:flex">{!! $icon('arrow-right', 'h-4 w-4 rtl:rotate-180') !!}</span></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PROGRAMMES --}}
    <section id="programmes" class="relative z-10 bg-[#eaf1fb] px-5 py-24 scroll-mt-10 sm:px-8 md:py-32 lg:px-12">
        <div class="mx-auto max-w-[1440px]">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ t('corporateTraining.programsSection.eyebrow') }}</p><h2 class="mt-5 max-w-2xl font-display text-4xl font-bold leading-[1.03] tracking-[-0.05em] text-[#12223e] md:text-5xl">{{ t('corporateTraining.programsSection.title') }}</h2></div><p class="max-w-xs text-sm leading-6 text-muted-foreground">{{ t('corporateTraining.programsSection.subtitle') }}</p></div>
            <div class="mt-14 grid gap-5 lg:grid-cols-3">
                @foreach ($programs as $program)
                    <article class="group rounded-[1.5rem] border border-[#d4dfed] bg-[#f8fbff] p-7 shadow-sm transition-shadow hover:shadow-xl hover:shadow-[#5277a9]/10 sm:p-9"><div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $program['accent'] }} text-[#17345f]">{!! $icon($program['icon'], 'h-5 w-5') !!}</div><p class="mt-12 text-[10px] font-bold uppercase tracking-[0.2em] text-primary">{{ t("corporateTraining.programs.{$program['k']}.eyebrow") }}</p><h3 class="mt-3 font-display text-2xl font-bold tracking-[-0.04em] text-[#172b4d]">{{ t("corporateTraining.programs.{$program['k']}.title") }}</h3><p class="mt-4 min-h-20 text-sm leading-7 text-muted-foreground">{{ t("corporateTraining.programs.{$program['k']}.copy") }}</p><a href="#enquiry" class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-primary underline-offset-4 hover:underline">{{ t('corporateTraining.programsSection.shape') }} {!! $icon('arrow-right', 'h-4 w-4 transition-transform group-hover:translate-x-1 rtl:rotate-180') !!}</a></article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PROOF / CREDIBILITY --}}
    <section id="proof" class="relative z-10 mx-auto max-w-[1440px] scroll-mt-10 px-5 py-24 sm:px-8 md:py-32 lg:px-12">
        <div class="grid gap-14 lg:grid-cols-[0.95fr_1.05fr] lg:gap-24">
            <div class="relative overflow-hidden rounded-[2rem] bg-[#172f55] p-8 text-white sm:p-12"><div class="absolute -bottom-20 -end-14 h-64 w-64 rounded-full border border-white/10" aria-hidden="true"></div><div class="absolute -bottom-8 end-[-2rem] h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></div>{!! $icon('quote', 'relative h-9 w-9 text-[#9dc2ff]') !!}<blockquote class="relative mt-12 max-w-lg font-display text-3xl font-semibold leading-[1.1] tracking-[-0.04em] sm:text-4xl">{{ t('corporateTraining.quote.text') }}</blockquote><div class="relative mt-12 border-t border-white/15 pt-5"><p class="text-sm font-bold">{{ t('corporateTraining.quote.principle') }}</p><p class="mt-1 text-xs text-white/55">{{ t('corporateTraining.quote.principleSub') }}</p></div></div>
            <div class="self-center"><p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ t('corporateTraining.credibility.eyebrow') }}</p><h2 class="mt-5 max-w-xl font-display text-4xl font-bold leading-[1.03] tracking-[-0.05em] text-[#12223e] md:text-5xl">{{ t('corporateTraining.credibility.title') }}</h2><p class="mt-6 max-w-xl text-base leading-8 text-muted-foreground">{{ t('corporateTraining.credibility.body') }}</p><ul class="mt-8 grid gap-4 sm:grid-cols-2">@foreach ([t('corporateTraining.credibility.point1'), t('corporateTraining.credibility.point2'), t('corporateTraining.credibility.point3'), t('corporateTraining.credibility.point4')] as $item)<li class="flex items-center gap-3 text-sm font-bold text-[#243957]"><span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">{!! $icon('check', 'h-3.5 w-3.5') !!}</span>{{ $item }}</li>@endforeach</ul><a href="{{ route('contactUs')}}" class="mt-10 inline-flex items-center gap-2 text-sm font-bold text-primary underline-offset-4 hover:underline">{{ t('corporateTraining.credibility.cta') }} {!! $icon('arrow-right', 'h-4 w-4 rtl:rotate-180') !!}</a></div>
        </div>
    </section>

    {{-- ENQUIRY --}}
    <section id="enquiry" class="relative z-10 border-t border-[#cfdbeb] bg-[#dceaff] px-5 py-24 scroll-mt-8 sm:px-8 md:py-32 lg:px-12">
        <div class="mx-auto grid max-w-[1440px] gap-14 lg:grid-cols-[0.72fr_1.28fr] lg:gap-24">
            <div class="self-start lg:sticky lg:top-8"><p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ t('corporateTraining.enquiry.eyebrow') }}</p><h2 class="mt-5 max-w-md font-display text-4xl font-bold leading-[1.03] tracking-[-0.05em] text-[#12223e] md:text-5xl">{{ t('corporateTraining.enquiry.title') }}</h2><p class="mt-6 max-w-md text-base leading-8 text-[#49617e]">{{ t('corporateTraining.enquiry.subtitle') }}</p><div class="mt-10 space-y-4 border-t border-[#b9cee9] pt-7"><div class="flex gap-3">{!! $icon('mail', 'mt-0.5 h-4 w-4 text-primary') !!}<span class="text-sm font-semibold text-[#334c6c]">corporatesacademy2@gmail.com</span></div><div class="flex gap-3">{!! $icon('phone', 'mt-0.5 h-4 w-4 text-primary') !!}<span class="text-sm font-semibold text-[#334c6c]">+91 8800182225</span></div><div class="flex gap-3">{!! $icon('map-pin', 'mt-0.5 h-4 w-4 text-primary') !!}<span class="text-sm font-semibold text-[#334c6c]">{{ t('corporateTraining.enquiry.location') }}</span></div></div></div>

            <div class="rounded-[2rem] border border-white/80 bg-[#f8fbff]/90 p-6 shadow-2xl shadow-[#4170aa]/10 sm:p-10 md:p-12">
                @if (session('success'))
                    <div data-testid="corporate-success" class="flex min-h-[510px] flex-col items-center justify-center text-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#d9f2e5] text-[#13804a]">{!! $icon('check-circle', 'h-8 w-8') !!}</div>
                        <h3 class="mt-7 font-display text-3xl font-bold tracking-[-0.04em] text-[#12223e]">{{ t('corporateTraining.form.successTitle') }}</h3>
                        <p class="mt-3 max-w-sm text-sm leading-7 text-muted-foreground">{{ t('corporateTraining.form.successBody') }}</p>
                        <a href="/corporate-training#enquiry" class="mt-8 inline-flex h-11 items-center justify-center rounded-full border border-primary/20 px-6 text-sm font-semibold">{{ t('corporateTraining.form.sendAnother') }}</a>
                    </div>
                @else
                    <form method="POST" action="{{ route('leads.store') }}" class="space-y-6" aria-label="{{ t('corporateTraining.form.ariaLabel') }}">
                        @csrf
                        <input type="hidden" name="form_type" value="corporate">
                        <div class="flex items-start justify-between gap-5 border-b border-border pb-7"><div><p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">{{ t('corporateTraining.form.step') }}</p><h3 class="mt-3 font-display text-3xl font-bold tracking-[-0.04em] text-[#12223e]">{{ t('corporateTraining.form.heading') }}</h3></div><span class="hidden h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary sm:flex">{!! $icon('send', 'h-5 w-5 -rotate-12') !!}</span></div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="space-y-2"><label for="corporate-name" class="text-sm font-bold">{{ t('corporateTraining.form.name') }} <span class="text-primary">*</span></label><input id="corporate-name" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{ t('corporateTraining.form.namePlaceholder') }}" class="h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 outline-none focus-visible:ring-2 focus-visible:ring-primary/20"></div>
                            <div class="space-y-2"><label for="corporate-company" class="text-sm font-bold">{{ t('corporateTraining.form.company') }} <span class="text-primary">*</span></label><input id="corporate-company" name="company" value="{{ old('company') }}" required autocomplete="organization" placeholder="{{ t('corporateTraining.form.companyPlaceholder') }}" class="h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 outline-none focus-visible:ring-2 focus-visible:ring-primary/20"></div>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="space-y-2"><label for="corporate-email" class="text-sm font-bold">{{ t('corporateTraining.form.email') }} <span class="text-primary">*</span></label><input id="corporate-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@company.com" class="h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 outline-none focus-visible:ring-2 focus-visible:ring-primary/20"></div>
                            <div class="space-y-2"><label for="corporate-phone" class="text-sm font-bold">{{ t('corporateTraining.form.phone') }} <span class="text-primary">*</span></label>@include('partials.phone-input', ['id' => 'corporate-phone', 'value' => old('phone'), 'inputClass' => 'h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 outline-none focus-visible:ring-2 focus-visible:ring-primary/20', 'selectClass' => 'h-12 border-[#cfdbeb] bg-white/70'])</div>
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="space-y-2"><label for="corporate-team" class="text-sm font-bold">{{ t('corporateTraining.form.teamSize') }} <span class="text-primary">*</span></label><select id="corporate-team" name="teamSize" required class="flex h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20"><option value="">{{ t('corporateTraining.form.teamSizeSelect') }}</option><option value="5–20 people">{{ t('corporateTraining.form.teamSize1') }}</option><option value="21–50 people">{{ t('corporateTraining.form.teamSize2') }}</option><option value="51–200 people">{{ t('corporateTraining.form.teamSize3') }}</option><option value="201–500 people">{{ t('corporateTraining.form.teamSize4') }}</option><option value="500+ people">{{ t('corporateTraining.form.teamSize5') }}</option></select><span class="text-xs font-medium leading-5 text-muted-foreground">{{ t('corporateTraining.form.teamSizeNote') }}</span></div>
                            <div class="space-y-2"><label for="corporate-timeline" class="text-sm font-bold">{{ t('corporateTraining.form.timeline') }} <span class="text-primary">*</span></label><select id="corporate-timeline" name="timeline" required class="flex h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20"><option value="">{{ t('corporateTraining.form.timelineSelect') }}</option><option value="Within 4 weeks">{{ t('corporateTraining.form.timeline1') }}</option><option value="1–3 months">{{ t('corporateTraining.form.timeline2') }}</option><option value="3–6 months">{{ t('corporateTraining.form.timeline3') }}</option><option value="Exploring for later">{{ t('corporateTraining.form.timeline4') }}</option></select><span class="text-xs font-medium leading-5 text-muted-foreground">{{ t('corporateTraining.form.timelineNote') }}</span></div>
                        </div>
                        <div class="space-y-2"><label for="corporate-program" class="text-sm font-bold">{{ t('corporateTraining.form.program') }} <span class="text-primary">*</span></label><select id="corporate-program" name="program" required class="flex h-12 w-full rounded-xl border border-[#cfdbeb] bg-white/70 px-4 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-primary/20"><option value="">{{ t('corporateTraining.form.programSelect') }}</option><option value="Technology and digital capability">{{ t('corporateTraining.form.program1') }}</option><option value="Leadership and manager development">{{ t('corporateTraining.form.program2') }}</option><option value="Workforce essentials">{{ t('corporateTraining.form.program3') }}</option><option value="A broader capability academy">{{ t('corporateTraining.form.program4') }}</option><option value="Not sure yet">{{ t('corporateTraining.form.program5') }}</option></select></div>
                        <div class="space-y-2"><label for="corporate-goals" class="text-sm font-bold">{{ t('corporateTraining.form.goals') }} <span class="text-primary">*</span></label><textarea id="corporate-goals" name="goals" required placeholder="{{ t('corporateTraining.form.goalsPlaceholder') }}" class="min-h-[120px] w-full resize-y rounded-xl border border-[#cfdbeb] bg-white/70 px-4 py-3 outline-none focus-visible:ring-2 focus-visible:ring-primary/20">{{ old('goals') }}</textarea><span class="text-xs font-medium leading-5 text-muted-foreground">{{ t('corporateTraining.form.goalsNote') }}</span></div>
                        <button type="submit" class="inline-flex h-14 w-full items-center justify-center gap-2 rounded-xl bg-primary text-base font-bold text-primary-foreground shadow-xl shadow-primary/20">{{ t('corporateTraining.form.submit') }} {!! $icon('arrow-right', 'h-5 w-5 rtl:rotate-180') !!}</button>
                        <p class="text-center text-xs leading-5 text-muted-foreground">{{ t('corporateTraining.form.disclaimer') }}</p>
                    </form>
                @endif
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <div class="relative z-10">
        <section class="!bg-transparent py-20">
            <div class="container mx-auto px-4 md:px-6 max-w-4xl">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-display font-bold mb-3">{{ t('faq.corporate.title') }}</h2>
                    <p class="text-muted-foreground">{{ t('faq.corporate.subtitle') }}</p>
                </div>
                <div class="flex flex-col gap-3">
                    @foreach ($corporateFaqs as $i => $f)
                        <details class="group border border-border bg-card rounded-2xl overflow-hidden">
                            <summary class="w-full flex items-center justify-between px-6 py-4 text-left gap-3 cursor-pointer list-none font-bold">
                                <span>{{ $f['q'] }}</span>
                                {!! $icon('chevron-down', 'h-5 w-5 text-muted-foreground shrink-0 transition-transform group-open:rotate-180') !!}
                            </summary>
                            <div class="px-6 pb-5"><p class="text-muted-foreground leading-relaxed">{{ $f['a'] }}</p></div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
