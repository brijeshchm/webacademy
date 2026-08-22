@extends('layouts.app')
@section('title', $course->meta_title)
@section('description', $course->meta_description)
@php
    use App\Support\JsonLd;
    $site = JsonLd::siteUrl();

    // Translation key maps (mirror catalogTranslations).
    $categoryKeys = [
        'Data Science' => 'catalog.category.dataScience',
        'Artificial Intelligence' => 'catalog.category.artificialIntelligence',
        'Machine Learning' => 'catalog.category.machineLearning',
        'Workday' => 'catalog.category.workday',
        'ServiceNow' => 'catalog.category.serviceNow',
        'Salesforce' => 'catalog.category.salesforce',
        'Microsoft Dynamics 365' => 'catalog.category.microsoftDynamics',
        'Oracle Cloud' => 'catalog.category.oracleCloud',
        'Six Sigma & Lean' => 'catalog.category.sixSigmaLean',
        'PMP & Project Management' => 'catalog.category.pmpProjectManagement',
        'Cloud Computing & DevOps' => 'catalog.category.cloudComputingDevOps',
        'Agile & Scrum' => 'catalog.category.agileScrum',
    ];
    $levelKeys = [
        'Beginner' => 'catalog.level.beginner',
        'Intermediate' => 'catalog.level.intermediate',
        'Advanced' => 'catalog.level.advanced',
        'All Levels' => 'catalog.level.allLevels',
    ];
    $modeKeys = [
        'Online Live' => 'catalog.mode.onlineLive',
        'Self-Paced' => 'catalog.mode.selfPaced',
    ];
    $catName   = isset($categoryKeys[$course->category_name]) ? t($categoryKeys[$course->category_name]) : $course->category_name;
    $levelLbl  = isset($levelKeys[$course->level]) ? t($levelKeys[$course->level]) : $course->level;
    //$modeLbl   = isset($modeKeys[$course->mode]) ? t($modeKeys[$course->mode]) : $course->mode;

    $totalTopics = 0;
    if($curriculum){
    foreach ($curriculum as $m) {
        $totalTopics += is_array($m['topics'] ?? null) ? count($m['topics']) : 0;
    }
    }

    // ── batches (mirror getBatches) ──
    $now = now();
    $batches = [];
    $seatsArr = [3, 5, 12];
    $labelKeys = ['courseDetailX.batchNext', 'courseDetailX.batchUpcoming', 'courseDetailX.batchLater'];
    $colors = [
        'bg-green-50 border-green-200 text-green-700',
        'bg-amber-50 border-amber-200 text-amber-700',
        'bg-blue-50 border-blue-200 text-blue-700',
    ];
    for ($i = 0; $i < 3; $i++) {
        $d = (clone $now)->addDays(7 + $i * 14);
        $batches[] = [
            'date'     => $d->format('j M Y'),
            'seats'    => $seatsArr[$i],
            'labelKey' => $labelKeys[$i],
            'color'    => $colors[$i],
        ];
    }

    // ── audience (mirror getAudience) ──
    if (str_contains(strtolower($course->level), 'beginner')) {
        $audience = [
            ['icon' => asset('images/BriefcaseBusiness.webp'),  'title' => 'courseDetailX.audFreshGraduates',       'desc' => 'courseDetailX.audFreshGraduatesDesc'],
            ['icon' => asset('images/UsersRound.webp'), 'title' => 'courseDetailX.audCareerSwitchers',      'desc' => 'courseDetailX.audCareerSwitchersDesc'],
            ['icon' => asset('images/light.webp'),  'title' => 'courseDetailX.audCuriousLearners',      'desc' => 'courseDetailX.audCuriousLearnersDesc'],
        ];
    } else if(str_contains(strtolower($course->level), 'intermediate')){
    
        $audience = [
            ['icon' => asset('images/BriefcaseBusiness.webp'),  'title' => 'Intermediate Learners','desc' => 'Designed for learners with basic knowledge who want to strengthen their practical skills and expertise'],
            ['icon' => asset('images/UsersRound.webp'), 'title' => 'Career Growth Seekers','desc' => 'Learners looking to upgrade existing skills, gain hands-on expertise, and qualify for better job opportunities.'],
            ['icon' => asset('images/light.webp'),  'title' => 'courseDetailX.audCuriousLearners','desc' => 'courseDetailX.audCuriousLearnersDesc'],
        ];

    }else if(str_contains(strtolower($course->level), 'advanced')){
    
        $audience = [
            ['icon' => asset('images/grad.webp'),  'title' => 'Working Professionals','desc' => 'Professionals ready to upgrade their skills, accelerate career growth, and unlock better opportunities.'],
            ['icon' => asset('images/BriefcaseBusiness.webp'), 'title' => 'Team Leads & Managers',      'desc' => 'Leaders looking to strengthen technical expertise, improve decision-making, and drive better team results'],
            ['icon' => asset('images/build.webp'),  'title' => 'Entrepreneurs & Founders','desc' => 'Founders looking to build smarter products, make better decisions, and scale their businesses effectively'],
        ];

    }else if(str_contains(strtolower($course->level), 'allLevels')){
    
        $audience = [
            ['icon' => asset('images/rocket.webp'),  'title' => 'Experienced Professionals','desc' => 'Professionals with strong foundational knowledge who want to master advanced concepts and industry-level practices.'],
            ['icon' => asset('images/BriefcaseBusiness.webp'), 'title' => 'courseDetailX.audCareerSwitchers','desc' => 'courseDetailX.audCareerSwitchersDesc'],
            ['icon' => asset('images/build.webp'),  'title' => 'Specialists & Subject Matter Experts', 'desc' => 'Experienced learners who want to sharpen specialized skills, solve advanced business challenges, and stay competitive in their field.'],
        ];   
    
    }else{
        $audience = [
            ['icon' => asset('images/trend.webp'), 'title' => 'courseDetailX.audWorkingProfessionals', 'desc' => 'courseDetailX.audWorkingProfessionalsDesc'],
            ['icon' => asset('images/build.webp'), 'title' => 'courseDetailX.audTeamLeads',            'desc' => 'courseDetailX.audTeamLeadsDesc'],
            ['icon' => asset('images/rocket.webp'),'title' => 'courseDetailX.audEntrepreneurs',        'desc' => 'courseDetailX.audEntrepreneursDesc'],
        ];
    }

    // ── career roles (mirror getCareerRoles) ──
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

    $instructors = [
        ['name' => 'Ravi Sharma', 'roleKey' => 'courseDetailX.insLeadInstructor', 'exp' => '12 yrs', 'at' => 'Ex-Google · IIT Delhi', 'img' => 'marcus-lee'],
        ['name' => 'Priya Nair', 'roleKey' => 'courseDetailX.insIndustryMentor', 'exp' => '9 yrs', 'at' => 'Ex-Amazon · BITS Pilani', 'img' => 'priya-nair'],
    ];


    $sampleReviews = [
        ['name' => 'Aisha Rahman', 'rating' => 5, 'date' => 'Jul 2026', 'reviewKey' => 'courseDetailX.reviewAisha'],
        ['name' => 'Marcus Lee', 'rating' => 5, 'date' => 'Jun 2026', 'reviewKey' => 'courseDetailX.reviewMarcus'],
        ['name' => 'Sofia Hernandez', 'rating' => 4, 'date' => 'May 2026', 'reviewKey' => 'courseDetailX.reviewSofia'],
    ];
    $ratingBars = [['star' => 5, 'pct' => 62], ['star' => 4, 'pct' => 25], ['star' => 3, 'pct' => 9], ['star' => 2, 'pct' => 3], ['star' => 1, 'pct' => 1]];

    $navItems = [
        ['id' => 'overview', 'key' => 'courseDetailX.navOverview'],
        ['id' => 'whoisthisfor', 'key' => 'courseDetailX.navLearn'],
        ['id' => 'placementSuccessStories', 'key' => 'Placement Success Stories'],
        ['id' => 'aboutTrainer', 'key' => 'About Trainer'],
        ['id' => 'training-roadmap', 'key' => 'Training Roadmap'],
        ['id' => 'hiring-partners', 'key' => 'Hiring Partners'],
        ['id' => 'curriculum', 'key' => 'courseDetailX.navCurriculum'],
        ['id' => 'related-course', 'key' => 'Related Course'],
        ['id' => 'reviews', 'key' => 'courseDetailX.navReviews'],
        ['id' => 'faq', 'key' => 'courseDetailX.navFaq'],
    ];

    $moduleColors = [
        ['bg' => 'from-blue-500 to-blue-600', 'light' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200'],
        ['bg' => 'from-violet-500 to-violet-600', 'light' => 'bg-violet-50', 'text' => 'text-violet-700', 'border' => 'border-violet-200'],
        ['bg' => 'from-emerald-500 to-emerald-600', 'light' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
        ['bg' => 'from-orange-500 to-orange-600', 'light' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200'],
        ['bg' => 'from-pink-500 to-pink-600', 'light' => 'bg-pink-50', 'text' => 'text-pink-700', 'border' => 'border-pink-200'],
    ];
    $skillColors = [
        'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100',
        'bg-violet-50 text-violet-700 border-violet-200 hover:bg-violet-100',
        'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100',
        'bg-orange-50 text-orange-700 border-orange-200 hover:bg-orange-100',
        'bg-pink-50 text-pink-700 border-pink-200 hover:bg-pink-100',
        'bg-cyan-50 text-cyan-700 border-cyan-200 hover:bg-cyan-100',
    ];

    // ── JSON-LD ──
    $courseLd = JsonLd::course([
        'title' => $course->title,
        'description' => $course->description,
        'summary' => $course->summary,
        'imageUrl' => $course->image_url,
        'rating' => $course->rating,
        'reviewCount' => $course->total_rating,
        'durationHours' => $course->duration_hours,
        'level' => $course->level,
        'mode' => $course->mode,
        'slug' => $course->slug,
        'categoryName' => $course->category_name,
        'skills' => $skills,
    ]);
    $breadcrumbLd = JsonLd::breadcrumb([
        ['name' => 'Home', 'url' => $site],
        ['name' => 'Courses', 'url' => $site . '/courses'],
        ['name' => $course->title, 'url' => $site . '/courses/' . $course->slug],
    ]);
    $ld = [$courseLd, $breadcrumbLd];
     $faqPairs = [];
    if (!empty($faqs)) {
       
        foreach ($faqs as $i => $f) {
            $faqPairs[] = [
                'question' => $faqQuestions[$i] ?? ($f['question'] ?? ''),
                'answer'   => $faqAnswers[$i] ?? ($f['answer'] ?? ''),
            ];
        }
       // $ld[] = JsonLd::faq($faqPairs);
    }


        if (!empty($course->rating) && !empty($course->total_rating)) {
            $ld['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => (string) $course->rating,
                'ratingCount' => (string) $course->total_rating,
                'bestRating'  => '5',
            ];
        }

    $iconStroke = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
@endphp
@push('schema')
    <script type="application/ld+json">{!! json_ld($ld) !!}</script>
    <script type="application/ld+json">{!! json_ld($faqPairs) !!}</script>
@endpush
@section('meta_robots')
<meta name="robots" content="noindex, nofollow">
@endsection
@section('content')
<div class="pb-24 bg-gray-50">
    {{-- ═══ HERO ═══ --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#06102a] via-[#0c1f5c] to-[#0a0f2e]">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:60px_60px] pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[700px] h-[700px] bg-blue-500/15 rounded-full blur-[130px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-violet-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-4 md:px-6 py-6 md:py-2 relative z-10">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-white text-xs mb-6">
                <a href="{{ route('home') }}" class="hover:text-white/70 transition-colors">{{ t('courseDetailX.breadcrumbHome') }}</a>
                <svg class="h-3 w-3" {!! $iconStroke !!}><polyline points="9 18 15 12 9 6"></polyline></svg>
                <a href="{{ route('courses') }}" class="hover:text-white/70 transition-colors">{{ t('courseDetailX.breadcrumbCourses') }}</a>
                <svg class="h-3 w-3" {!! $iconStroke !!}><polyline points="9 18 15 12 9 6"></polyline></svg>
                <span class="text-white truncate max-w-xs">{{ $course->title }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">
                {{-- Left: copy --}}
                <div class="lg:col-span-3">
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold bg-white/15 text-white border border-white/25 backdrop-blur-sm">{{ $catName }}</span>
                        <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold bg-primary/80 text-white border-none shadow-md">{{ $levelLbl }}</span>
                        @if($course->featured)
                            <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-bold bg-amber-400 text-amber-900 border-none">⭐ {{ t('courseDetailX.topRated') }}</span>
                        @endif
                    </div>

                    <h1 class="text-2xl md:text-2xl lg:text-2xl font-display font-extrabold tracking-tight mb-5 text-white leading-[1.1]">{{ $course->title }}</h1>

                    <p class="text-base md:text-lg text-blue-100/70 mb-7 leading-relaxed">{{ $course->description }}</p>

                    {{-- Rating row --}}
                    <div class="flex flex-wrap items-center gap-5 mb-7">
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="h-4 w-4 {{ $i < round($course->rating) ? 'fill-amber-400 text-amber-400' : 'fill-white/20 text-white/20' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                @endfor
                            </div>
                            <span class="font-bold text-amber-400">{{ number_format($course->rating, 1) }}</span>
                            <span class="text-white text-sm">({{ number_format($course->total_rating) }} {{ t('courseDetail.reviews') }})</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-white text-sm">
                            <svg class="h-4 w-4 text-blue-300" {!! $iconStroke !!}><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span class="font-semibold text-white">{{ number_format($course->enrolled) }}</span> {{ t('courseDetailX.enrolledLabel') }}
                        </div>
                        <div class="flex items-center gap-1.5 text-white text-sm">
                            <svg class="h-4 w-4 text-emerald-400" {!! $iconStroke !!}><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span class="font-semibold text-white">{{ $course->duration_hours }} Hrs of</span> {{ t('courseDetailX.contentLabel') }}
                        </div>
                        <div class="flex items-center gap-1.5 text-white text-sm">
                            <svg class="h-4 w-4 text-sky-400" {!! $iconStroke !!}><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            <span class="font-semibold text-white">{{ implode(', ', json_decode($course->mode, true) ?? []) }}</span>
                        </div>
                    </div>

                    {{-- Key benefits --}}
                    <ul class="space-y-2 mb-7">
                        @foreach([
                            t('courseDetailX.modulesTopicsContent', ['modules' => count($curriculum), 'topics' => $totalTopics, 'hours' => $course->duration_hours]),
                            t('courseDetailX.benefitCertificate'),
                            t('courseDetailX.benefitLiveDoubt'),
                            t('courseDetailX.benefitProjects'),
                        ] as $pt)
                            <li class="flex items-center gap-2.5 text-sm text-white">
                                <svg class="h-4 w-4 text-emerald-400 shrink-0" {!! $iconStroke !!}><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                {{ $pt }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center h-12 px-8 font-bold bg-primary hover:bg-primary/90 text-white shadow-xl shadow-primary/40 rounded-xl ring-2 ring-primary/30 ring-offset-2 ring-offset-transparent transition-all duration-300 hover:-translate-y-0.5">
                            {{ t('courseDetail.enrollNow') }}
                            <svg class="ml-2 h-4 w-4" {!! $iconStroke !!}><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <a href="/enquiry" class="inline-flex items-center justify-center h-12 px-8 font-semibold bg-white/10 text-white border border-white/25 hover:bg-white/20 backdrop-blur-sm rounded-xl transition-all duration-300 hover:-translate-y-0.5">{{ t('courseDetailX.requestFreeCounselling') }}</a>
                    </div>



                
                    {{-- Trust badges --}}
                    <div class="flex flex-wrap gap-4 mt-5">
                        @foreach(['Expert Trainer', 'Industry Certificate','Real-live Projects','Trainer Support','Interview Preparation','Resume Building Support','Career Guidance','Lifetime Membership Access'] as $tb)
                            <span class="flex items-center gap-1.5 text-xs text-white font-medium">
                                <svg class="h-3.5 w-3.5 text-emerald-400" {!! $iconStroke !!}><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>
                                {{ $tb }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Right: image card --}}
                <div class="lg:col-span-2 hidden lg:block">
                    <div class="relative rounded-2xl overflow-hidden shadow-[0_40px_80px_rgba(0,0,0,0.6)] ring-1 ring-white/10">
                    <div class="bg-gradient-to-br from-primary/5 rounded-2xl border border-primary/10 p-5">
                        <h3 class="font-bold text-white text-sm mb-1 flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" {!! $iconStroke !!}><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            {{ t('courseDetailX.talkToCounsellor') }}
                        </h3>
                        <p class="text-xs text-white mb-4">{{ t('courseDetailX.personalisedRoadmap') }}</p>
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 font-semibold text-center">✓ {{ session('success') }}</div>
                        @else
                            <form method="POST" action="/courses/{{ $course->slug }}/enquiry" class="space-y-2.5">
                                @csrf
                                <input required name="name" placeholder="{{ t('courseDetailX.yourNamePlaceholder') }}" value="{{ old('name') }}" class="flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary', 'selectClass' => 'border-gray-200 bg-white'])
                                <input required name="email" type="email" placeholder="{{ t('courseDetailX.emailAddressPlaceholder') }}" value="{{ old('email') }}" class="flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                <button type="submit" class="w-full h-10 rounded-xl bg-primary text-white font-semibold text-sm">{{ t('courseDetailX.requestCallback') }} →</button>
                                @error('email') <p class="text-xs text-red-500 text-center">{{ t('courseDetailX.somethingWrong') }}</p> @enderror
                            </form>
                        @endif
                    </div>


                    </div>

                    {{-- Next batch alert --}}
                    <div class="mt-4 bg-white/10 backdrop-blur-sm border border-white/15 rounded-xl px-5 py-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-white font-medium">{{ t('courseDetailX.nextBatchStarts') }}</p>
                            <p class="text-sm font-bold text-white">{{ $batches[0]['date'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-amber-400 font-semibold animate-pulse">⚡ {{ t('courseDetailX.seatsLeft', ['count' => $batches[0]['seats']]) }}</p>
                            <p class="text-xs text-white">{{ t('courseDetailX.reserveSpot') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 overflow-hidden">
            <svg viewBox="0 0 1440 64" preserveAspectRatio="none" class="w-full h-full fill-gray-50"><path d="M0,32 C360,64 1080,0 1440,32 L1440,64 L0,64 Z"></path></svg>
        </div>
    </div>

    {{-- ═══ STICKY NAV ═══ --}}
    <div class="sticky top-[72px] z-40 bg-white border-b border-gray-100 shadow-sm">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center gap-0 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @if($navItems)
                @foreach($navItems as $ni)
                    <a href="#{{ $ni['id'] }}" class="shrink-0 px-5 py-4 text-sm font-semibold border-b-2 transition-all duration-200 whitespace-nowrap border-transparent text-black-500 hover:text-gray-900 hover:border-gray-300">{{ t($ni['key']) }}</a>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ HIGHLIGHTS ═══ --}}
    
    <div class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 md:px-6 py-5">

        @php
            $highlights = [
                [
                    'icon' => 'clock',
                    'label' => t('courseDetailX.highlightDuration'),
                    'value' => ($course->duration_hours ?? 0) . 'Hrs'
                ],
                [
                    'icon' => 'book',
                    'label' => t('courseDetailX.highlightModules'),
                    'value' => count($curriculum ?? [])
                ],
                [
                    'icon' => 'target',
                    'label' => t('courseDetailX.highlightTopics'),
                    'value' => $totalTopics ?? 0
                ],
                [
                    'icon' => 'users',
                    'label' => t('courseDetailX.highlightEnrolled'),
                    'value' => number_format((int) ($course->enrolled ?? 0))
                ],
                [
                    'icon' => 'award',
                    'label' => t('courseDetailX.highlightCertificate'),
                    'value' => t('courseDetailX.included')
                ],
                [
                    'icon' => 'laptop',
                    'label' => t('courseDetailX.highlightAccess'),
                    'value' => t('courseDetailX.lifetime')
                ],
            ];
        @endphp


        @if(!empty($highlights))

            <div class="
                grid
                grid-cols-1
                min-[400px]:grid-cols-2
                md:grid-cols-3
                lg:grid-cols-6
                gap-3
            ">

                @foreach($highlights as $i => $h)

                    <div
                        x-data="{ show: false }"
                        x-init="setTimeout(() => show = true, {{ $i * 100 }})"
                        :class="show
                            ? 'opacity-100 translate-y-0'
                            : 'opacity-0 translate-y-3'"
                        class="
                            group
                            relative
                            flex
                            items-center
                            gap-3
                            min-w-0

                            px-4
                            py-3.5

                            rounded-2xl
                            overflow-hidden

                            bg-gradient-to-r
                            bg-blue-600
                            via-blue-800
                            to-blue-950

                            border
                            border-blue-400/20

                            shadow-[0_6px_18px_-8px_rgba(30,64,175,0.65)]

                            hover:-translate-y-1
                            hover:shadow-[0_12px_28px_-8px_rgba(30,64,175,0.80)]

                            transition-all
                            duration-500
                            ease-out
                        "
                    >

                        {{-- Background Glow --}}
                        <div
                            class="
                                absolute
                                -top-10
                                -right-10
                                w-24
                                h-24
                                rounded-full
                                bg-blue-400/20
                                blur-2xl
                                pointer-events-none
                            ">
                        </div>


                        {{-- Bottom Glow --}}
                        <div
                            class="
                                absolute
                                -bottom-12
                                -left-8
                                w-20
                                h-20
                                rounded-full
                                bg-indigo-400/15
                                blur-2xl
                                pointer-events-none
                            ">
                        </div>


                        {{-- Hover Shine --}}
                        <div
                            class="
                                absolute
                                inset-0
                                bg-gradient-to-r
                                from-transparent
                                via-white/10
                                to-transparent

                                -translate-x-full
                                group-hover:translate-x-full

                                transition-transform
                                duration-1000

                                pointer-events-none
                            ">
                        </div>


                        {{-- ICON --}}
                        <div
                            class="
                                relative
                                z-10

                                w-11
                                h-11

                                shrink-0

                                flex
                                items-center
                                justify-center

                                rounded-xl

                                bg-white/15
                                backdrop-blur-sm

                                border
                                border-white/20

                                shadow-md

                                text-white

                                group-hover:bg-white/20
                                group-hover:scale-110
                                group-hover:rotate-3

                                transition-all
                                duration-300
                            "
                        >

                            @switch($h['icon'])

                                @case('clock')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                        ></circle>

                                        <polyline
                                            points="12 6 12 12 16 14"
                                        ></polyline>
                                    </svg>
                                    @break


                                @case('book')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <path
                                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"
                                        ></path>
                                    </svg>
                                    @break


                                @case('target')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                        ></circle>

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="6"
                                        ></circle>

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2"
                                        ></circle>
                                    </svg>
                                    @break


                                @case('users')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <path
                                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                        ></path>

                                        <circle
                                            cx="9"
                                            cy="7"
                                            r="4"
                                        ></circle>

                                        <path
                                            d="M22 21v-2a4 4 0 0 0-3-3.87"
                                        ></path>

                                        <path
                                            d="M16 3.13a4 4 0 0 1 0 7.75"
                                        ></path>
                                    </svg>
                                    @break


                                @case('award')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <circle
                                            cx="12"
                                            cy="8"
                                            r="7"
                                        ></circle>

                                        <polyline
                                            points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"
                                        ></polyline>
                                    </svg>
                                    @break


                                @case('laptop')
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <rect
                                            x="3"
                                            y="4"
                                            width="18"
                                            height="12"
                                            rx="2"
                                        ></rect>

                                        <path
                                            d="M2 20h20"
                                        ></path>
                                    </svg>
                                    @break


                                @default
                                    <svg
                                        class="h-5 w-5"
                                        {!! $iconStroke !!}
                                    >
                                        <rect
                                            x="2"
                                            y="3"
                                            width="20"
                                            height="14"
                                            rx="2"
                                            ry="2"
                                        ></rect>

                                        <line
                                            x1="8"
                                            y1="21"
                                            x2="16"
                                            y2="21"
                                        ></line>

                                        <line
                                            x1="12"
                                            y1="17"
                                            x2="12"
                                            y2="21"
                                        ></line>
                                    </svg>

                            @endswitch

                        </div>


                        {{-- CONTENT --}}
                        <div class="relative z-10 min-w-0">

                            <p
                                class="
                                    text-[10px]
                                    leading-4
                                    font-semibold
                                    uppercase
                                    tracking-wider
                                    text-black

                                    group-hover:text-blue-100

                                    transition-colors
                                    duration-300
                                "
                            >
                                {{ $h['label'] }}
                            </p>


                            <p
                                class="
                                    mt-0.5
                                    text-sm
                                    leading-5
                                    font-bold
                                    text-white
                                    truncate
                                "
                            >
                                {{ $h['value'] }}
                            </p>

                        </div>


                        {{-- Decorative Arrow --}}
                        <div
                            class="
                                relative
                                z-10

                                ml-auto

                                text-white/40

                                group-hover:text-white
                                group-hover:translate-x-1

                                transition-all
                                duration-300
                            "
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>
</div>





    {{-- ═══ MAIN + SIDEBAR ═══ --}}
    <div class="container mx-auto px-4 md:px-6 pt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- OVERVIEW --}}
                <section id="overview" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-blue-500 to-violet-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">@if($aboutHeading) {{ $aboutHeading->heading }} @endif</h2>
                    </div>
                    <div class="prose prose-neutral max-w-none prose-p:text-gray-500 prose-p:leading-relaxed">

                    @if($aboutHeading)
                            <p class="mb-4 last:mb-0">{!!  $aboutHeading->courseabout  !! }}</p>
                        @endif

 @for ($i = 1; $i <= 6; $i++)
    @php
        $paragraph = $aboutHeading->{'paragraph'.$i} ?? null;
    @endphp

    @if(!empty($paragraph))
        <div class="flex items-start gap-2.5 text-sm text-black-500 mb-3">
                 <svg class="mt-1 h-3.5 w-3.5 shrink-0 fill-current opacity-70" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
            {{ $paragraph }}
        </div>
    @endif
@endfor

                    </div>
                </section>

                {{-- WHO IS THIS FOR --}}
                <section id="whoisthisfor" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-cyan-500 to-blue-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('courseDetailX.whoIsThisFor') }}</h2>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
    @if($audience)
        @foreach($audience as $aud)
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-5 hover:bg-white hover:shadow-md transition-all duration-300">

                <div class="flex items-center gap-3 mb-3">
                    <div class="w-11 h-11 shrink-0 rounded-xl bg-primary flex items-center justify-center">
                        <img
                            src="{{ $aud['icon'] }}"
                            alt="{{ t($aud['title']) }}"
                            class="w-9 h-9 object-contain rounded-xl"
                        >
                    </div>

                    <h3 class="font-bold text-gray-900 text-sm">
                        {{ t($aud['title']) }}
                    </h3>
                </div>

                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ t($aud['desc']) }}
                </p>

            </div>
        @endforeach
    @endif
</div>
                                   </section>

                {{-- WHAT YOU'LL LEARN --}}
                @if($skills)
                <section id="learn" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
              @if($whyLearns)
                <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-emerald-500 to-cyan-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">{{ t('courseDetailX.whatYoullLearn') }}</h2>
                    </div>
                    @if($whyLearns)
                    <div class="grid sm:grid-cols-2 gap-3 mb-8">
                        
                        @foreach($whyLearns as $i => $whyLearn)
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all duration-200">
                                <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="h-3 w-3 text-emerald-600" {!! $iconStroke !!}><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $whyLearn ??'' }}</span>
                            </div>
                        @endforeach
                       
                    </div>
                     @endif
                    @endif
                    <div class="pt-6 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" {!! $iconStroke !!}><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                            {{ t('courseDetailX.toolsTechnologies') }}

                        </h3>
                        <div class="flex flex-wrap gap-2.5">
                            @if($skills)
                            @foreach($skills as $i => $skill)
                                <span class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border cursor-default {{ $skillColors[$i % count($skillColors)] }}">
                                    <svg class="h-3.5 w-3.5 shrink-0" {!! $iconStroke !!}><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    {{ $skillsT[$i] ?? $skill }}
                                </span>
                            @endforeach
                            @endif
                        </div>
                    </div>

                </section>

@endif

                @php
    $careerSupports = [
        [
            'title' => 'Mock Interview Session',
            'description' => 'Practice '.$course->title.' interview questions, case studies, and technical scenarios with expert feedback.',
            'image' => 'images/Mock_Session.webp',
            'alt' => 'Mock Session',
            'class' => 'lazyload20',
        ],
        [
            'title' => 'LMS Learning',
            'description' => 'Access '.$course->title.' recordings, '.$course->course_name.' exercises, datasets, assignments, and study materials anytime.',
            'image' => 'images/LMS_Learning.webp',
            'alt' => 'LMS Learning',
            'class' => 'for-animate lazyload20',
        ],
        [
            'title' => 'Career Support',
            'description' => 'Get resume preparation, LinkedIn optimization, interview guidance, and job-search assistance.',
            'image' => 'images/Career_Support.webp',
            'alt' => 'Career Support',
            'class' => 'lazyload20',
        ],
    ];
@endphp


<section class="w-full bg-white rounded-xl border shadow-sm p-6">

    <div class="flex items-center gap-3 mb-2">

        <svg xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="lucide lucide-trending-up w-5 h-5 text-primary"
            aria-hidden="true">

            <path d="M16 7h6v6"></path>
            <path d="m22 7-8.5 8.5-5-5L2 17"></path>

        </svg>

        <h2 class="text-xl font-bold text-[#272C37]">
            Career & Placement Support
        </h2>

    </div>

    <p class="text-gray-500 text-sm mb-1">
        Real professionals who accelerated their career growth and secured new opportunities with our Career & Placement Support.
    </p>


    <div class="max-w-7xl mx-auto px-4 py-5 my-5">

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-6">

            <div class="lg:w-2/3">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                    @foreach($careerSupports as $support)

                        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 p-6">

                            <div class="flex items-center gap-3 mb-3">

                                <div class="w-11 h-11 shrink-0 rounded-xl bg-primary flex items-center justify-center">

                                    <img
                                        src="{{ asset($support['image']) }}"
                                        alt="{{ $support['alt'] }}"
                                        class="{{ $support['class'] }} w-9 h-9 object-contain rounded-xl"
                                        loading="lazy"
                                    >

                                </div>

                                <h6 class="text-base font-bold text-gray-900">
                                    {{ $support['title'] }}
                                </h6>

                            </div>

                            <p class="text-sm text-gray-500 leading-relaxed">
                                {{ $support['description'] }}
                            </p>

                            <div class="absolute bottom-0 left-0 w-12 h-1 rounded-full bg-blue-600"></div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</section>


@php
    $avatarBg = [
        '0075EB',
        '272C37',
        '0075EB',
        '272C37',
        '0075EB',
        '272C37',
    ];
@endphp

    @if(!empty($placementStories))
<section id="placementSuccessStories"
    class="bg-white rounded-xl border shadow-sm p-6">

    <div class="flex items-center gap-3 mb-2">

        <svg xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="w-5 h-5 text-primary"
            aria-hidden="true">

            <path d="M16 7h6v6"></path>
            <path d="m22 7-8.5 8.5-5-5L2 17"></path>

        </svg>

        <h2 class="text-xl font-bold text-[#272C37]">
            Placement Success Stories
        </h2>

    </div>


    <p class="text-gray-500 text-sm mb-6">
        Real professionals who transformed their careers after completing this program.
    </p>


    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

        @if(!empty($placementStories))

            @foreach($placementStories as $story)

                @php
                    $name = trim($story['name'] ?? '');

                    $words = preg_split('/\s+/', $name);

                    $avatarName = '';

                    foreach (array_slice($words, 0, 2) as $word) {
                        if (!empty($word)) {
                            $avatarName .= strtoupper(substr($word, 0, 1));
                        }
                    }

                    $background = $avatarBg[
                        $loop->index % count($avatarBg)
                    ];
                @endphp


                <div class="border border-gray-100 rounded-xl p-5
                            hover:shadow-md hover:border-primary/20
                            transition-all">

                    {{-- User --}}
                    <div class="flex items-center gap-3 mb-4">

                        <span
                            class="w-12 h-12 shrink-0 rounded-full ring-2 ring-gray-100
                                   flex items-center justify-center
                                   text-white font-bold text-sm"
                            style="background-color: #{{ $background }};"
                        >
                            {{ $avatarName }}
                        </span>


                        <div>

                            <div class="font-bold text-[#272C37] text-sm">
                                {{ $story['name'] ?? '' }}
                            </div>

                            <div class="text-xs text-muted-foreground">
                                {{ $story['designation'] ?? '' }}
                            </div>

                        </div>

                    </div>


                    {{-- New Career --}}
                    <div class="space-y-2">

                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-3.5 h-3.5 text-primary flex-shrink-0"
                                aria-hidden="true">

                                <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                <rect width="20" height="14" x="2" y="6" rx="2"></rect>

                            </svg>

                            <span class="text-sm font-semibold text-[#272C37]">
                                {{ $story['coursename'] ?? '' }}
                            </span>

                        </div>


                        <div class="flex items-center gap-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-3.5 h-3.5 text-gray-400 flex-shrink-0"
                                aria-hidden="true">

                                <path d="M10 12h4"></path>
                                <path d="M10 8h4"></path>
                                <path d="M14 21v-3a2 2 0 0 0-4 0v3"></path>
                                <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"></path>
                                <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"></path>

                            </svg>

                            <span class="text-sm text-muted-foreground">
                                {{ $story['company_name'] ?? '' }}
                            </span>

                        </div>

                    </div>


                    {{-- Salary --}}
                    <div class="mt-4 pt-4 border-t flex items-center justify-between">

                        <span class="text-xs text-muted-foreground">
                            Salary Hike
                        </span>

                        <span class="text-sm font-extrabold text-green-600
                                     bg-green-50 px-2.5 py-0.5 rounded-full">

                            ↑ {{ $story['salary_hike'] ?? '0' }}%

                        </span>

                    </div>

                </div>

            @endforeach

        @endif

    </div>

</section>
@endif

@if($course->trainer_about)
<section id="aboutTrainer" class="w-full bg-gradient-to-b from-slate-50 via-white to-slate-50 py-2 md:py-2 overflow-hidden bg-white rounded-xl border shadow-sm p-2">
    <div class="max-w-7xl mx-auto px-2">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">

            {{-- Left: Trainer info card --}}
            <div
                x-data="{ shown: false }"
                x-intersect.once="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                class="lg:w-7/12 w-full transition-all duration-700 ease-out relative"
            >
                {{-- Ambient glow blobs --}}
                <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-400/25 rounded-full blur-3xl animate-pulse-slow pointer-events-none"></div>
                <div class="absolute -bottom-12 right-4 w-40 h-40 bg-indigo-400/20 rounded-full blur-3xl animate-pulse-slow pointer-events-none" style="animation-delay: 1.5s;"></div>

                {{-- Gradient border wrapper (creates a soft glowing edge) --}}
                <div class="relative rounded-[25px] p-[1.5px] bg-gradient-to-br from-blue-200 via-white to-indigo-200 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                    <div class="relative bg-white rounded-[25px] p-4 md:p-6
                                shadow-[0_1px_2px_rgba(16,24,40,0.04),0_4px_12px_rgba(16,24,40,0.06),0_20px_40px_-8px_rgba(37,99,235,0.10)]
                                hover:shadow-[0_2px_4px_rgba(16,24,40,0.05),0_12px_24px_rgba(16,24,40,0.08),0_32px_64px_-12px_rgba(37,99,235,0.22)]
                                hover:-translate-y-1.5
                                transition-all duration-500 ease-out">

                        {{-- Eyebrow badge --}}
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wide mb-4 shadow-[0_1px_2px_rgba(37,99,235,0.1)]">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Certified Expert
                        </span>

                        <h5 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                            Trainer Experience &amp; Expertise
                        </h5>

                        <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                            {!! $course->trainer_about !!}
                        </p>

                        <ul class="space-y-2">
                            @php
                                $trainerPoints = json_decode($course->trainer_paragraph); 
                            
                            @endphp

                            @foreach($trainerPoints as $i => $point)
                            <li
                                x-data="{ show: false }"
                                x-intersect.once="setTimeout(() => show = true, {{ $i * 90 }})"
                                :class="show ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-4'"
                                class="flex items-start gap-3 text-sm md:text-base text-gray-700 transition-all duration-500 ease-out group/item hover:bg-blue-50/70 rounded-[14px] px-3 py-2 -mx-3 cursor-default"
                            >
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mt-0.5 shadow-[0_2px_4px_rgba(37,99,235,0.15)] group-hover/item:bg-blue-600 group-hover/item:text-white group-hover/item:scale-110 group-hover/item:shadow-[0_4px_10px_rgba(37,99,235,0.35)] transition-all duration-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <span class="group-hover/item:text-gray-900 group-hover/item:font-medium transition-all duration-300">
                                    {{ $point }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endif

<div id="training-roadmap" class="bg-gray-100 border-2 m-2 p-3 rounded-xl border shadow-sm">

    {{-- Header --}}
    <div class="relative text-center mb-14">

        <span class="inline-flex items-center rounded-full bg-red-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#7f1d1d] mb-3">
            Your Learning Journey
        </span>

        <h2 class="text-[#7f1d1d] md:text-3xl text-2xl font-bold">Training Roadmap</h2>
        <svg class="mx-auto" width="340" height="6" viewBox="0 0 340 6" preserveAspectRatio="none">
            <path d="M0 3 Q170 0 340 3 Q170 6 0 3 Z" fill="#7f1d1d"></path>
        </svg>

        <p class="max-w-2xl mx-auto mt-3 text-sm md:text-base text-gray-500">
            A complete learning journey designed to build practical skills and prepare you for real-world opportunities.
        </p>

        <div class="flex justify-center mt-5">
            <div class="w-20 h-1 rounded-full bg-gradient-to-r from-red-800 to-red-500"></div>
        </div>

    </div>

    @php
        $roadmap = [
            ['num' => '01', 'color' => 'rgb(43, 166, 203)', 'title' => 'Industry Expert Trainer',   'desc' => 'Learn from an experienced professional with 10+ years of real-world industry expertise.'],
            ['num' => '02', 'color' => 'rgb(31, 167, 122)', 'title' => 'Updated Learning Resources',    'desc' => 'Get access to updated presentation decks, notes, and materials used during live training sessions.'],
            ['num' => '03', 'color' => 'rgb(228, 60, 60)',  'title' => 'Digital Study Material','desc' => 'Receive structured e-books and reference materials to support your learning throughout the course.'],
            ['num' => '04', 'color' => 'rgb(245, 158, 11)', 'title' => 'Practice & Assessments',      'desc' => 'Strengthen your knowledge with module-wise assignments, practice exercises, and MCQs.'],
            ['num' => '05', 'color' => 'rgb(99, 102, 241)', 'title' => 'Recorded Sessions',            'desc' => 'Access recorded training sessions anytime for revision, missed classes, and concept reinforcement.'],
            ['num' => '06', 'color' => 'rgb(16, 185, 129)', 'title' => 'Hands-On Projects',                   'desc' => 'Work on practical, real-world projects to apply your skills and gain valuable hands-on experience.'],
            ['num' => '07', 'color' => 'rgb(239, 68, 68)',  'title' => 'Professional Resume Support',            'desc' => 'Build an industry-ready resume with expert guidance focused on your skills, projects, and career goals.'],
            ['num' => '08', 'color' => 'rgb(139, 92, 246)', 'title' => 'Interview Preparation',      'desc' => 'Prepare confidently with mock interviews, practical scenarios, commonly asked questions, and expert feedback.'],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 justify-items-center">
        @foreach($roadmap as $step)

        <div class="relative w-[280px] bg-white rounded-[28px] shadow-[0_18px_35px_rgba(0,0,0,0.12)] pt-5 pb-8 px-6 flex items-center gap-3 cursor-pointer transition-all duration-300 ease-in-out hover:-translate-y-3 hover:scale-105 hover:shadow-[0_25px_45px_rgba(0,0,0,0.18)]">

            {{-- Number badge --}}
            <div class="absolute -top-8 left-1/2 -translate-x-1/2">
                <div class="relative text-white text-xl font-bold px-5 py-3 rounded-t-2xl"
                     style="background-color: {{ $step['color'] }};">

                    {{-- Pulse ring sits BEHIND the badge, badge itself never fades --}}
                    <span class="absolute inset-0 rounded-t-2xl animate-badge-pulse pointer-events-none -z-10"
                          style="background-color: {{ $step['color'] }};"></span>

                    <span class="relative z-10">{{ $step['num'] }}</span>

                    <div class="absolute left-1/2 -translate-x-1/2 top-full w-0 h-0"
                         style="border-left: 14px solid transparent; border-right: 14px solid transparent; border-top: 14px solid {{ $step['color'] }};">
                    </div>
                </div>
            </div>

            {{-- Vertical accent line --}}
            <div class="w-[2px] h-16 bg-red-200 shrink-0 mt-1"></div>

            {{-- Text --}}
            <div class="flex flex-col gap-3 flex-1 min-w-0 pt-1">
                <h3 class="font-bold text-[15px] text-gray-800 tracking-wide leading-snug">
                    {{ $step['title'] }}
                </h3>
                <p class="text-[13px] text-gray-500 leading-relaxed">
                    {{ $step['desc'] }}
                </p>
            </div>

        </div>
        @endforeach
    </div>

</div>

<style>
    @keyframes badge-pulse {
        0%   { opacity: 0.5; transform: scale(1); }
        70%  { opacity: 0;   transform: scale(1.6); }
        100% { opacity: 0;   transform: scale(1.6); }
    }
    .animate-badge-pulse {
        animation: badge-pulse 2.4s ease-out infinite;
    }
</style>

<section id="hiring-partners" class="scroll-mt-36 bg-white rounded-3xl border border-blue-900/40 shadow-xl p-4 sm:p-6 md:p-8 text-black">
    <div class="bg-[#272C37] rounded-2xl p-6 md:p-8">

        {{-- Header --}}
        <div class="flex items-center gap-2 mb-1">
            <svg class="w-5 h-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18"/>
                <path d="M5 21V7l8-4v18"/>
                <path d="M19 21V11l-6-4"/>
                <path d="M9 9v.01"/>
                <path d="M9 12v.01"/>
                <path d="M9 15v.01"/>
                <path d="M9 18v.01"/>
            </svg>
            <h2 class="text-black font-bold text-xl">Our Hiring Partners</h2>
        </div>
        <p class="text-black-400 text-sm mb-8">Top companies actively hire from our alumni network.</p>

        @php
            $partners = [
                ['name' => 'tata-group',    'partnerIcon' => asset('images/logos/tata-group.png')],
                ['name' => 'Cisco',         'partnerIcon' => asset('images/logos/cisco.svg')],
                ['name' => 'Deloitte',      'partnerIcon' => asset('images/logos/delote-logo.png')],
                ['name' => 'Accenture',     'partnerIcon' => asset('images/logos/accenture-logo.png')],
                ['name' => 'Wipro',         'partnerIcon' => asset('images/logos/wipro.svg')],
                ['name' => 'Ganpact',       'partnerIcon' => asset('images/logos/ganpact.webp')],
                ['name' => 'TCS',           'partnerIcon' => asset('images/logos/tcs.svg')],
                ['name' => 'Infosys',       'partnerIcon' => asset('images/logos/infosys.svg')],
                ['name' => 'sap',           'partnerIcon' => asset('images/logos/sap.svg')],
                ['name' => 'Motherson',     'partnerIcon' => asset('images/logos/motherson-logo.png')],
                ['name' => 'Tech Mahindra', 'partnerIcon' => asset('images/logos/tata-mahindra-logo.png')],
                ['name' => 'Samsung',       'partnerIcon' => asset('images/logos/samsung.svg')],
            ];
        @endphp

        {{-- Logo grid --}}
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 sm:gap-4 mb-8">
            @foreach($partners as $partner)
            <div class="group relative aspect-square bg-white rounded-2xl border border-white/10
                        flex items-center justify-center p-3
                        shadow-[0_4px_12px_rgba(0,0,0,0.15)]
                        hover:shadow-[0_8px_24px_rgba(59,130,246,0.35)]
                        hover:-translate-y-1 hover:border-blue-400/40
                        transition-all duration-300 ease-out overflow-hidden">

                <img
                    src="{{ $partner['partnerIcon'] }}"
                    alt="{{ $partner['name'] }}"
                    class="max-w-full max-h-full w-auto h-auto object-contain
                           grayscale opacity-70
                           group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110
                           transition-all duration-300 ease-out"
                    loading="lazy"
                >
            </div>
            @endforeach
        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-700 mb-6"></div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-blue-500 font-bold text-2xl sm:text-3xl">120+</div>
                <div class="text-gray-400 text-xs sm:text-sm mt-1">Hiring Partners</div>
            </div>
            <div>
                <div class="text-blue-500 font-bold text-2xl sm:text-3xl">85%</div>
                <div class="text-gray-400 text-xs sm:text-sm mt-1">Placement Rate</div>
            </div>
            <div>
                <div class="text-blue-500 font-bold text-2xl sm:text-3xl">₹12 LPA</div>
                <div class="text-gray-400 text-xs sm:text-sm mt-1">Avg. Salary Offered</div>
            </div>
        </div>

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
                                {{ t('courseDetailX.topicsCount', ['count' => $totalTopics]) }}
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
                <section class="scroll-mt-36 bg-gradient-to-br from-[#06102a] to-[#0c1f5c] rounded-3xl border border-blue-900/40 shadow-xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-amber-400 to-orange-500"></div>
                        <div>
                            <h2 class="text-2xl font-display font-bold text-white">Salary Range & Job Opportunities</h2>
                            <p class="text-sm text-white/50 mt-0.5">{{ t('courseDetailX.careerOutcomesDesc') }}</p>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4 mb-8">
                        @if($careerRoles)
                        @foreach($careerRoles as $cr)
                            <div class="bg-white/5 rounded-2xl border border-white/10 p-5 hover:bg-white/10 transition-all duration-300">
                                <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center mb-3">
                                    <svg class="h-5 w-5 text-primary" {!! $iconStroke !!}><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                </div>
                                <h3 class="font-bold text-white text-sm mb-1">{{ $cr['role'] }}</h3>
                                <p class="text-amber-400 font-semibold text-sm mb-3">{{ $cr['salary'] }}</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($cr['companies'] as $c)
                                        <span class="text-[10px] bg-white/10 text-white/60 px-2 py-0.5 rounded-full font-medium">{{ $c }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10">
                        @foreach([['value' => '87%', 'label' => t('courseDetailX.placementRate')], ['value' => '₹ 3.5L', 'label' => t('courseDetailX.avgSalaryHike')], ['value' => '45 days', 'label' => t('courseDetailX.avgTimeToHire')]] as $st)
                            <div class="text-center">
                                <p class="text-2xl font-extrabold text-white">{{ $st['value'] }}</p>
                                <p class="text-xs text-white mt-0.5">{{ $st['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>


                @if($course->course_defination)
<section  class="w-full bg-gradient-to-b from-slate-50 via-white to-slate-50 py-2 md:py-2 overflow-hidden bg-white rounded-xl border shadow-sm p-2">
    <div class="max-w-7xl mx-auto px-2">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">

            {{-- Left: Trainer info card --}}
            <div
                x-data="{ shown: false }"
                x-intersect.once="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                class="lg:w-7/12 w-full transition-all duration-700 ease-out relative"
            >
                {{-- Ambient glow blobs --}}
                <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-400/25 rounded-full blur-3xl animate-pulse-slow pointer-events-none"></div>
                <div class="absolute -bottom-12 right-4 w-40 h-40 bg-indigo-400/20 rounded-full blur-3xl animate-pulse-slow pointer-events-none" style="animation-delay: 1.5s;"></div>

                {{-- Gradient border wrapper (creates a soft glowing edge) --}}
                <div class="relative rounded-[25px] p-[1.5px] bg-gradient-to-br from-blue-200 via-white to-indigo-200 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                    <div class="relative bg-white rounded-[25px] p-4 md:p-6
                                shadow-[0_1px_2px_rgba(16,24,40,0.04),0_4px_12px_rgba(16,24,40,0.06),0_20px_40px_-8px_rgba(37,99,235,0.10)]
                                hover:shadow-[0_2px_4px_rgba(16,24,40,0.05),0_12px_24px_rgba(16,24,40,0.08),0_32px_64px_-12px_rgba(37,99,235,0.22)]
                                hover:-translate-y-1.5
                                transition-all duration-500 ease-out">


                        <h5 class="text-1xl md:text-2xl font-bold text-gray-900 mb-4 leading-tight">
                          Defination of  {{ $course->course_name??$course->title }}
                        </h5>

                        <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6">
                            {!! $course->course_defination !!}
                        </p>
                      
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endif

               @if($related_courses)
          <section id="related-course" class="scroll-mt-36 bg-white rounded-3xl border border-gray-100 shadow-sm p-4 sm:p-6 md:p-8">
  <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-gradient-to-b from-pink-500 to-violet-500"></div>
                        <h2 class="text-2xl font-display font-bold text-gray-900">Related Course</h2>
                    </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
@if($related_courses)
                 
    @foreach($related_courses as $relatedcourse)
        <a href="{{ route('courses.show', $relatedcourse) }}"
           class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:shadow-md hover:border-gray-200 transition-all duration-300">


            {{-- Text --}}
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2">
                    {{ ucwords(str_replace('-', ' ', $relatedcourse)) }}
                </h3>

                <div class="flex items-center gap-1 mt-1.5">
                    <div class="flex gap-0.5">
                        @php $rating = round(5 * 2) / 2; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($rating))
                                {{-- full star --}}
                                <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @elseif($i - 0.5 == $rating)
                                {{-- half star --}}
                                <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 24 24">
                                    <defs>
                                        <linearGradient id="half-{{ $i }}">
                                            <stop offset="50%" stop-color="currentColor"/>
                                            <stop offset="50%" stop-color="transparent"/>
                                        </linearGradient>
                                    </defs>
                                    <polygon fill="url(#half-{{ $i }})" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @else
                                {{-- empty star --}}
                                <svg class="w-3.5 h-3.5 fill-none text-gray-300" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500 font-medium ms-0.5">
                        {{ number_format(5, 1) }} ({{ number_format(454) }})
                    </span>
                </div>
            </div>
        </a>
    @endforeach

    @endif
</div>
</section>

@endif

@if($reviews)
                {{-- REVIEWS --}}
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
                            @if($ratingBars)
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
                            @endif
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

                         @endif

                {{-- CERTIFICATE --}}
                <section class="scroll-mt-36 bg-gradient-to-br from-violet-50 to-blue-50 rounded-3xl border border-violet-100 shadow-sm p-4 sm:p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="shrink-0 w-full max-w-[16rem] md:w-64 bg-white rounded-2xl border-2 border-violet-200 shadow-lg p-6 text-center">
                            <div class="text-4xl mb-2">🏆</div>
                            <p class="text-xs font-bold uppercase tracking-widest text-violet-400 mb-1">{{ t('courseDetailX.certificateOfCompletion') }}</p>
                            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $course->title }}</h4>
                            <p class="text-[11px] text-gray-400 mb-3">Corporate Academy</p>
                            <div class="h-px bg-violet-100 mb-3"></div>
                            <p class="text-[10px] text-gray-400 italic">{{ t('courseDetailX.awardedOnCompletion') }}</p>
                        </div>
                        <div>
                            <span class="inline-block bg-violet-100 text-violet-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest mb-3">{{ t('courseDetailX.industryRecognisedCertificate') }}</span>
                            <h2 class="text-2xl font-display font-bold text-gray-900 mb-3">{{ t('courseDetailX.earnYourCertificate') }}</h2>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5">{{ t('courseDetailX.earnYourCertificateDesc') }}</p>
                            <ul class="space-y-2">
                                @foreach([t('courseDetailX.certPtLinkedIn'), t('courseDetailX.certPtVerified'), t('courseDetailX.certPtCountries'), t('courseDetailX.certPtBadge')] as $pt)
                                    <li class="flex items-center gap-2.5 text-sm text-gray-700">
                                        <svg class="h-4 w-4 text-violet-500 shrink-0" {!! $iconStroke !!}><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        {{ $pt }}
                                    </li>
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

            {{-- SIDEBAR --}}
            <div class="space-y-5">
                <div class="sticky top-[130px] space-y-5">

                    {{-- Enrolment card --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/60 overflow-hidden">
                        <div class="bg-gradient-to-br from-[#06102a] to-[#0c1f5c] px-6 py-5">
                            <p class="text-lg font-bold text-white mb-1">{{ t('courseDetailX.enrolInProgramme') }}</p>
                            <p class="text-xs text-white/50">{{ t('courseDetailX.lifetimeAccessCert') }}</p>
                            <div class="mt-3 flex items-center gap-2 bg-amber-500/20 border border-amber-400/30 rounded-xl px-3 py-2">
                                <svg class="h-4 w-4 text-amber-400 shrink-0" {!! $iconStroke !!}><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <p class="text-xs text-amber-300 font-semibold">⚡ {{ t('courseDetailX.seatsLeftFor', ['count' => $batches[0]['seats'], 'date' => $batches[0]['date']]) }}</p>
                            </div>
                        </div>

                        <div class="px-6 pt-5 pb-2">
                            <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full h-12 text-base font-bold bg-primary text-white hover:bg-primary/90 rounded-xl shadow-md transition-all duration-300 hover:-translate-y-0.5 ring-2 ring-primary/20">
                                {{ t('courseDetail.enrollNow') }}
                                <svg class="ml-2 h-4 w-4" {!! $iconStroke !!}><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                            <p class="text-[11px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1">
                                <svg class="h-3 w-3 text-emerald-500" {!! $iconStroke !!}><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>
                                {{ t('courseDetailX.trustMoneyBack') }}
                            </p>
                        </div>

                        <div class="px-6 py-4 space-y-3 border-t border-gray-50">
                            @php
                                $newMode = implode(', ', json_decode($course->mode, true) ?? []);
                                $sidebarRows = [
                                    ['icon' => 'monitor', 'label' => t('courseDetailX.sidebarFormat'), 'value' => $newMode ],
                                    ['icon' => 'clock', 'label' => t('courseDetailX.sidebarDuration'), 'value' => t('courseDetailX.sidebarDurationValue', ['hours' => $course->duration_hours])],
                                    ['icon' => 'calendar', 'label' => t('courseDetailX.sidebarAccess'), 'value' => t('courseDetailX.lifetime')],
                                    ['icon' => 'award', 'label' => t('courseDetailX.sidebarCertificate'), 'value' => t('courseDetailX.sidebarCertificateValue')],
                                    ['icon' => 'globe', 'label' => t('courseDetailX.sidebarLanguage'), 'value' => t('courseDetailX.sidebarLanguageValue')],
                                    ['icon' => 'users', 'label' => t('courseDetailX.sidebarEnrolled'), 'value' => number_format($course->enrolled)],
                                ];
                            @endphp
                            @foreach($sidebarRows as $row)
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-gray-50 shrink-0">
                                        @switch($row['icon'])
                                            @case('monitor') <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><path d="m10 7 5 3-5 3Z"></path><rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M12 17v4"></path><path d="M8 21h8"></path></svg> @break
                                            @case('clock') <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> @break
                                            @case('calendar') <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> @break
                                            @case('award') <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg> @break
                                            @case('globe') <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> @break
                                            @default <svg class="h-4 w-4 text-gray-400" {!! $iconStroke !!}><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                        @endswitch
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $row['label'] }}</p>
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $row['value'] }} </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-6 pb-6 space-y-2 border-t border-dashed border-gray-100 pt-4">
                            <a href="/enquiry" class="inline-flex items-center justify-center w-full h-10 font-semibold border border-gray-200 hover:border-primary hover:text-primary rounded-xl text-sm">
                                <svg class="h-4 w-4 mr-2" {!! $iconStroke !!}><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                {{ t('courseDetailX.requestFreeCounselling') }}
                            </a>
                            <a href="/enquiry" class="inline-flex items-center justify-center w-full h-10 font-semibold text-gray-500 hover:text-primary rounded-xl text-sm">
                                <svg class="h-4 w-4 mr-2" {!! $iconStroke !!}><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                {{ t('courseDetailX.downloadBrochure') }}
                            </a>
                        </div>
                    </div>

                    {{-- Upcoming Batches --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" {!! $iconStroke !!}><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            {{ t('courseDetailX.upcomingBatches') }}
                        </h3>
                        <div class="space-y-2.5">
                            @if($batches)
                            @foreach($batches as $b)
                                <div class="flex items-center justify-between px-3 py-2.5 rounded-xl border text-sm {{ $b['color'] }}">
                                    <div>
                                        <p class="font-semibold">{{ $b['date'] }}</p>
                                        <p class="text-[11px] opacity-70">{{ t($b['labelKey']) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">{{ $b['seats'] }} {{ t('courseDetailX.seatsWord') }}</p>
                                        <p class="text-[11px] opacity-70">{{ t('courseDetailX.seatsLeftWord') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Quick Enquiry --}}
                    <div class="bg-gradient-to-br from-primary/5 to-violet-50 rounded-2xl border border-primary/10 p-5">
                        <h3 class="font-bold text-gray-900 text-sm mb-1 flex items-center gap-2">
                            <svg class="h-4 w-4 text-primary" {!! $iconStroke !!}><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            {{ t('courseDetailX.talkToCounsellor') }}

                        </h3>
                        <p class="text-xs text-gray-500 mb-4">{{ t('courseDetailX.personalisedRoadmap') }}


                        
                        </p>
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 font-semibold text-center">✓ {{ session('success') }}</div>
                        @else
                            <form method="POST" action="/courses/{{ $course->slug }}/enquiry" class="space-y-2.5">
                                @csrf
                                <input required name="name" placeholder="{{ t('courseDetailX.yourNamePlaceholder') }}" value="{{ old('name') }}" class="flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                @include('partials.phone-input', ['value' => old('phone'), 'inputClass' => 'flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary', 'selectClass' => 'border-gray-200 bg-white'])
                                <input required name="email" type="email" placeholder="{{ t('courseDetailX.emailAddressPlaceholder') }}" value="{{ old('email') }}" class="flex w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm h-10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                <button type="submit" class="w-full h-10 rounded-xl bg-primary text-white font-semibold text-sm">{{ t('courseDetailX.requestCallback') }} →</button>
                                @error('email') <p class="text-xs text-red-500 text-center">{{ t('courseDetailX.somethingWrong') }}</p> @enderror
                            </form>
                        @endif
                    </div>

                    {{-- Enterprise --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-violet-100 p-2 rounded-xl">
                                <svg class="h-4 w-4 text-violet-600" {!! $iconStroke !!}><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path></svg>
                            </div>
                            <p class="font-semibold text-gray-900 text-sm">{{ t('courseDetailX.trainingForTeams') }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ t('courseDetailX.trainingForTeamsDesc') }}</p>
                        <a href="/corporate-training" class="inline-flex items-center justify-center w-full h-9 text-sm font-semibold text-violet-700 border border-violet-200 hover:bg-violet-50 rounded-xl">
                            {{ t('courseDetailX.exploreCorporatePlans') }}
                            <svg class="w-3.5 h-3.5 ml-1" {!! $iconStroke !!}><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
