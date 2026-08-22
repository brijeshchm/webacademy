@extends('layouts.app')
@section('title','"Course Catalog Professional Technology Courses')
@section('description', 'Browse 490+ professional technology courses across Data Science, AI, Cloud Computing, Workday, ServiceNow, Salesforce, DevOps, Cybersecurity, PMP and more. Live online and self-paced options')
@php
    use App\Http\Controllers\Web\DoctorateController as DC;

    $totalTopics = array_sum(array_map(fn ($p) => count($p['topics']), $prog['curriculum']));

    // Dynamic translations resolved in the controller via $tDyn (one query).
    // Views do lookups only; proper names stay English.
    $translatedTitle = $tDyn($prog['title']);
    $translatedTagline = $tDyn($prog['tagline']);
    $description = array_map($tDyn, $prog['description']);
    $outcomes = array_map($tDyn, $prog['outcomes']);
    $eligibility = array_map($tDyn, $prog['eligibility']);
    $curriculumTitles = array_map(fn ($p) => $tDyn($p['title']), $prog['curriculum']);
    $careerRoles = array_map(fn ($r) => $tDyn($r['role']), $prog['careerRoles']);
    $faqQuestions = array_map(fn ($f) => $tDyn($f['q']), $prog['faq']);
    $faqAnswers = array_map(fn ($f) => $tDyn($f['a']), $prog['faq']);

    // Batches (fixed values, mirroring getBatches()).
    $batches = [
        ['labelKey' => 'nextBatch', 'date' => $prog['nextIntake'], 'seats' => 7, 'color' => 'bg-green-50 border-green-200 text-green-700'],
        ['labelKey' => 'upcoming', 'date' => 'January 2027', 'seats' => 12, 'color' => 'bg-amber-50 border-amber-200 text-amber-700'],
        ['labelKey' => 'later', 'date' => 'April 2027', 'seats' => 15, 'color' => 'bg-blue-50 border-blue-200 text-blue-700'],
    ];

    $ratingBars = [
        ['star' => 5, 'pct' => 64], ['star' => 4, 'pct' => 23], ['star' => 3, 'pct' => 9],
        ['star' => 2, 'pct' => 3], ['star' => 1, 'pct' => 1],
    ];

    // Single source of truth — the controller translates these review strings,
    // and the snapshot extractor protects them from cache pruning.
    $sampleReviews = \App\Data\DoctorateProgrammes::SAMPLE_REVIEWS;

    $phaseColors = [
        ['bg' => 'from-red-600 to-rose-700', 'light' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200'],
        ['bg' => 'from-blue-600 to-indigo-700', 'light' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200'],
        ['bg' => 'from-violet-600 to-purple-700', 'light' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200'],
    ];

    $nav = [
        ['id' => 'overview', 'key' => 'overview'],
        ['id' => 'curriculum', 'key' => 'curriculum'],
        ['id' => 'career', 'key' => 'career'],
        ['id' => 'faculty', 'key' => 'faculty'],
        ['id' => 'reviews', 'key' => 'reviews'],
        ['id' => 'faq', 'key' => 'faq'],
    ];

    $ratingRounded = (int) round($prog['rating']);

    // FAQPage JSON-LD (translated q/a) — mirrors DoctorateDetail.tsx PageSEO.
    $faqSchema = [];
    foreach ($prog['faq'] as $i => $f) {
        $faqSchema[] = ['question' => $faqQuestions[$i] ?? $f['q'], 'answer' => $faqAnswers[$i] ?? $f['a']];
    }
@endphp


@push('schema')
        @if($faqSchema)
        
            <script type="application/ld+json">{!! json_ld($faqSchema) !!}</script>
      
        @endif
@endpush

@section('content')
    {{-- ══ HERO ══════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#0b1437] via-[#14205c] to-[#0a0f2e]">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.025)_1px,transparent_1px)] bg-[size:60px_60px] pointer-events-none"></div>
        <div class="absolute -top-24 left-1/3 w-[600px] h-[600px] bg-[#e53935]/15 rounded-full blur-[130px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-6 py-14 md:py-20 relative z-10">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-white/40 text-xs mb-6">
                <a href="{{ url('/') }}" class="hover:text-white/70 transition-colors">{{ t('doctorateDetail.breadcrumb.home') }}</a>
                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-3 w-3'])
                <a href="{{ url('/doctorate') }}" class="hover:text-white/70 transition-colors">{{ t('doctorateDetail.breadcrumb.doctorate') }}</a>
                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-3 w-3'])
                <span class="text-white/60 truncate max-w-xs">{{ $prog['title'] }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">
                {{-- Left — 3 cols --}}
                <div class="lg:col-span-3">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 bg-[#e53935]/20 text-[#ff6b6b] border border-[#e53935]/30 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">
                            @include('partials.lucide', ['icon' => 'graduation-cap', 'class' => 'h-3.5 w-3.5']) {{ t('doctorateDetail.hero.eyebrow') }}
                        </span>
                        <span class="bg-white/10 text-white/70 border border-white/20 px-3 py-1.5 rounded-full text-xs font-semibold">{{ $prog['tag'] }}</span>
                        @if($prog['badge'])
                            <span class="{{ $prog['badgeColor'] }} text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $prog['badge'] }}</span>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3 text-white leading-[1.1]">{{ $translatedTitle }}</h1>
                    <p class="text-base text-white/60 mb-5 font-medium">
                        @if($university)
                            <a href="{{ url('/universities/' . $university['slug']) }}" class="hover:text-white hover:underline transition-colors">{{ $prog['university'] }}</a>
                        @else
                            {{ $prog['university'] }}
                        @endif
                    </p>
                    <p class="text-lg text-blue-100/70 mb-7 leading-relaxed italic">"{{ $translatedTagline }}"</p>

                    {{-- Rating row --}}
                    <div class="flex flex-wrap items-center gap-5 mb-7">
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 0; $i < 5; $i++)
                                    @include('partials.lucide', ['icon' => 'star', 'class' => 'h-4 w-4 ' . ($i < $ratingRounded ? 'text-amber-400' : 'text-white/20')])
                                @endfor
                            </div>
                            <span class="font-bold text-amber-400">{{ number_format($prog['rating'], 1) }}</span>
                            <span class="text-white/50 text-sm">{{ t('doctorateDetail.hero.reviews', ['count' => $prog['reviewCount']]) }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'users', 'class' => 'h-4 w-4 text-blue-300'])<span class="font-semibold text-white">{{ number_format($prog['enrolled']) }}</span> {{ t('doctorateDetail.hero.enrolled') }}</div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'clock', 'class' => 'h-4 w-4 text-emerald-400'])<span class="font-semibold text-white">{{ $prog['duration'] }}</span></div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'globe-2', 'class' => 'h-4 w-4 text-sky-400'])<span class="font-semibold text-white">{{ $prog['mode'] }}</span></div>
                    </div>

                    {{-- Key bullets --}}
                    <ul class="space-y-2 mb-7">
                        @php
                            $bullets = [
                                t('doctorateDetail.hero.bulletStructure', ['phases' => count($prog['curriculum']), 'modules' => $totalTopics, 'duration' => $prog['duration']]),
                                t('doctorateDetail.hero.bulletTitle'),
                                t('doctorateDetail.hero.bulletDissertation'),
                                t('doctorateDetail.hero.bulletCohort', ['count' => $prog['cohortSize']]),
                            ];
                        @endphp
                        @foreach($bullets as $pt)
                            <li class="flex items-center gap-2.5 text-sm text-white/80">
                                @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-4 w-4 text-[#e53935] shrink-0']) {{ $pt }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center h-12 px-8 font-bold bg-[#e53935] hover:bg-[#c62828] text-white shadow-xl shadow-red-700/40 rounded-xl ring-2 ring-[#e53935]/30 ring-offset-2 ring-offset-transparent transition-all duration-300 hover:-translate-y-0.5">
                            {{ t('doctorateDetail.applyNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'ml-2 h-4 w-4'])
                        </a>
                        <a href="{{ url('/doctorate') }}" class="inline-flex items-center justify-center h-12 px-8 font-semibold bg-white/10 text-white border border-white/25 hover:bg-white/20 backdrop-blur-sm rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                            {{ t('doctorateDetail.allProgrammesArrow') }}
                        </a>
                    </div>

                    {{-- Trust row --}}
                    <div class="flex flex-wrap gap-4 mt-5">
                        @foreach([['shield','phdEquivalent'],['award','industryRecognised'],['globe-2','globalCohort']] as [$ic,$k])
                            <span class="flex items-center gap-1.5 text-xs text-white/50 font-medium">
                                @include('partials.lucide', ['icon' => $ic, 'class' => 'h-3.5 w-3.5 text-emerald-400']) {{ t("doctorateDetail.trust.$k") }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Right — 2 cols --}}
                <div class="lg:col-span-2 hidden lg:flex flex-col gap-4">
                    <div class="bg-white rounded-2xl shadow-2xl p-7">
                        <div class="flex items-baseline justify-between mb-1"></div>
                        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full h-12 rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white font-bold shadow-lg shadow-red-500/30 ring-2 ring-red-500/20 transition-all hover:-translate-y-0.5">
                            {{ t('doctorateDetail.applyNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'ml-2 h-4 w-4'])
                        </a>
                        <p class="text-[11px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1">
                            @include('partials.lucide', ['icon' => 'shield', 'class' => 'h-3 w-3 text-emerald-500']) {{ t('doctorateDetail.card.limited', ['count' => $prog['cohortSize']]) }}
                        </p>

                        <div class="mt-5 space-y-3 border-t border-gray-50 pt-5">
                            @php
                                $cardRows = [
                                    ['clock', t('doctorateDetail.card.duration'), $prog['duration']],
                                    ['globe-2', t('doctorateDetail.card.mode'), $prog['mode']],
                                    ['users', t('doctorateDetail.card.cohortSize'), t('doctorateDetail.card.upToExecutives', ['count' => $prog['cohortSize']])],
                                    ['graduation-cap', t('doctorateDetail.card.credential'), t('doctorateDetail.card.credentialValue')],
                                    ['calendar', t('doctorateDetail.card.nextIntake'), $prog['nextIntake']],
                                    ['award', t('doctorateDetail.card.accreditation'), t('doctorateDetail.card.accreditationValue')],
                                ];
                            @endphp
                            @foreach($cardRows as [$ic,$label,$value])
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg bg-gray-50 shrink-0">@include('partials.lucide', ['icon' => $ic, 'class' => 'h-4 w-4 text-gray-400'])</div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $label }}</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 space-y-2 border-t border-dashed border-gray-100 pt-4">
                            <a href="{{ url('/enquiry') }}" class="inline-flex items-center justify-center w-full h-10 rounded-xl text-sm font-semibold border border-gray-200 hover:border-[#e53935] hover:text-[#e53935]">
                                @include('partials.lucide', ['icon' => 'message-square', 'class' => 'h-4 w-4 mr-2']){{ t('doctorateDetail.card.requestCounselling') }}
                            </a>
                            <button type="button" class="inline-flex items-center justify-center w-full h-10 rounded-xl text-sm font-semibold text-gray-500 hover:text-[#e53935]">
                                @include('partials.lucide', ['icon' => 'download', 'class' => 'h-4 w-4 mr-2']){{ t('doctorateDetail.card.downloadBrochure') }}
                            </button>
                        </div>
                    </div>

                    {{-- Batch dates --}}
                    <div class="bg-white/10 border border-white/15 backdrop-blur-sm rounded-2xl p-5">
                        <h4 class="font-bold text-white text-sm mb-3 flex items-center gap-2">@include('partials.lucide', ['icon' => 'calendar', 'class' => 'h-4 w-4 text-[#e53935]']) {{ t('doctorateDetail.upcomingIntakes') }}</h4>
                        <div class="space-y-2">
                            @foreach($batches as $b)
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border text-sm {{ $b['color'] }}">
                                    <div><p class="font-semibold">{{ $b['date'] }}</p><p class="text-[11px] opacity-70">{{ t("doctorateDetail.batches.{$b['labelKey']}") }}</p></div>
                                    <p class="font-bold text-right">{{ t('doctorateDetail.seatsLeft', ['count' => $b['seats']]) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-16 overflow-hidden">
            <svg viewBox="0 0 1440 64" preserveAspectRatio="none" class="w-full h-full fill-gray-50">
                <path d="M0,32 C360,64 1080,0 1440,32 L1440,64 L0,64 Z"></path>
            </svg>
        </div>
    </div>

    {{-- ══ STICKY NAV ════════════════════════════════════════════ --}}
    <div class="sticky top-[72px] z-40 bg-white border-b border-gray-100 shadow-sm">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center gap-0 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach($nav as $n)
                    <a href="#{{ $n['id'] }}" data-section-link="{{ $n['id'] }}" class="shrink-0 px-5 py-4 text-sm font-semibold border-b-2 transition-all duration-200 whitespace-nowrap border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300">{{ t("doctorateDetail.nav.{$n['key']}") }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ HIGHLIGHTS STRIP ══════════════════════════════════════ --}}
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-6 py-5">
            <div class="grid grid-cols-1 min-[400px]:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $strip = [
                        ['clock', t('doctorateDetail.strip.duration'), $prog['duration'], 'text-red-600 bg-red-50'],
                        ['flask-conical', t('doctorateDetail.strip.phases'), (string) count($prog['curriculum']), 'text-violet-600 bg-violet-50'],
                        ['book-open', t('doctorateDetail.strip.modules'), (string) $totalTopics, 'text-blue-600 bg-blue-50'],
                        ['users', t('doctorateDetail.strip.cohort'), t('doctorateDetail.strip.upTo', ['count' => $prog['cohortSize']]), 'text-emerald-600 bg-emerald-50'],
                        ['graduation-cap', t('doctorateDetail.strip.credential'), 'DBA', 'text-amber-600 bg-amber-50'],
                        ['globe-2', t('doctorateDetail.strip.delivery'), $prog['mode'], 'text-cyan-600 bg-cyan-50'],
                    ];
                @endphp
                @foreach($strip as [$ic,$label,$value,$color])
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center shrink-0">@include('partials.lucide', ['icon' => $ic, 'class' => 'h-5 w-5'])</div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $label }}</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $value }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ MAIN CONTENT + SIDEBAR ════════════════════════════════ --}}
    <div class="container mx-auto px-4 md:px-6 pt-10 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- ── LEFT ────────────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- OVERVIEW --}}
                <section id="overview" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-[#e53935] to-orange-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('doctorateDetail.sections.about') }}</h2>
                    </div>
                    @foreach($description as $p)
                        <p class="text-gray-500 leading-relaxed mb-4 last:mb-0">{{ $p }}</p>
                    @endforeach

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">@include('partials.lucide', ['icon' => 'target', 'class' => 'h-5 w-5 text-[#e53935]']) {{ t('doctorateDetail.sections.learningOutcomes') }}</h3>
                        <div class="grid sm:grid-cols-2 gap-3">
                            @foreach($outcomes as $o)
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:border-red-200 hover:bg-red-50/20 transition-all">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-red-100 flex items-center justify-center shrink-0">@include('partials.lucide', ['icon' => 'check', 'class' => 'h-3 w-3 text-[#e53935]'])</div>
                                    <span class="text-sm font-medium text-gray-700">{{ $o }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">@include('partials.lucide', ['icon' => 'file-text', 'class' => 'h-5 w-5 text-[#e53935]']) {{ t('doctorateDetail.sections.eligibility') }}</h3>
                        <ul class="space-y-2">
                            @foreach($eligibility as $e)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                    @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-4 w-4 text-emerald-500 shrink-0 mt-0.5']) {{ $e }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- CURRICULUM --}}
                <section id="curriculum" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-gradient-to-b from-violet-600 to-blue-600"></div>
                            <div>
                                <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('doctorateDetail.sections.structure') }}</h2>
                                <p class="text-sm text-gray-400 mt-0.5">{{ t('doctorateDetail.structureMeta', ['phases' => count($prog['curriculum']), 'modules' => $totalTopics, 'duration' => $prog['duration']]) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach($prog['curriculum'] as $i => $phase)
                            @php $col = $phaseColors[$i % count($phaseColors)]; $topicOffset = 0; for($z=0;$z<$i;$z++){ $topicOffset += count($prog['curriculum'][$z]['topics']); } @endphp
                            <div class="rounded-2xl border {{ $col['border'] }} overflow-hidden">
                                <div class="bg-gradient-to-r {{ $col['bg'] }} px-6 py-4 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-white/70">{{ $phase['phase'] }}</span>
                                        <h3 class="text-lg font-bold text-white">{{ $curriculumTitles[$i] ?? $phase['title'] }}</h3>
                                    </div>
                                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $phase['duration'] }}</span>
                                </div>
                                <div class="{{ $col['light'] }} px-6 py-5">
                                    <div class="grid sm:grid-cols-2 gap-2.5">
                                        @foreach($phase['topics'] as $j => $topic)
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) {{ $tDyn($topic) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- CAREER OUTCOMES --}}
                <section id="career" class="scroll-mt-36 bg-gradient-to-br from-[#0b1437] to-[#14205c] rounded-3xl border border-blue-900/40 shadow-xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-amber-400 to-orange-500"></div>
                        <div>
                            <h2 class="text-2xl font-display font-bold text-white">{{ t('doctorateDetail.sections.career') }}</h2>
                            <p class="text-sm text-white/50 mt-0.5">{{ t('doctorateDetail.careerSubtitle') }}</p>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4 mb-8">
                        @foreach($prog['careerRoles'] as $ri => $r)
                            <div class="bg-white/5 rounded-2xl border border-white/10 p-5 hover:bg-white/10 transition-all">
                                <div class="w-10 h-10 rounded-xl bg-[#e53935]/20 flex items-center justify-center mb-3">@include('partials.lucide', ['icon' => 'briefcase', 'class' => 'h-5 w-5 text-[#e53935]'])</div>
                                <h3 class="font-bold text-white text-sm mb-1">{{ $careerRoles[$ri] ?? $r['role'] }}</h3>
                                <p class="text-amber-400 font-semibold text-sm mb-3">{{ $r['salary'] }}</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($r['companies'] as $c)
                                        <span class="text-[10px] bg-white/10 text-white/60 px-2 py-0.5 rounded-full font-medium">{{ $c }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10">
                        @foreach([['92%','promotionRate'],['2×','salaryMultiplier'],['18 mo','timeToRole']] as [$value,$k])
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-white">{{ $value }}</p>
                                <p class="text-xs text-white/40 mt-0.5">{{ t("doctorateDetail.careerStats.$k") }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- FACULTY --}}
                <section id="faculty" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-pink-500 to-violet-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('doctorateDetail.sections.faculty') }}</h2>
                    </div>
                    <div class="space-y-5">
                        @foreach($prog['faculty'] as $i => $f)
                            @php $facTitle = $tDyn($f['title']); @endphp
                            <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#e53935] to-rose-700 flex items-center justify-center text-white font-extrabold text-xl shrink-0">{{ mb_substr($f['name'], 0, 1) }}</div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $f['name'] }}</h3>
                                            <p class="text-xs text-gray-400">{{ $facTitle }} · {{ $f['credentials'] }}</p>
                                        </div>
                                        <div class="flex items-center gap-1 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-xl text-amber-700 text-xs font-bold shrink-0">
                                            @include('partials.lucide', ['icon' => 'star', 'class' => 'h-3 w-3 text-amber-400']) 4.9
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @foreach($f['tags'] as $ti => $tag)
                                            <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">{{ $tDyn($tag) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- REVIEWS --}}
                <section id="reviews" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-amber-400 to-orange-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('doctorateDetail.sections.reviews') }}</h2>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-8 mb-8 p-6 bg-amber-50/50 rounded-2xl border border-amber-100">
                        <div class="text-center">
                            <div class="text-4xl sm:text-6xl font-extrabold text-amber-500 leading-none">{{ number_format($prog['rating'], 1) }}</div>
                            <div class="flex justify-center gap-0.5 my-2">
                                @for($i = 0; $i < 5; $i++)
                                    @include('partials.lucide', ['icon' => 'star', 'class' => 'h-4 w-4 ' . ($i < $ratingRounded ? 'text-amber-400' : 'text-gray-200')])
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500">{{ t('doctorateDetail.programmeRating') }}</p>
                        </div>
                        <div class="flex-1 space-y-2">
                            @foreach($ratingBars as $rb)
                                <div class="flex items-center gap-3 text-sm">
                                    <span class="text-gray-500 w-4 text-right">{{ $rb['star'] }}</span>
                                    @include('partials.lucide', ['icon' => 'star', 'class' => 'h-3.5 w-3.5 text-amber-400'])
                                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $rb['pct'] }}%"></div>
                                    </div>
                                    <span class="text-gray-400 text-xs w-8">{{ $rb['pct'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center sm:text-right">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($prog['reviewCount']) }}</div>
                            <p class="text-sm text-gray-500">{{ t('doctorateDetail.totalReviews') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach($sampleReviews as $rev)
                            <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#e53935] to-rose-700 flex items-center justify-center text-white font-bold text-sm shrink-0">{{ mb_substr($rev['name'], 0, 1) }}</div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <span class="font-semibold text-gray-900 text-sm">{{ $rev['name'] }}</span>
                                            <span class="text-xs text-gray-400">{{ $rev['date'] }}</span>
                                        </div>
                                        <div class="flex gap-0.5 mb-2">
                                            @for($i = 0; $i < $rev['rating']; $i++)
                                                @include('partials.lucide', ['icon' => 'star', 'class' => 'h-3.5 w-3.5 text-amber-400'])
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $tDyn($rev['review']) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- CERTIFICATE --}}
                <section class="scroll-mt-36 bg-gradient-to-br from-[#0b1437] to-[#14205c] rounded-3xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="shrink-0 w-56 bg-white rounded-2xl border-2 border-red-300 shadow-lg p-5 text-center">
                            <div class="text-4xl mb-2">🏛️</div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-red-500 mb-1">{{ t('doctorateDetail.certificate.credentialLabel') }}</p>
                            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ mb_strlen($prog['title']) > 40 ? 'DBA' : $translatedTitle }}</h4>
                            <p class="text-[10px] text-gray-400 mb-3">Corporate Academy</p>
                            <div class="h-px bg-red-100 mb-3"></div>
                            <p class="text-[10px] text-gray-400 italic">{{ t('doctorateDetail.certificate.awarded') }}</p>
                        </div>
                        <div>
                            <span class="inline-block bg-[#e53935]/20 text-red-300 border border-[#e53935]/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-3">{{ t('doctorateDetail.certificate.badge') }}</span>
                            <h2 class="text-2xl font-display font-bold text-white mb-3">{{ t('doctorateDetail.certificate.heading') }}</h2>
                            <p class="text-white/60 text-sm leading-relaxed mb-5">{{ t('doctorateDetail.certificate.body') }}</p>
                            <ul class="space-y-2">
                                @foreach(['point1','point2','point3','point4'] as $pt)
                                    <li class="flex items-center gap-2.5 text-sm text-white/80">@include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-4 w-4 text-emerald-400 shrink-0']) {{ t("doctorateDetail.certificate.$pt") }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- FAQ --}}
                @if(count($prog['faq']) > 0)
                    <section id="faq" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-8 w-1 rounded-full bg-gradient-to-b from-orange-500 to-pink-500"></div>
                            <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('doctorateDetail.sections.faq') }}</h2>
                        </div>
                        <div class="space-y-3">
                            @foreach($prog['faq'] as $i => $item)
                                <details class="group bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden hover:shadow-md transition-shadow open:border-red-200 open:bg-white" data-accordion>
                                    <summary class="px-5 py-4 cursor-pointer list-none">
                                        <div class="flex items-start gap-3 w-full">
                                            <div class="mt-0.5 bg-red-50 text-[#e53935] rounded-lg p-1.5 shrink-0 border border-red-100">
                                                @include('partials.lucide', ['icon' => 'help-circle', 'class' => 'h-3.5 w-3.5'])
                                            </div>
                                            <span class="font-semibold text-gray-900 text-sm leading-snug flex-1">{{ $faqQuestions[$i] ?? $item['q'] }}</span>
                                            @include('partials.lucide', ['icon' => 'chevron-down', 'class' => 'h-4 w-4 text-gray-400 shrink-0 mt-0.5 transition-transform duration-200 group-open:rotate-180'])
                                        </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0">
                                        <p class="text-sm text-gray-500 leading-relaxed ml-9">{{ $faqAnswers[$i] ?? $item['a'] }}</p>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- ── SIDEBAR ─────────────────────────────────────────── --}}
            <div>
                <div class="sticky top-[130px] space-y-5">
                    {{-- Mobile enrol card --}}
                    <div class="lg:hidden bg-white rounded-3xl border border-gray-100 shadow-xl p-6">
                        <div class="flex items-baseline gap-2 mb-4"></div>
                        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full h-12 rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white font-bold">
                            {{ t('doctorateDetail.applyNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'ml-2 h-4 w-4'])
                        </a>
                    </div>

                    {{-- Quick Enquiry --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-1 flex items-center gap-2">@include('partials.lucide', ['icon' => 'phone', 'class' => 'h-4 w-4 text-[#e53935]']) {{ t('doctorateDetail.enquiry.title') }}</h3>
                        <p class="text-xs text-gray-500 mb-4">{{ t('doctorateDetail.enquiry.subtitle') }}</p>
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 font-semibold text-center">{{ t('doctorateDetail.enquiry.success') }}</div>
                        @else
                            <form action="{{ route('leads.store') }}" method="POST" class="space-y-2.5">
                                @csrf
                                <input type="hidden" name="course_slug" value="{{ $prog['slug'] }}">
                                <input type="hidden" name="_dba_title" value="{{ $prog['title'] }}">
                                <input required name="name" placeholder="{{ t('doctorateDetail.enquiry.namePlaceholder') }}" class="flex w-full rounded-xl text-sm h-10 border border-input bg-background px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30">
                                @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'flex w-full rounded-xl text-sm h-10 border border-input bg-background px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30'])
                                <input required type="email" name="email" placeholder="{{ t('doctorateDetail.enquiry.emailPlaceholder') }}" class="flex w-full rounded-xl text-sm h-10 border border-input bg-background px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <input name="company" placeholder="{{ t('doctorateDetail.enquiry.orgPlaceholder') }}" class="flex w-full rounded-xl text-sm h-10 border border-input bg-background px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <button type="submit" class="inline-flex items-center justify-center w-full h-10 rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white font-semibold text-sm">
                                    {{ t('doctorateDetail.enquiry.submit') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Upcoming intakes --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">@include('partials.lucide', ['icon' => 'calendar', 'class' => 'h-4 w-4 text-[#e53935]']) {{ t('doctorateDetail.upcomingIntakes') }}</h3>
                        <div class="space-y-2.5">
                            @foreach($batches as $b)
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border text-sm {{ $b['color'] }}">
                                    <div><p class="font-semibold">{{ $b['date'] }}</p><p class="text-[11px] opacity-70">{{ t("doctorateDetail.batches.{$b['labelKey']}") }}</p></div>
                                    <p class="font-bold">{{ t('doctorateDetail.seatsLeft', ['count' => $b['seats']]) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Corporate DBA --}}
                    <div class="bg-gradient-to-br from-[#0b1437] to-[#14205c] rounded-2xl p-5 text-white">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-[#e53935]/20 p-2 rounded-xl">@include('partials.lucide', ['icon' => 'building-2', 'class' => 'h-4 w-4 text-[#e53935]'])</div>
                            <p class="font-semibold text-white text-sm">{{ t('doctorateDetail.corporate.title') }}</p>
                        </div>
                        <p class="text-xs text-white/50 mb-3 leading-relaxed">{{ t('doctorateDetail.corporate.desc') }}</p>
                        <a href="{{ url('/corporate-training') }}" class="inline-flex items-center justify-center w-full h-9 text-sm font-semibold text-white border border-white/20 hover:bg-white/10 rounded-xl">
                            {{ t('doctorateDetail.corporate.button') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'w-3.5 h-3.5 ml-1'])
                        </a>
                    </div>

                    {{-- Browse all programmes --}}
                    <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5">
                        <p class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">@include('partials.lucide', ['icon' => 'graduation-cap', 'class' => 'h-4 w-4 text-[#e53935]']) {{ t('doctorateDetail.browseOther') }}</p>
                        <a href="{{ url('/doctorate') }}" class="inline-flex items-center justify-center w-full h-9 text-sm font-semibold border border-gray-200 hover:border-[#e53935] hover:text-[#e53935] rounded-xl">
                            {{ t('doctorateDetail.viewAll16') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
