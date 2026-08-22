@extends('layouts.app')
@section('title', 'Professional Technology Training & Certification | Corporate Academy')
@section('description', 'Corporate Academy delivers expert-led tech training in Cloud, Data Science, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow and more. 490+ courses, 63,000+ professionals trained, globally recognized certifications')
@php
    use App\Http\Controllers\Web\DoctorateController as DC;

    // Translated (free-text) fields resolved in the controller via $tDyn
    // (one query); proper names left English. Views do lookups only.
    $about = array_map($tDyn, $uni['about']);
    $highlights = array_map($tDyn, $uni['highlights']);
    $statLabels = array_map(fn ($s) => $tDyn($s['label']), $uni['stats']);
    $type = $tDyn($uni['type']);

    // FAQ builders — mirror UniversityDetail.tsx (t() with {{name}} interpolation).
    $programList = implode('; ', array_map(fn ($p) => $p['title'] . ' (' . $p['duration'] . ', ' . $p['mode'] . ')', $uni['programs']));
    $residency = array_values(array_filter($uni['programs'], fn ($p) => preg_match('/residency/i', $p['mode'])));
    $residencyList = implode(t('universityDetail.faq.and'), array_map(fn ($p) => $p['title'] . ' (' . $p['mode'] . ')', $residency));

    if (count($residency) === 0) {
        $a4 = t('universityDetail.faq.a4Online', ['name' => $uni['name']]);
    } else {
        $a4 = t(count($residency) === 1 ? 'universityDetail.faq.a4ResidencyOne' : 'universityDetail.faq.a4ResidencyMany', ['name' => $uni['name'], 'programs' => $residencyList]);
    }

    $faqs = [
        [
            'question' => t('universityDetail.faq.q1', ['name' => $uni['name']]),
            'answer' => t('universityDetail.faq.a1', ['name' => $uni['name'], 'accreditations' => implode('; ', $uni['accreditations'])]),
        ],
        [
            'question' => t('universityDetail.faq.q2', ['name' => $uni['name']]),
            'answer' => t('universityDetail.faq.a2', ['name' => $uni['name'], 'programs' => $programList]),
        ],
        [
            'question' => t('universityDetail.faq.q3', ['name' => $uni['name']]),
            'answer' => t('universityDetail.faq.a3', ['name' => $uni['name'], 'type' => mb_strtolower($uni['type']), 'location' => $uni['location'], 'country' => $uni['country'], 'founded' => $uni['founded']]),
        ],
        [
            'question' => t('universityDetail.faq.q4', ['name' => $uni['name']]),
            'answer' => $a4,
        ],
    ];

    $origin = rtrim((string) config('services.site.origin'), '/');
    $nameShort = explode(' (', $uni['name'])[0];
@endphp
@section('content')
    {{-- ── HERO ─────────────────────────────────────────────── --}}
    <section class="relative bg-gradient-to-br from-[#0b1437] to-[#1a2860] text-white pt-32 pb-16">
        <div class="mx-auto max-w-6xl px-4 md:px-6">
            <div>
                <a href="{{ url('/doctorate') }}" class="inline-flex items-center gap-1.5 text-sm text-white/60 hover:text-white transition-colors mb-6">
                    @include('partials.lucide', ['icon' => 'arrow-left', 'class' => 'h-4 w-4']) {{ t('universityDetail.backToProgrammes') }}
                </a>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="h-20 w-20 rounded-2xl bg-gradient-to-br {{ $uni['color'] }} flex items-center justify-center text-white font-extrabold text-2xl shrink-0 shadow-2xl">{{ $uni['initials'] }}</div>
                <div>
                    <h1 class="text-3xl md:text-5xl font-extrabold mb-3">{{ $uni['name'] }}</h1>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-white/70">
                        <span class="flex items-center gap-1.5">@include('partials.lucide', ['icon' => 'map-pin', 'class' => 'h-4 w-4 text-[#e53935]']) {{ $uni['location'] }}, {{ $uni['country'] }}</span>
                        <span class="flex items-center gap-1.5">@include('partials.lucide', ['icon' => 'building-2', 'class' => 'h-4 w-4 text-[#e53935]']) {{ $type }}</span>
                        <span class="flex items-center gap-1.5">@include('partials.lucide', ['icon' => 'clock', 'class' => 'h-4 w-4 text-[#e53935]']) {{ t('universityDetail.established', ['year' => $uni['founded']]) }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl">
                @foreach($uni['stats'] as $si => $s)
                    <div class="rounded-2xl bg-white/5 border border-white/10 px-5 py-4">
                        <p class="text-xs text-white/50 mb-1">{{ $statLabels[$si] ?? $s['label'] }}</p>
                        <p class="font-bold">{{ $s['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── ABOUT + ACCREDITATION ────────────────────────────── --}}
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-6xl px-4 md:px-6 grid gap-12 lg:grid-cols-[1.6fr_1fr]">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-5">
                    {{ t('universityDetail.aboutHeading') }} <span class="text-[#e53935]">{{ $uni['name'] }}</span>
                </h2>
                @foreach($uni['about'] as $pi => $p)
                    <p class="text-gray-600 leading-relaxed mb-4">{{ $about[$pi] ?? $p }}</p>
                @endforeach
                <div class="mt-8">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        @include('partials.lucide', ['icon' => 'star', 'class' => 'h-5 w-5 text-[#e53935]']) {{ t('universityDetail.whyChoose', ['name' => $nameShort]) }}
                    </h3>
                    <ul class="grid sm:grid-cols-2 gap-3">
                        @foreach($uni['highlights'] as $hi => $h)
                            <li class="flex items-start gap-2.5 rounded-xl bg-gray-50 border border-gray-100 p-3.5">
                                @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-5 w-5 text-[#e53935] shrink-0 mt-0.5'])
                                <span class="text-sm text-gray-700">{{ $highlights[$hi] ?? $h }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-gray-50/60 p-7 h-fit">
                <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                    @include('partials.lucide', ['icon' => 'award', 'class' => 'h-5 w-5 text-[#e53935]']) {{ t('universityDetail.accreditationHeading') }}
                </h3>
                <ul class="flex flex-col gap-3 mb-7">
                    @foreach($uni['accreditations'] as $a)
                        <li class="flex items-start gap-2.5">
                            @include('partials.lucide', ['icon' => 'check-circle-2', 'class' => 'h-4 w-4 text-emerald-500 shrink-0 mt-0.5'])
                            <span class="text-sm text-gray-600">{{ $a }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $uni['website'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#e53935] hover:text-[#c62828] transition-colors">
                    {{ t('universityDetail.officialWebsite') }} @include('partials.lucide', ['icon' => 'external-link', 'class' => 'h-3.5 w-3.5'])
                </a>
            </div>
        </div>
    </section>

    {{-- ── PROGRAMMES OFFERED ───────────────────────────────── --}}
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-6xl px-4 md:px-6">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-8">
                {{ t('universityDetail.programmesHeading') }} <span class="text-[#e53935]">{{ $uni['name'] }}</span>
            </h2>
            <div class="grid gap-5 sm:grid-cols-2">
                @foreach($uni['programs'] as $p)
                    <div class="rounded-2xl bg-white border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $uni['color'] }} flex items-center justify-center shrink-0">
                                @include('partials.lucide', ['icon' => 'graduation-cap', 'class' => 'h-5 w-5 text-white'])
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 leading-snug mb-2">{{ $p['title'] }}</h3>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">@include('partials.lucide', ['icon' => 'clock', 'class' => 'h-3.5 w-3.5']) {{ $p['duration'] }}</span>
                                    <span class="flex items-center gap-1">@include('partials.lucide', ['icon' => 'globe-2', 'class' => 'h-3.5 w-3.5']) {{ $p['mode'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ url('/doctorate') }}" class="inline-flex items-center justify-center rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white shadow-lg shadow-red-500/25 font-semibold px-4 h-10 text-sm">
                    @include('partials.lucide', ['icon' => 'book-open', 'class' => 'h-4 w-4 mr-2']) {{ t('universityDetail.viewProgrammes') }}
                </a>
                <a href="{{ url('/enquiry') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 text-gray-700 hover:border-[#e53935] hover:text-[#e53935] px-4 h-10 text-sm font-semibold">
                    {{ t('universityDetail.enquireNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'h-4 w-4 ml-1'])
                </a>
            </div>
        </div>
    </section>

    {{-- ── FAQ ──────────────────────────────────────────────── --}}
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-4xl px-4 md:px-6">
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-8">
                {{ t('universityDetail.faqHeading') }} <span class="text-[#e53935]">{{ $uni['name'] }}</span>
            </h2>
            <div class="flex flex-col gap-4">
                @foreach($faqs as $f)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-6">
                        <h3 class="font-bold text-gray-900 mb-2">{{ $f['question'] }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $f['answer'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
