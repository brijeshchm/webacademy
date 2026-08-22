@extends('layouts.app')
@section('title', $course->meta_title)
@section('description', $course->meta_description)
@php     
    $totalTopics = 0;
    foreach ($curriculum as $m) {
        $totalTopics += is_array($m['topics'] ?? null) ? count($m['topics']) : 0;
    }
    // Dynamic translations resolved in the controller via  (one query).
    // Views do lookups only; proper names stay English.
    $translatedTitle = $course['title'];
    $translatedTagline = $course['tagline'];
    $description = $course['description'];
    $outcomes = $course['outcomes'];
    $eligibility = $course['eligibility'];
    //$curriculumTitles = array_map(fn ($p) => $p['title'], $course['curriculum']);
   // $careerRoles = array_map(fn ($r) => $r['role'], $course['careerRoles']);
   
      $careerMap = [
        'data-science' => [
            ['role' => 'Data Scientist', 'salary' => '₹ 12–22 LPA', 'companies' => ['Google', 'Amazon', 'Flipkart']],
            ['role' => 'ML Engineer', 'salary' => '₹ 14–25 LPA', 'companies' => ['Microsoft', 'Uber', 'Razorpay']],
            ['role' => 'Data Analyst', 'salary' => '₹ 6–14 LPA', 'companies' => ['Deloitte', 'KPMG', 'PhonePe']],
        ],
        'ai' => [
            ['role' => 'AI Engineer', 'salary' => '₹ 15–30 LPA', 'companies' => ['OpenAI', 'Google', 'NVIDIA']],
            ['role' => 'NLP Engineer', 'salary' => '₹ 12–24 LPA', 'companies' => ['Amazon', 'Microsoft', 'Infosys']],
            ['role' => 'AI Product Manager', 'salary' => '₹ 18–35 LPA', 'companies' => ['Meta', 'Apple', 'Freshworks']],
        ],
        'machine-learning' => [
            ['role' => 'ML Engineer', 'salary' => '₹ 14–28 LPA', 'companies' => ['Google', 'Netflix', 'Meesho']],
            ['role' => 'Research Scientist', 'salary' => '₹ 20–40 LPA', 'companies' => ['DeepMind', 'OpenAI', 'TCS']],
            ['role' => 'Data Engineer', 'salary' => '₹ 10–20 LPA', 'companies' => ['Uber', 'Swiggy', 'Wipro']],
        ],
        'workday' => [
            ['role' => 'Workday Consultant', 'salary' => '₹ 8–18 LPA', 'companies' => ['Deloitte', 'Accenture', 'IBM']],
            ['role' => 'HRIS Analyst', 'salary' => '₹ 6–14 LPA', 'companies' => ['Capgemini', 'TCS', 'Infosys']],
            ['role' => 'Workday Architect', 'salary' => '₹ 20–40 LPA', 'companies' => ['PwC', 'EY', 'Cognizant']],
        ],
        'servicenow' => [
            ['role' => 'ServiceNow Developer', 'salary' => '₹ 8–20 LPA', 'companies' => ['Accenture', 'Cognizant', 'TCS']],
            ['role' => 'ITSM Consultant', 'salary' => '₹ 10–22 LPA', 'companies' => ['IBM', 'Wipro', 'HCL']],
            ['role' => 'ServiceNow Architect', 'salary' => '₹ 22–45 LPA', 'companies' => ['Deloitte', 'PwC', 'Capgemini']],
        ],
        'salesforce' => [
            ['role' => 'Salesforce Developer', 'salary' => '₹ 8–18 LPA', 'companies' => ['Accenture', 'Cognizant', 'TCS']],
            ['role' => 'CRM Consultant', 'salary' => '₹ 10–20 LPA', 'companies' => ['Deloitte', 'Capgemini', 'Wipro']],
            ['role' => 'Salesforce Architect', 'salary' => '₹ 20–40 LPA', 'companies' => ['IBM', 'EY', 'PwC']],
        ],
    ];
    $careerRoles = $careerMap[$course->category_slug] ?? [
        ['role' => 'Senior Consultant', 'salary' => '₹ 10–22 LPA', 'companies' => ['Accenture', 'Deloitte', 'TCS']],
        ['role' => 'Project Manager', 'salary' => '₹ 12–25 LPA', 'companies' => ['Wipro', 'Infosys', 'IBM']],
        ['role' => 'Solution Architect', 'salary' => '₹ 18–35 LPA', 'companies' => ['Capgemini', 'PwC', 'KPMG']],
    ];
    // Batches (fixed values, mirroring getBatches()).
    $batches = [
        ['labelKey' => 'nextBatch', 'date' => $course['nextIntake'], 'seats' => 7, 'color' => 'bg-green-50 border-green-200 text-green-700'],
        ['labelKey' => 'upcoming', 'date' => 'January 2027', 'seats' => 12, 'color' => 'bg-amber-50 border-amber-200 text-amber-700'],
        ['labelKey' => 'later', 'date' => 'April 2027', 'seats' => 15, 'color' => 'bg-blue-50 border-blue-200 text-blue-700'],
    ];

    $ratingBars = [
        ['star' => 5, 'pct' => 64], ['star' => 4, 'pct' => 23], ['star' => 3, 'pct' => 9],
        ['star' => 2, 'pct' => 3], ['star' => 1, 'pct' => 1],
    ];

    // Single source of truth — the controller translates these review strings,
    // and the snapshot extractor protects them from cache pruning.
  //  $sampleReviews = \App\Data\DoctorateProgrammes::SAMPLE_REVIEWS;

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

    $ratingRounded = (int) round($course['rating']);
 $iconStroke = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';

    $moduleColors = [
        ['bg' => 'from-blue-500 to-blue-600', 'light' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200'],
        ['bg' => 'from-violet-500 to-violet-600', 'light' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200'],
        ['bg' => 'from-emerald-500 to-emerald-600', 'light' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
        ['bg' => 'from-orange-500 to-orange-600', 'light' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200'],
        ['bg' => 'from-pink-500 to-pink-600', 'light' => 'bg-pink-50', 'text' => 'text-pink-700', 'border' => 'border-pink-200'],
    ];
@endphp
@section('content')
    {{-- ══ HERO ══════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#0b1437] via-[#14205c] to-[#0a0f2e]">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.025)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.025)_1px,transparent_1px)] bg-[size:60px_60px] pointer-events-none"></div>
        <div class="absolute -top-24 left-1/3 w-[600px] h-[600px] bg-[#e53935]/15 rounded-full blur-[130px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-6 py-14 md:py-20 relative z-10">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-white/40 text-xs mb-6">
                <a href="{{ route('home') }}" class="hover:text-white/70 transition-colors">{{ t('doctorateDetail.breadcrumb.home') }}</a>
                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-3 w-3'])
                <a href="{{ route('courses') }}" class="hover:text-white/70 transition-colors">{{ t('doctorateDetail.breadcrumb.doctorate') }}</a>
                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-3 w-3'])
                <span class="text-white/60 truncate max-w-xs">{{ $course['title'] }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">
                {{-- Left — 3 cols --}}
                <div class="lg:col-span-3">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 bg-[#e53935]/20 text-[#ff6b6b] border border-[#e53935]/30 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">
                            @include('partials.lucide', ['icon' => 'graduation-cap', 'class' => 'h-3.5 w-3.5']) {{ t('doctorateDetail.hero.eyebrow') }}
                        </span>
                        <span class="bg-white/10 text-white/70 border border-white/20 px-3 py-1.5 rounded-full text-xs font-semibold">{{ $course['tag'] }}</span>
                        @if($course['badge'])
                            <span class="{{ $course['badgeColor'] }} text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $course['badge'] }}</span>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-2xl lg:text-2xl font-extrabold tracking-tight mb-3 text-white leading-[1.1]">{{ $translatedTitle }}</h1>
                    <p class="text-base text-white/60 mb-5 font-medium">
                     
                    </p>
                    <p class="text-lg text-blue-100/70 mb-7 leading-relaxed italic">"{{ $description }}"</p>

                    {{-- Rating row --}}
                    <div class="flex flex-wrap items-center gap-5 mb-7">
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 0; $i < 5; $i++)
                                    @include('partials.lucide', ['icon' => 'star', 'class' => 'h-4 w-4 ' . ($i < $ratingRounded ? 'text-amber-400' : 'text-white/20')])
                                @endfor
                            </div>
                            <span class="font-bold text-amber-400">{{ number_format($course['rating'], 1) }}</span>
                            <span class="text-white/50 text-sm">{{ t('doctorateDetail.hero.reviews', ['count' => $course['reviewCount']]) }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'users', 'class' => 'h-4 w-4 text-blue-300'])<span class="font-semibold text-white">{{ number_format($course['enrolled']) }}</span> {{ t('doctorateDetail.hero.enrolled') }}</div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'clock', 'class' => 'h-4 w-4 text-emerald-400'])<span class="font-semibold text-white">{{ $course['duration_hours'] }}</span></div>
                        <div class="flex items-center gap-1.5 text-white/70 text-sm">@include('partials.lucide', ['icon' => 'globe-2', 'class' => 'h-4 w-4 text-sky-400'])<span class="font-semibold text-white">@if($course->mode) {{ implode(', ', json_decode($course->mode, true) ?? []) }} @endif</span></div>
                    </div>

                    {{-- Key bullets --}}
                    <ul class="space-y-2 mb-7">
                        @php
                            $bullets = [
                                t('doctorateDetail.hero.bulletStructure', ['phases' => count($curriculum), 'modules' => $totalTopics, 'duration' => $course['duration']]),
                                t('doctorateDetail.hero.bulletTitle'),
                                t('doctorateDetail.hero.bulletDissertation'),
                                t('doctorateDetail.hero.bulletCohort', ['count' => $course['cohortSize']]),
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

<!-- Trigger buttons anywhere on the page -->
<button data-open-enquery-popup>Enroll Now</button>
 

<!-- The popup itself -->
<div data-lead-popup class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60">
  <div class="relative w-full max-w-md rounded-xl bg-white p-6" role="dialog" aria-modal="true">
    <button data-close-lead-popup class="absolute right-3 top-3">&times;</button>
    <form id="leadForm">
      <!-- your form fields -->

    </form>
  </div>
</div>

<script>
(function () {
  const doc = document;
  const overlay = doc.querySelector("[data-lead-popup]");

  if (!overlay) return; // popup not on this page, bail safely

  const openPopup = () => {
    overlay.classList.remove("hidden");
    overlay.classList.add("flex"); // needed if using Tailwind's hidden/flex toggle
    doc.body.style.overflow = "hidden"; // stop background scroll
    const firstInput = overlay.querySelector("input, select, textarea");
    if (firstInput) firstInput.focus();
  };

  const closePopup = () => {
    overlay.classList.add("hidden");
    overlay.classList.remove("flex");
    doc.body.style.overflow = "";
  };

  // Open on any trigger element
  doc.querySelectorAll("[data-open-enquery-popup]").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      openPopup();
    });
  });

  // Close on close button
  overlay.querySelectorAll("[data-close-lead-popup]").forEach((btn) => {
    btn.addEventListener("click", closePopup);
  });

  // Close on clicking the dark overlay (outside the modal box)
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closePopup();
  });

  // Close on Escape key
  doc.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !overlay.classList.contains("hidden")) {
      closePopup();
    }
  });

  // Expose globally so you can trigger it from anywhere (e.g. after 10s, on exit-intent)
  window.openLeadPopup = openPopup;
  window.closeLeadPopup = closePopup;
})();

</script>


                        <a href="#" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full h-12 rounded-xl bg-[#e53935] hover:bg-[#c62828] text-white font-bold shadow-lg shadow-red-500/30 ring-2 ring-red-500/20 transition-all hover:-translate-y-0.5"  data-open-enquery-popup>
                            {{ t('doctorateDetail.applyNow') }} @include('partials.lucide', ['icon' => 'arrow-right', 'class' => 'ml-2 h-4 w-4'])
                        </a>

                      
                        <p class="text-[11px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1">
                            @include('partials.lucide', ['icon' => 'shield', 'class' => 'h-3 w-3 text-emerald-500']) {{ t('doctorateDetail.card.limited', ['count' => $course['cohortSize']]) }}
                        </p>

                        <div class="mt-5 space-y-3 border-t border-gray-50 pt-5">
                            @php
                            $mode="";
                            if($course->mode){

                            $mode = implode(', ', json_decode($course->mode, true) ?? []);

                            }



                                $cardRows = [
                                    ['clock', t('doctorateDetail.card.duration'), $course['duration']],
                                    ['globe-2', t('doctorateDetail.card.mode'), $mode],
                                    ['users', t('doctorateDetail.card.cohortSize'), t('doctorateDetail.card.upToExecutives', ['count' => $course['cohortSize']])],
                                    ['graduation-cap', t('doctorateDetail.card.credential'), t('doctorateDetail.card.credentialValue')],
                                    ['calendar', t('doctorateDetail.card.nextIntake'), $course['nextIntake']],
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
                @if($nav)
                @foreach($nav as $n)
                    <a href="#{{ $n['id'] }}" data-section-link="{{ $n['id'] }}" class="shrink-0 px-5 py-4 text-sm font-semibold border-b-2 transition-all duration-200 whitespace-nowrap border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300">{{ t("doctorateDetail.nav.{$n['key']}") }}</a>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ══ HIGHLIGHTS STRIP ══════════════════════════════════════ --}}
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-6 py-5">
            <div class="grid grid-cols-1 min-[400px]:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
$mode =   implode(', ', json_decode($course->mode, true) ?? []);
                    $strip = [
                        ['clock', t('doctorateDetail.strip.duration'), $course['duration'], 'text-red-600 bg-red-50'],
                        ['flask-conical', t('doctorateDetail.strip.phases'), (string) count($curriculum), 'text-violet-600 bg-violet-50'],
                        ['book-open', t('doctorateDetail.strip.modules'), (string) $totalTopics, 'text-blue-600 bg-blue-50'],
                        ['users', t('doctorateDetail.strip.cohort'), t('doctorateDetail.strip.upTo', ['count' => $course['cohortSize']]), 'text-emerald-600 bg-emerald-50'],
                        ['graduation-cap', t('doctorateDetail.strip.credential'), 'DBA', 'text-amber-600 bg-amber-50'],
                        ['globe-2', t('doctorateDetail.strip.delivery'), $mode, 'text-cyan-600 bg-cyan-50'],
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
                    @if($aboutHeading)
                        <p class="text-gray-500 leading-relaxed mb-4 last:mb-0">{{ $aboutHeading->courseabout }}</p>
                    @endif

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">@include('partials.lucide', ['icon' => 'target', 'class' => 'h-5 w-5 text-[#e53935]']) {{ t('doctorateDetail.sections.learningOutcomes') }}</h3>
                        <div class="grid sm:grid-cols-2 gap-3">
                            

                             @for ($i = 1; $i <= 6; $i++)
    @php
        $paragraph = $aboutHeading->{'paragraph'.$i} ?? null;
    @endphp

    @if(!empty($paragraph))
        
   
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:border-red-200 hover:bg-red-50/20 transition-all">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-red-100 flex items-center justify-center shrink-0">@include('partials.lucide', ['icon' => 'check', 'class' => 'h-3 w-3 text-[#e53935]'])</div>
                                    <span class="text-sm font-medium text-gray-700"> {{ $paragraph }}</span>
                                </div>
                             @endif
@endfor
                        </div>
                    </div>

                   
                </section>


                <section id="curriculum" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-gradient-to-b from-violet-600 to-blue-600"></div>
                            <div>
                                <h2 class="text-2xl font-display font-bold text-gray-900">Programme Madules of {{ $course['title'] }}</h2>
                                <p class="text-sm text-gray-400 mt-0.5">{{ t('doctorateDetail.structureMeta', ['phases' => count($courseModules), 'modules' => '', 'duration' => '']) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach($courseModules as $i => $phase)
                            @php $col = $phaseColors[$i % count($phaseColors)]; 
                            
                            $topicOffset = 0; 
                            @endphp
                            <div class="rounded-2xl border {{ $col['border'] }} overflow-hidden">
                                <div class="bg-gradient-to-r {{ $col['bg'] }} px-6 py-4 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-white/70">{{ $phase['phase'] }}</span>
                                        <h3 class="text-lg font-bold text-white"><a href="{{ route('courses.show',$phase['slug']) }}">{{ $phase['title'] }}</a></h3>
                                    </div>
                                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $phase['rating'] }}</span>
                                </div>
                                <div class="{{ $col['light'] }} px-6 py-5">
                                    @if($phase['description'])
                                        <p class="sm:text px-4 py-4">{{ $phase['description'] }}</p>
                                        @endif

                                    <div class="grid sm:grid-cols-2 gap-2.5">
                                      
                                        @if($phase['rating'])
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                
                                              Rating: {{ $phase['rating'] }} out of 5 based on  {{ $phase['total_rating'] }} ratings
                                            </div>
                                        @endif
                                        @if($phase['course_duration'])
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                
                                                Course Duration: {{ $phase['course_duration'] }}+
                                            </div>
                                            @endif
                                            @if($phase['live_project'])
                                              <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                
                                               Live Project:  {{ $phase['live_project'] }}+
                                            </div>
                                            @endif
                                            @if($phase['professional_trained'])
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                
                                              Professional Trained:   {{ $phase['professional_trained'] }}+
                                            </div>
                                            @endif
                                            @if($phase['batches_every_month'])

                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                
                                              Batches Every Month :  {{ $phase['batches_every_month'] }}+
                                            </div>
                                            @endif
                                            @if($phase['mode'])
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                                                              
                                                @php
                                                    $mode=  implode(', ', json_decode($course->mode, true) ?? []);
                                                @endphp
                                             Class Mode: {{ $mode }}

                                            </div>
                                            @endif

                                   

                                                @if($phase['featured'])
                                            <div class="flex items-start gap-2.5 text-sm text-gray-600">
                                                @include('partials.lucide', ['icon' => 'chevron-right', 'class' => 'h-4 w-4 shrink-0 mt-0.5 ' . $col['text']]) 
                                                                                  
                                                
                                              {{ $phase['featured'] }}

                                            </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

              


                
                {{-- CURRICULUM --}}
                @if(!empty($curriculum))
                    <section id="curriculum" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-1 rounded-full bg-gradient-to-b from-violet-500 to-blue-500"></div>
                                <div>
                                    <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('courseDetailX.courseCurriculum') }}</h2>
                                    <p class="text-sm text-gray-400 mt-0.5">{{ t('courseDetailX.curriculumSummary', ['modules' => count($curriculum), 'topics' => $totalTopics, 'hours' => $course->duration_hours]) }}</p>
                                </div>
                            </div>
                            <div class="hidden sm:flex items-center gap-1.5 bg-violet-50 text-violet-700 px-3 py-1.5 rounded-xl text-xs font-semibold border border-violet-200">
                                <svg class="h-3.5 w-3.5" {!! $iconStroke !!}><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>
                                {{ t('courseDetailX.topicsCount', ['count' => $totalTopics]) }} cccccc
                            </div>
                        </div>

                        <div class="space-y-3">
                         

                            @if($curriculum)
                            @foreach($curriculum as $i => $module)
                                @php

                                    $col = $moduleColors[$i % count($moduleColors)];
                                    $topics = is_array($module['topics'] ?? null) ? $module['topics'] : [];
                           
                                @endphp
                                <details class="group bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow open:shadow-md open:{{ $col['border'] }}" {{ $i === 0 ? 'open' : '' }}>
                                    <summary class="px-5 py-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                                        <div class="flex items-center gap-4 text-left w-full">
                                            <span class="flex-shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br {{ $col['bg'] }} text-white text-sm font-bold flex items-center justify-center shadow-sm">{{ $i + 1 }}</span>
                                            <span class="font-semibold text-gray-900 text-base leading-snug flex-1">{{ ($module['title'] ?? '') }}</span>
                                            <span class="flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-lg {{ $col['light'] }} {{ $col['text'] }} shrink-0">{{ t('courseDetailX.topicsCount', ['count' => count($topics)]) }}</span>
                                            <svg class="h-4 w-4 text-gray-400 shrink-0 transition-transform duration-200 group-open:rotate-90" {!! $iconStroke !!}><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0">
                                        <div class="ml-13 border-l-2 {{ $col['border'] }} pl-5 space-y-3 mt-1">
                                            @foreach($topics as $j => $topic)
                                                <div class="flex items-start gap-2.5 text-sm text-gray-500">
                                                    <svg class="mt-1 h-3.5 w-3.5 shrink-0 {{ $col['text'] }} fill-current opacity-70" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                                   {{ $topic['content'] }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </details>
                            @endforeach
                            @endif
                        </div>
                    </section>
                @endif

                 
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
                        @foreach($careerRoles as $ri => $r)
                            <div class="bg-white/5 rounded-2xl border border-white/10 p-5 hover:bg-white/10 transition-all">
                                <div class="w-10 h-10 rounded-xl bg-[#e53935]/20 flex items-center justify-center mb-3">@include('partials.lucide', ['icon' => 'briefcase', 'class' => 'h-5 w-5 text-[#e53935]'])</div>
                                <h3 class="font-bold text-white text-sm mb-1">{{ $r['role'] }}</h3>
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
                                            
                            <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#e53935] to-rose-700 flex items-center justify-center text-white font-extrabold text-xl shrink-0">Facility</div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <div>
                                            <h3 class="font-bold text-gray-900">jjjjjjjjjjjj</h3>
                                            <p class="text-xs text-gray-400">Eligibility & Admission · </p>
                                        </div>
                                        <div class="flex items-center gap-1 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-xl text-amber-700 text-xs font-bold shrink-0">
                                            @include('partials.lucide', ['icon' => 'star', 'class' => 'h-3 w-3 text-amber-400']) 4.9
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                       
                                            <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">

Masters, MBA, or equivalent from a recognised institution
                                            </span>
                                    

                                             <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">

10+ years professional experience


                                            </span>
                                    


                                             <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">


5+ years in technology leadership, product, or digital strategy

                                            </span>
                                    
                                             <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">


Research interest statement on a digital transformation topic


                                            </span>
                                    
                                             <span class="text-[10px] bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded-full font-semibold">

Interview with programme director


                                            </span>
                                    












                                    </div>
                                </div>
                            </div>
                        
                {{-- facility --}}
                </div>
                </section>




                  <section id="reviews" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-amber-400 to-orange-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('courseDetailX.studentReviews') }}</h2>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-8 mb-8 p-6 bg-amber-50/50 rounded-2xl border border-amber-100">
                        <div class="text-center">
                            <div class="text-6xl font-extrabold text-amber-500 leading-none">{{ number_format($course->rating, 1) }}</div>
                            <div class="flex justify-center gap-0.5 my-2">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="h-4 w-4 {{ $i < round($course->rating) ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500">{{ t('courseDetailX.courseRatingLabel') }}</p>
                        </div>
                        <div class="flex-1 space-y-2">
                            @foreach($ratingBars as $rb)
                                <div class="flex items-center gap-3 text-sm">
                                    <span class="text-gray-500 w-4 text-right">{{ $rb['star'] }}</span>
                                    <svg class="h-3.5 w-3.5 text-amber-400 fill-amber-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $rb['pct'] }}%;"></div>
                                    </div>
                                    <span class="text-gray-400 text-xs w-8">{{ $rb['pct'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center sm:text-right">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($course->total_rating) }}</div>
                            <p class="text-sm text-gray-500">{{ t('courseDetailX.totalReviews') }}</p>
                        </div>
                    </div>

<div class="space-y-4">
@if($reviews)
    @php
        $names    = json_decode($reviews->name) ?: [];
        $companies = json_decode($reviews->company) ?: [];
        $comments = json_decode($reviews->comment) ?: [];
        $ratings  = json_decode($reviews->rating) ?: [];
     
    @endphp

    @foreach($names as $index => $revName)
        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-violet-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ mb_substr($revName, 0, 1) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <span class="font-semibold text-gray-900 text-sm">{{ $revName }}</span>
           
                    </div>

                    @if(!empty($companies[$index]))
                        <span class="text-xs text-gray-500 block mb-1">{{ $companies[$index] }}</span>
                    @endif

                    <div class="flex gap-0.5 mb-2">
                        @for($i = 0; $i < ($ratings[$index] ?? 0); $i++)
                            <svg class="h-3.5 w-3.5 fill-amber-400 text-amber-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        @endfor
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed">{{ $comments[$index] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif
</div>

                         </section>


              
                {{-- CERTIFICATE --}}
                <section class="scroll-mt-36 bg-gradient-to-br from-[#0b1437] to-[#14205c] rounded-3xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="shrink-0 w-56 bg-white rounded-2xl border-2 border-red-300 shadow-lg p-5 text-center">
                            <div class="text-4xl mb-2">🏛️</div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-red-500 mb-1">{{ t('doctorateDetail.certificate.credentialLabel') }}</p>
                            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ mb_strlen($course['title']) > 40 ? 'DBA' : $translatedTitle }}</h4>
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
                 @if(!empty($faqs))
                    <section id="faq" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-8 w-1 rounded-full bg-gradient-to-b from-orange-500 to-pink-500"></div>
                            <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('courseDetail.faq') }}</h2>
                        </div>
                        <div class="space-y-3">


  @php
        $faqq    = json_decode($faqs->faqq) ?: [];
        $faqa = json_decode($faqs->faqa) ?: [];
      
    @endphp

    @foreach($faqq as $index => $faqItem)

                                <details class="group bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden hover:shadow-md transition-shadow open:border-orange-200 open:bg-white">
                                    <summary class="px-5 py-4 cursor-pointer list-none text-left [&::-webkit-details-marker]:hidden">
                                        <div class="flex items-start gap-3 w-full">
                                            <div class="mt-0.5 bg-orange-50 text-orange-600 rounded-lg p-1.5 shrink-0 border border-orange-100">
                                                <svg class="h-3.5 w-3.5" {!! $iconStroke !!}><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                            </div>
                                            <span class="font-semibold text-gray-900 text-sm leading-snug flex-1">{{ $faqq[$index] ??'' }}</span>
                                            <svg class="h-4 w-4 text-gray-400 shrink-0 mt-0.5 transition-transform duration-200 group-open:rotate-180" {!! $iconStroke !!}><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </div>
                                    </summary>
                                    <div class="px-5 pb-5 pt-0">
                                        <p class="text-sm text-gray-500 leading-relaxed ml-9">{{ $faqa[$index] ??  '' }}</p>
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
                                <input type="hidden" name="course_slug" value="{{ $course['slug'] }}">
                                <input type="hidden" name="_dba_title" value="{{ $course['title'] }}">
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
