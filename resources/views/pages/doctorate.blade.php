@extends('layouts.app')

@php
    use App\Http\Controllers\Web\DoctorateController as DC;

    // Filter tags → translation keys (same stable keys the React page uses).
    $tagKeys = [
        'All' => 'all',
        'General Management' => 'generalManagement',
        'Technology' => 'technology',
        'Finance' => 'finance',
        'HR & Leadership' => 'hrLeadership',
        'Operations' => 'operations',
        'Entrepreneurship' => 'entrepreneurship',
        'Healthcare' => 'healthcare',
        'Marketing' => 'marketing',
        'Sustainability' => 'sustainability',
        'International Business' => 'internationalBusiness',
        'Data & Analytics' => 'dataAnalytics',
        'Risk & Compliance' => 'riskCompliance',
        'Project Management' => 'projectManagement',
        'Public Policy' => 'publicPolicy',
        'Hospitality' => 'hospitality',
    ];
    $tags = array_keys($tagKeys);

    $modeKey = function (string $mode): string {
        if ($mode === 'Online + Residency') return 'onlineResidency';
        if ($mode === 'Blended') return 'blended';
        return 'online';
    };
    $badgeKey = function (?string $badge): string {
        return [
            'Most Popular' => 'mostPopular',
            'New Batch' => 'newBatch',
            'Trending' => 'trending',
            'High Demand' => 'highDemand',
        ][$badge] ?? '';
    };
    $fmtDuration = fn (string $d) => t('doctoratePage.duration.years', ['count' => preg_replace('/\s*Years?$/i', '', $d)]);

    // No-JS graceful filter via ?tag=; JS enhances via data attributes.
    $activeTag = request()->query('tag', 'All');
    if (!in_array($activeTag, $tags, true)) $activeTag = 'All';
    $filtered = $activeTag === 'All'
        ? $cards
        : array_values(array_filter($cards, fn ($c) => $c['tag'] === $activeTag));
@endphp

@push('seo')
    @include('partials.seo-meta', [
        'seoTitle' => 'Doctorate / DBA Courses – Corporate Academy',
        'seoDescription' => "Earn a Doctor of Business Administration (DBA) — a Ph.D.-equivalent credential designed for senior executives. Study online, stay in your role, graduate with the 'Dr.' title.",
        'seoKeywords' => 'DBA programme India, Doctorate of Business Administration, online DBA course, executive doctorate India, PhD equivalent programme',
        'seoPath' => '/doctorate',
        'seoJsonLd' => [
            DC::organizationJsonLd(),
            DC::faqJsonLd($faqs),
        ],
    ])
@endpush

@section('content')
    {{-- ── HERO ──────────────────────────────────────────────── --}}
    <section class="relative overflow-hidden bg-[#0b1437] text-white">
        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:60px_60px]"></div>
        <div class="pointer-events-none absolute -top-32 left-1/3 h-96 w-96 rounded-full bg-[#e53935]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 md:px-6 py-20 md:py-28 grid md:grid-cols-2 gap-12 items-center">
            {{-- Left --}}
            <div class="flex flex-col gap-6">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-white/80 backdrop-blur">
                        @include('partials.lucide', ['icon' => 'graduation-cap', 'class' => 'h-3.5 w-3.5']) {{ t('doctoratePage.hero.eyebrow') }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    {{ t('doctoratePage.hero.titleLine1') }}<br>
                    <span class="text-[#e53935]">{{ t('doctoratePage.hero.titleLine2') }}</span>
                </h1>
                <ul class="flex flex-col gap-3 text-white/80 text-sm md:text-base">
                    @foreach(['bullet1','bullet2','bullet3','bullet4'] as $b)
                        <li class="flex items-start gap-2.5">
                            @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-5 w-5 flex-shrink-0 text-[#e53935] mt-0.5'])
                            {{ t("doctoratePage.hero.$b") }}
                        </li>
                    @endforeach
                </ul>

                {{-- Stats row --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                    @foreach([['50+','batches'],['5,000+','candidates'],['25+','countries'],['92%','promotion']] as [$val,$k])
                        <div class="rounded-2xl bg-white/10 border border-white/10 px-4 py-3 backdrop-blur text-center">
                            <p class="text-xl font-extrabold text-white">{{ $val }}</p>
                            <p class="text-[11px] text-white/60 mt-0.5 leading-tight">{{ t("doctoratePage.stats.$k") }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="#programmes" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white shadow-lg shadow-red-600/30 font-semibold px-6 h-10 text-sm">
                        {{ t('doctoratePage.hero.explore') }} @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 ml-1'])
                    </a>
                    <a href="#apply" class="inline-flex items-center justify-center rounded-xl border border-white/30 bg-white/10 text-white hover:bg-white/20 backdrop-blur font-semibold px-6 h-10 text-sm">
                        {{ t('doctoratePage.hero.talkCounsellor') }}
                    </a>
                </div>
            </div>

            {{-- Right — enquiry card --}}
            <div id="apply" class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 text-gray-900 scroll-mt-24">
                <h3 class="text-xl font-bold mb-1">{{ t('doctoratePage.form.title') }}</h3>
                <p class="text-sm text-gray-500 mb-6">{{ t('doctoratePage.form.subtitle') }}</p>
                @if(session('success'))
                    <p class="text-sm font-semibold text-green-600 bg-green-50 rounded-xl px-4 py-3 mb-4">
                        {{ t('doctoratePage.form.success') }}
                    </p>
                @endif
                <form action="{{ route('leads.store') }}#apply" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="hidden" name="_source" value="doctorate">
                    <div class="grid grid-cols-1 min-[400px]:grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ t('doctoratePage.form.fullName') }}</label>
                            <input required name="name" placeholder="{{ t('doctoratePage.form.namePlaceholder') }}" class="flex h-10 w-full rounded-xl border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ t('doctoratePage.form.phone') }}</label>
                            @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'flex h-10 w-full rounded-xl border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30'])
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ t('doctoratePage.form.email') }}</label>
                        <input required type="email" name="email" placeholder="you@company.com" class="flex h-10 w-full rounded-xl border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ t('doctoratePage.form.organisation') }}</label>
                        <input name="company" placeholder="{{ t('doctoratePage.form.organisationPlaceholder') }}" class="flex h-10 w-full rounded-xl border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ t('doctoratePage.form.programmeInterest') }}</label>
                        <select name="program" class="w-full border border-input rounded-xl px-3 py-2 text-sm bg-background focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option value="">{{ t('doctoratePage.form.selectProgramme') }}</option>
                            @foreach($programmeTitles as $title)
                                <option>{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white font-semibold w-full h-10 shadow-md shadow-red-500/25 text-sm">
                        {{ t('doctoratePage.form.submit') }}
                    </button>
                    <p class="text-[11px] text-gray-400 text-center">{{ t('doctoratePage.form.terms') }}</p>
                </form>
            </div>
        </div>
    </section>

    {{-- ── ONLINE DBA FROM TOP INSTITUTIONS ──────────────────── --}}
    <section id="programmes" class="py-20 bg-gray-50 scroll-mt-20">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
                    <span class="text-[#e53935]">{{ t('doctoratePage.programmes.titleAccent') }}</span> {{ t('doctoratePage.programmes.titleRest') }}
                </h2>
                <p class="text-gray-500 text-base max-w-2xl">{{ t('doctoratePage.programmes.subtitle') }}</p>
            </div>

            {{-- Filter bar (no-JS uses ?tag= links; JS toggles data-tag-filter) --}}
            <div class="flex flex-wrap gap-2 mb-8" data-doctorate-filter>
                @foreach($tags as $tag)
                    @php $on = $activeTag === $tag; @endphp
                    <a href="{{ $tag === 'All' ? url('/doctorate') : url('/doctorate') . '?tag=' . urlencode($tag) }}#programmes"
                       data-tag-filter="{{ $tag }}"
                       class="px-4 py-1.5 rounded-full text-sm font-semibold border transition-all duration-200 {{ $on ? 'bg-[#e53935] text-white border-[#e53935] shadow-md shadow-red-400/30' : 'bg-white text-gray-600 border-gray-200 hover:border-[#e53935] hover:text-[#e53935]' }}">
                        {{ t('doctoratePage.tags.' . $tagKeys[$tag]) }}
                    </a>
                @endforeach
            </div>

            {{-- Programme count --}}
            <p class="text-sm text-gray-500 font-medium mb-6">
                {{ t('doctoratePage.programmes.countLabel') }} <span class="font-bold text-gray-800" data-count>({{ count($filtered) }})</span>
            </p>

            {{-- Cards grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-cards>
                @foreach($cards as $prog)
                    @php
                        $uni = App\Data\PartnerUniversities::findByShortName($prog['university']);
                        $shown = $activeTag === 'All' || $prog['tag'] === $activeTag;
                    @endphp
                    <div data-card data-card-tag="{{ $prog['tag'] }}" class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col {{ $shown ? '' : 'hidden' }}">
                        <div class="p-6 flex-1 flex flex-col gap-4">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <span class="inline-flex items-center gap-1 bg-[#0b1437]/5 text-[#0b1437] px-3 py-1 rounded-full text-[11px] font-semibold">
                                    @include('partials.lucide', ['icon' => 'book-open', 'class' => 'h-3 w-3']) {{ t('doctoratePage.tags.' . $tagKeys[$prog['tag']]) }}
                                </span>
                                @if($prog['badge'])
                                    <span class="{{ $prog['badgeColor'] }} text-white text-[10px] font-bold px-2.5 py-1 rounded-full">
                                        {{ t('doctoratePage.badges.' . $badgeKey($prog['badge'])) }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-snug mb-1">{{ $tDyn($prog['title']) }}</h3>
                                @if($uni)
                                    <a href="{{ url('/universities/' . $uni['slug']) }}" class="text-xs text-gray-400 leading-snug hover:text-[#e53935] hover:underline transition-colors">{{ $prog['university'] }}</a>
                                @else
                                    <p class="text-xs text-gray-400 leading-snug">{{ $prog['university'] }}</p>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="flex items-center gap-1 bg-gray-50 text-gray-500 border border-gray-100 px-2.5 py-1 rounded-lg text-xs font-medium">
                                    @include('partials.lucide', ['icon' => 'clock', 'class' => 'h-3 w-3']) {{ $fmtDuration($prog['duration']) }}
                                </span>
                                <span class="flex items-center gap-1 bg-gray-50 text-gray-500 border border-gray-100 px-2.5 py-1 rounded-lg text-xs font-medium">
                                    @include('partials.lucide', ['icon' => 'globe-2', 'class' => 'h-3 w-3']) {{ t('doctoratePage.modes.' . $modeKey($prog['mode'])) }}
                                </span>
                            </div>

                            <ul class="flex flex-col gap-1.5">
                                @foreach($prog['highlights'] as $h)
                                    <li class="flex items-center gap-2 text-xs text-gray-600">
                                        @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-3.5 w-3.5 flex-shrink-0 text-green-500']) {{ $tDyn($h) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="px-6 pb-6 pt-0 flex items-center justify-between border-t border-gray-50 mt-2 pt-4">
                            <div class="flex items-center gap-1">
                                @include('partials.lucide', ['icon' => 'star', 'class' => 'h-3.5 w-3.5 text-amber-400'])
                                <span class="text-sm font-bold text-gray-800">{{ $prog['rating'] }}</span>
                            </div>
                            <a href="{{ url('/doctorate/' . $prog['slug']) }}" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white text-xs font-semibold shadow-sm px-3 h-8">
                                {{ t('doctoratePage.viewDetails') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── WHY A DBA ─────────────────────────────────────────── --}}
    <section class="py-20 bg-white">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    {{ t('doctoratePage.why.titleStart') }} <span class="text-[#e53935]">{{ t('doctoratePage.why.titleAccent') }}</span>{{ t('doctoratePage.why.titleEnd') }}
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-base">{{ t('doctoratePage.why.subtitle') }}</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([['award','drTitle'],['briefcase','stayWorkforce'],['flask-conical','appliedResearch'],['globe-2','globalCohorts'],['shield-check','certifiedElectives'],['lightbulb','doctoralMentoring']] as [$ic,$k])
                    <div class="rounded-3xl border border-gray-100 bg-gray-50 p-7 hover:bg-white hover:shadow-md transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-[#e53935]/10 flex items-center justify-center mb-4">
                            @include('partials.lucide', ['icon' => $ic, 'class' => 'h-6 w-6 text-[#e53935]'])
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">{{ t("doctoratePage.why.$k.title") }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ t("doctoratePage.why.$k.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── CURRICULUM ────────────────────────────────────────── --}}
    <section class="py-20 bg-[#0b1437] text-white">
        <div class="mx-auto max-w-7xl px-4 md:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-3">
                    {{ t('doctoratePage.curriculum.titleStart') }} <span class="text-[#e53935]">{{ t('doctoratePage.curriculum.titleAccent') }}</span>
                </h2>
                <p class="text-white/60 max-w-2xl mx-auto text-base">{{ t('doctoratePage.curriculum.subtitle') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['phase1',4],['phase2',4],['phase3',4]] as [$pk,$mc])
                    <div class="rounded-3xl bg-white/5 border border-white/10 p-7 backdrop-blur hover:bg-white/10 transition-all duration-300">
                        <span class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-[#e53935] mb-3">{{ t("doctoratePage.curriculum.$pk.phase") }}</span>
                        <h3 class="text-lg font-bold text-white mb-1">{{ t("doctoratePage.curriculum.$pk.title") }}</h3>
                        <p class="text-xs text-white/40 mb-5 font-medium">{{ t("doctoratePage.curriculum.$pk.duration") }}</p>
                        <ul class="flex flex-col gap-2.5">
                            @for($mi = 0; $mi < $mc; $mi++)
                                <li class="flex items-start gap-2.5 text-sm text-white/70">
                                    @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 flex-shrink-0 text-[#e53935] mt-0.5'])
                                    {{ t("doctoratePage.curriculum.$pk.modules.$mi") }}
                                </li>
                            @endfor
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── ELIGIBILITY ───────────────────────────────────────── --}}
    <section class="py-20 bg-white">
        <div class="mx-auto max-w-7xl px-4 md:px-6 grid md:grid-cols-2 gap-14 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    {{ t('doctoratePage.eligibility.titleStart') }}<br><span class="text-[#e53935]">{{ t('doctoratePage.eligibility.titleAccent') }}</span>
                </h2>
                <p class="text-gray-500 text-base mb-8 leading-relaxed">{{ t('doctoratePage.eligibility.subtitle') }}</p>
                <ul class="flex flex-col gap-4">
                    @foreach(['masters','experience','seniorRole','english','statement','interview'] as $e)
                        <li class="flex items-start gap-3">
                            @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-5 w-5 flex-shrink-0 text-[#e53935] mt-0.5'])
                            <span class="text-sm text-gray-700">{{ t("doctoratePage.eligibility.items.$e") }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#apply" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white shadow-lg shadow-red-500/25 font-semibold px-4 h-10 text-sm">
                        {{ t('doctoratePage.applyNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'h-4 w-4 ml-1'])
                    </a>
                    <a href="{{ url('/enquiry') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 text-gray-700 hover:border-[#e53935] hover:text-[#e53935] px-4 h-10 text-sm font-semibold">
                        {{ t('doctoratePage.enquireNow') }}
                    </a>
                </div>
            </div>

            {{-- Right — quick stats card --}}
            <div class="rounded-3xl bg-gradient-to-br from-[#0b1437] to-[#1a2860] p-8 text-white shadow-xl">
                <h3 class="text-xl font-bold mb-6">{{ t('doctoratePage.glance.title') }}</h3>
                @foreach([['clock','duration'],['globe-2','deliveryMode'],['users','cohortSize'],['graduation-cap','credential'],['building-2','industryPartners'],['bar-chart-3','careerImpact'],['target','nextIntake']] as [$ic,$k])
                    <div class="flex items-center gap-4 py-3 border-b border-white/10 last:border-0">
                        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            @include('partials.lucide', ['icon' => $ic, 'class' => 'h-4 w-4 text-[#e53935]'])
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-white/50">{{ t("doctoratePage.glance.$k.label") }}</p>
                            <p class="text-sm font-semibold text-white">{{ t("doctoratePage.glance.$k.value") }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── UNIVERSITY PARTNERS ─────────────────────────────── --}}
    <section class="py-20 bg-white">
        <div class="mx-auto max-w-6xl px-4 md:px-6">
            <div class="text-center mb-12">
                <p class="text-sm font-bold uppercase tracking-widest text-[#e53935] mb-2">{{ t('doctoratePage.partners.eyebrow') }}</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                    {{ t('doctoratePage.partners.titleStart') }} <span class="text-[#e53935]">{{ t('doctoratePage.partners.titleAccent') }}</span>
                </h2>
                <p class="text-gray-500 max-w-2xl mx-auto">{{ t('doctoratePage.partners.subtitle') }}</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($universities as $u)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br {{ $u['color'] }} flex items-center justify-center text-white font-extrabold text-sm shrink-0">{{ $u['initials'] }}</div>
                            <div>
                                <a href="{{ url('/universities/' . $u['slug']) }}" class="font-bold text-gray-900 leading-snug hover:text-[#e53935] transition-colors">{{ $u['name'] }}</a>
                                <p class="text-xs text-gray-500 flex items-center gap-1">@include('partials.lucide', ['icon' => 'globe-2', 'class' => 'h-3 w-3']) {{ $u['location'] }}, {{ $u['country'] }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $tDyn($u['blurb']) }}</p>
                        <a href="{{ url('/universities/' . $u['slug']) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[#e53935] hover:text-[#c62828] transition-colors">
                            {{ t('doctoratePage.partners.viewUniversity') }} @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4'])
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── BOTTOM CTA ────────────────────────────────────────── --}}
    <section class="py-20 bg-gray-50">
        <div class="mx-auto max-w-4xl px-4 md:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                {{ t('doctoratePage.cta.titleStart') }} <span class="text-[#e53935]">{{ t('doctoratePage.cta.titleAccent') }}</span>{{ t('doctoratePage.cta.titleEnd') }}
            </h2>
            <p class="text-gray-500 text-base mb-8 max-w-xl mx-auto">{{ t('doctoratePage.cta.subtitle') }}</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#apply" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white shadow-lg shadow-red-500/25 font-semibold px-8 py-3 text-base">
                    {{ t('doctoratePage.cta.applyButton') }}
                </a>
                <a href="{{ url('/enquiry') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 text-gray-700 font-semibold px-8 py-3 text-base hover:border-[#e53935] hover:text-[#e53935]">
                    @include('partials.lucide', ['icon' => 'mail', 'class' => 'h-4 w-4 mr-2']) {{ t('doctoratePage.cta.enquiryButton') }}
                </a>
            </div>
            <div class="mt-8 flex items-center justify-center gap-6 text-sm text-gray-400 flex-wrap">
                <span class="flex items-center gap-1.5">@include('partials.lucide', ['icon' => 'phone', 'class' => 'h-4 w-4']) +91 (800) 123-4567</span>
                <span class="flex items-center gap-1.5">@include('partials.lucide', ['icon' => 'mail', 'class' => 'h-4 w-4']) doctorate@corporateacademy.in</span>
            </div>
        </div>
    </section>
@endsection
