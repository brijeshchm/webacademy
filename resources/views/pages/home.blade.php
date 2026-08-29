@extends('layouts.app')
@section('title', 'Professional Technology Training & Certification | Corporate Academy')
@section('description', 'Corporate Academy delivers expert-led tech training in Cloud, Data Science, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow and more. 490+ courses, 63,000+ professionals trained, globally recognized certifications')
@section('content')

@php
    $origin = rtrim(config('services.site.origin'), '/');
    $lang = app()->getLocale();

    // Dynamic DB strings are pre-translated in HomeController and passed as a
    // single "original => translated" lookup map. Views do plain array lookups
    // (no per-row translation queries).
    $tDyn = fn ($v) => $translations[$v] ?? $v;

    // ── Catalog label translations (mirrors src/lib/catalogTranslations.ts) ──
    $levelKeys = [
        'Beginner' => 'catalog.level.beginner',
        'Intermediate' => 'catalog.level.intermediate',
        'Advanced' => 'catalog.level.advanced',
        'Beginner to Intermediate' => 'catalog.level.beginnerToIntermediate',
        'Intermediate to Advanced' => 'catalog.level.intermediateToAdvanced',
        'Beginner to Advanced' => 'catalog.level.beginnerToAdvanced',
    ];
    $modeKeys = [
        'Live Online' => 'catalog.mode.liveOnline',
        'Live Online + Self-paced' => 'catalog.mode.liveOnlineSelfPaced',
        'Online Live + Self-Paced' => 'catalog.mode.liveOnlineSelfPaced',
        'Self-paced' => 'catalog.mode.selfPaced',
    ];
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
        'Blockchain' => 'catalog.category.blockchain',
        'Business Management' => 'catalog.category.businessManagement',
        'CompTIA' => 'catalog.category.compTIA',
        'Database' => 'catalog.category.database',
        'DevOps' => 'catalog.category.devOps',
        'Digital Marketing' => 'catalog.category.digitalMarketing',
        'Finance' => 'catalog.category.finance',
        'IT Security' => 'catalog.category.itSecurity',
        'IT Service Management' => 'catalog.category.itServiceManagement',
        'Medical Coding' => 'catalog.category.medicalCoding',
        'Other Professional Skills' => 'catalog.category.otherProfessionalSkills',
        'Programming' => 'catalog.category.programming',
        'Quality Management' => 'catalog.category.qualityManagement',
        'Risk Management' => 'catalog.category.riskManagement',
        'Soft Skills Training' => 'catalog.category.softSkillsTraining',
        'Software Development' => 'catalog.category.softwareDevelopment',
        'Software Testing' => 'catalog.category.softwareTesting',
        'BI & Visualization' => 'catalog.category.biVisualization',
    ];
    $tLevel = fn ($v) => isset($levelKeys[$v]) ? t($levelKeys[$v]) : $v;
    $tMode = fn ($v) => isset($modeKeys[$v]) ? t($modeKeys[$v]) : $v;
    $tCategory = fn ($v) => isset($categoryKeys[$v]) ? t($categoryKeys[$v]) : $v;

    // ── Category colour map (mirrors CAT_COLORS in Home.tsx) ──
    $catColors = [
        'data-science-ai'       => ['from' => '#3b82f6', 'to' => '#6366f1', 'shadow' => 'rgba(99,102,241,0.28)', 'dot' => '#6366f1'],
        'ai'                 => ['from' => '#8b5cf6', 'to' => '#ec4899', 'shadow' => 'rgba(139,92,246,0.28)', 'dot' => '#a855f7'],
        'machine-learning'   => ['from' => '#054a69', 'to' => '#1f8597', 'shadow' => 'rgba(6, 118, 170, 0.28)', 'dot' => '#1776a1'],
        'workday'            => ['from' => '#f59e0b', 'to' => '#f97316', 'shadow' => 'rgba(245,158,11,0.28)', 'dot' => '#f59e0b'],
        'servicenow'         => ['from' => '#10b981', 'to' => '#14b8a6', 'shadow' => 'rgba(16,185,129,0.28)', 'dot' => '#10b981'],
        'amazon-web-services(aws)'         => ['from' => '#10b981', 'to' => '#14b8a6', 'shadow' => 'rgba(16,185,129,0.28)', 'dot' => '#10b981'],
        'cloud-computing'         => ['from' => '#0edd3b', 'to' => '#c7fd03', 'shadow' => 'rgba(11, 165, 36, 0.28)', 'dot' => '#1c8b41'],
        'cyber-security'         => ['from' => '#3811a3', 'to' => '#0314fd', 'shadow' => 'rgba(45, 3, 80, 0.28)', 'dot' => '#2c0bc2'],
        'microsoft-dynamics' => ['from' => '#ce0c3d', 'to' => '#f65c5c', 'shadow' => 'rgba(241, 99, 99, 0.28)', 'dot' => '#f16363'],
        'oracle'             => ['from' => '#ef4444', 'to' => '#f97316', 'shadow' => 'rgba(239,68,68,0.28)', 'dot' => '#ef4444'],
        'salesforce'             => ['from' => '#831c1c', 'to' => '#915429', 'shadow' => 'rgba(136, 32, 32, 0.28)', 'dot' => '#ee0808'],
        'professional-programs'             => ['from' => '#831c1c', 'to' => '#915429', 'shadow' => 'rgba(136, 32, 32, 0.28)', 'dot' => '#ee0808'],
    ];
    $defaultCol = ['from' => '#3b82f6', 'to' => '#0609a7', 'shadow' => 'rgba(6, 10, 247, 0.28)', 'dot' => '#2a2c8b'];
    $getCol = fn ($slug) => $catColors[$slug] ?? $defaultCol;

    // ── Category icon paths (mirrors IconMap.getCategoryIcon, lucide) ──
    // For learning-path cards without an image we use the BookOpen fallback.

    // ── Alumni logo wall (verbatim from Home.tsx ALUMNI) ──
    $alumni = [
        ['name' => 'Apple', 'slug' => 'apple'], ['name' => 'Google', 'slug' => 'google'],
        ['name' => 'Google Cloud', 'slug' => 'googlecloud'], ['name' => 'NVIDIA', 'slug' => 'nvidia'],
        ['name' => 'Meta', 'slug' => 'meta'], ['name' => 'Tesla', 'slug' => 'tesla'],
        ['name' => 'Samsung', 'slug' => 'samsung'], ['name' => 'Netflix', 'slug' => 'netflix'],
        ['name' => 'Intel', 'slug' => 'intel'], ['name' => 'AMD', 'slug' => 'amd'],
        ['name' => 'SAP', 'slug' => 'sap'], ['name' => 'Accenture', 'slug' => 'accenture'],
        ['name' => 'Cisco', 'slug' => 'cisco'], ['name' => 'Qualcomm', 'slug' => 'qualcomm'],
        ['name' => 'Visa', 'slug' => 'visa'], ['name' => 'Mastercard', 'slug' => 'mastercard'],
        ['name' => 'PayPal', 'slug' => 'paypal'], ['name' => 'Stripe', 'slug' => 'stripe'],
        ['name' => 'Sony', 'slug' => 'sony'], ['name' => 'Siemens', 'slug' => 'siemens'],
        ['name' => 'Shell', 'slug' => 'shell'], ['name' => 'Volkswagen', 'slug' => 'volkswagen'],
        ['name' => 'HSBC', 'slug' => 'hsbc'], ['name' => 'Coca-Cola', 'slug' => 'cocacola'],
        ['name' => "McDonald's", 'slug' => 'mcdonalds'], ['name' => 'Unilever', 'slug' => 'unilever'],
        ['name' => 'Verizon', 'slug' => 'verizon'], ['name' => 'Dell', 'slug' => 'dell'],
        ['name' => 'HP', 'slug' => 'hp'], ['name' => 'Infosys', 'slug' => 'infosys'],
        ['name' => 'Wipro', 'slug' => 'wipro'], ['name' => 'TCS', 'slug' => 'tcs'],
        ['name' => 'Spotify', 'slug' => 'spotify'], ['name' => 'Airbnb', 'slug' => 'airbnb'],
        ['name' => 'Uber', 'slug' => 'uber'], ['name' => 'GitHub', 'slug' => 'github'],
        ['name' => 'GitLab', 'slug' => 'gitlab'], ['name' => 'Atlassian', 'slug' => 'atlassian'],
        ['name' => 'MongoDB', 'slug' => 'mongodb'], ['name' => 'Snowflake', 'slug' => 'snowflake'],
        ['name' => 'Databricks', 'slug' => 'databricks'], ['name' => 'VMware', 'slug' => 'vmware'],
        ['name' => 'Red Hat', 'slug' => 'redhat'], ['name' => 'Docker', 'slug' => 'docker'],
        ['name' => 'Kubernetes', 'slug' => 'kubernetes'], ['name' => 'Zoom', 'slug' => 'zoom'],
        ['name' => 'Datadog', 'slug' => 'datadog'], ['name' => 'Elastic', 'slug' => 'elastic'],
        ['name' => 'HashiCorp', 'slug' => 'hashicorp'], ['name' => 'Dropbox', 'slug' => 'dropbox'],
        ['name' => 'Cloudflare', 'slug' => 'cloudflare'], ['name' => 'DigitalOcean', 'slug' => 'digitalocean'],
        ['name' => 'Grafana', 'slug' => 'grafana'],
    ];
    $alumniHalf = (int) ceil(count($alumni) / 2);
    $alumniRows = [array_slice($alumni, 0, $alumniHalf), array_slice($alumni, $alumniHalf)];

    // ── Career journey steps (mirrors JOURNEY_STEPS / JOURNEY_COLORS) ──
    $journeySteps = [
        ['icon' => 'grad',      'titleKey' => 'home.step1Title', 'descKey' => 'home.step1Desc'],
        ['icon' => 'clipboard', 'titleKey' => 'home.step2Title', 'descKey' => 'home.step2Desc'],
        ['icon' => 'code',      'titleKey' => 'home.step3Title', 'descKey' => 'home.step3Desc'],
        ['icon' => 'messages',  'titleKey' => 'home.step4Title', 'descKey' => 'home.step4Desc'],
        ['icon' => 'file',      'titleKey' => 'home.step5Title', 'descKey' => 'home.step5Desc'],
        ['icon' => 'briefcase', 'titleKey' => 'home.step6Title', 'descKey' => 'home.step6Desc'],
    ];
    $journeyColors = [
        'from-rose-500 to-pink-600 shadow-rose-500/30',
        'from-blue-500 to-sky-500 shadow-blue-500/30',
        'from-emerald-500 to-teal-600 shadow-emerald-500/30',
        'from-cyan-500 to-sky-600 shadow-cyan-500/30',
        'from-indigo-500 to-blue-600 shadow-indigo-500/30',
        'from-violet-500 to-fuchsia-600 shadow-violet-500/30',
    ];

    // ── WhySection cards ──
    $whyCards = [
        ['icon' => 'grad',     'titleKey' => 'home.whyFeature1Title', 'descKey' => 'home.whyFeature1Desc', 'num' => '01', 'shadowColor' => 'rgba(244,63,94,0.18)', 'glowClass' => 'bg-rose-400/20', 'borderClass' => 'via-rose-400', 'gradientClass' => 'from-rose-500 to-pink-500', 'textAccent' => 'text-rose-600', 'borderColor' => 'border-rose-100', 'hoverBorder' => 'hover:border-rose-300'],
        ['icon' => 'rocket',   'titleKey' => 'home.whyFeature2Title', 'descKey' => 'home.whyFeature2Desc', 'num' => '02', 'shadowColor' => 'rgba(14,165,233,0.18)', 'glowClass' => 'bg-sky-400/20', 'borderClass' => 'via-sky-400', 'gradientClass' => 'from-sky-500 to-blue-500', 'textAccent' => 'text-sky-600', 'borderColor' => 'border-sky-100', 'hoverBorder' => 'hover:border-sky-300'],
        ['icon' => 'trending', 'titleKey' => 'home.whyFeature3Title', 'descKey' => 'home.whyFeature3Desc', 'num' => '03', 'shadowColor' => 'rgba(16,185,129,0.18)', 'glowClass' => 'bg-emerald-400/20', 'borderClass' => 'via-emerald-400', 'gradientClass' => 'from-emerald-500 to-teal-500', 'textAccent' => 'text-emerald-600', 'borderColor' => 'border-emerald-100', 'hoverBorder' => 'hover:border-emerald-300'],
        ['icon' => 'shield',   'titleKey' => 'home.whyFeature4Title', 'descKey' => 'home.whyFeature4Desc', 'num' => '04', 'shadowColor' => 'rgba(139,92,246,0.18)', 'glowClass' => 'bg-violet-400/20', 'borderClass' => 'via-violet-400', 'gradientClass' => 'from-violet-500 to-purple-500', 'textAccent' => 'text-violet-600', 'borderColor' => 'border-violet-100', 'hoverBorder' => 'hover:border-violet-300'],
    ];

    // ── GlobalImpact stat pins ──
    $impactPins = [
        ['left' => '17%', 'top' => '24%', 'count' => '30,161', 'name' => 'aisha-rahman','country'=>'United States'],
        ['left' => '29%', 'top' => '66%', 'count' => '8,430',  'name' => 'sofia-hernandez','country'=>'Brazil'],
        ['left' => '49%', 'top' => '16%', 'count' => '2,785',  'name' => 'priya-nair','country'=>'United Kingdom'],
        ['left' => '52%', 'top' => '52%', 'count' => '5,120',  'name' => 'marcus-lee','country'=>'South Africa'],
        ['left' => '71%', 'top' => '28%', 'count' => '18,940', 'name' => 'tom-becker','country'=>'India'],
        ['left' => '84%', 'top' => '70%', 'count' => '3,565',  'name' => 'marcus-lee','country'=>'Australia'],
    ];
    $impactDots = [
        ['left' => '20%', 'top' => '34%'], ['left' => '30%', 'top' => '72%'],
        ['left' => '50%', 'top' => '26%'], ['left' => '53%', 'top' => '58%'],
        ['left' => '70%', 'top' => '44%'], ['left' => '77%', 'top' => '34%'],
        ['left' => '86%', 'top' => '76%'],
    ];

    // ── Associations ──
    $associations = [
        ['name' => 'Ministry of Corporate Affairs', 'file' => 'mca.jpg'],
        ['name' => 'Ministry of MSME', 'file' => 'msme.webp'],
        ['name' => 'NSDC', 'file' => 'nsdc.webp'],
        ['name' => 'Skill India', 'file' => 'skill-india.svg'],
        ['name' => 'Digital India', 'file' => 'digital-india.webp'],
        ['name' => 'ISO 27001', 'file' => 'iso.webp'],
        ['name' => 'IAF', 'file' => 'iaf.webp'],
        ['name' => 'Microsoft', 'file' => 'microsoft.svg'],
        ['name' => 'IBM', 'file' => 'ibm.svg'],
        ['name' => 'Google Analytics', 'file' => 'google-analytics.webp'],
        ['name' => 'MeitY', 'file' => 'meity.jpg'],
        ['name' => 'National Career Service', 'file' => 'ncs.jpg'],
    ];

    // ── Video stories fallback (mirrors STATIC_VIDEOS) ──
    $staticVideos = [
        ['src' => '/videos/story1.mp4', 'label' => 'Data Science'],
        ['src' => '/videos/story2.mp4', 'label' => 'Cloud Computing'],
        ['src' => '/videos/story3.mp4', 'label' => 'Cloud Computing'],
        ['src' => '/videos/story4.mp4', 'label' => 'Agile & Scrum'],
        ['src' => '/videos/story5.mp4', 'label' => 'Machine Learning'],
        ['src' => '/videos/story6.mp4', 'label' => 'Enterprise Tech'],
        ['src' => '/videos/story7.mp4', 'label' => 'DevOps'],
    ];
    $thumbGradients = [
        'from-blue-600 via-indigo-600 to-primary',
        'from-cyan-600 via-sky-600 to-primary',
        'from-violet-600 via-purple-600 to-primary',
        'from-emerald-600 via-teal-600 to-primary',
        'from-fuchsia-600 via-pink-600 to-primary',
        'from-amber-600 via-orange-600 to-primary',
        'from-rose-600 via-red-600 to-primary',
    ];
    $videos = ($videoStories && count($videoStories))
        ? $videoStories->map(fn ($v) => ['src' => $v->video_data, 'label' => $v->label])->all()
        : $staticVideos;

    // ── Reviews aggregates ──
    $reviewAggregates = [
        ['name' => 'Google', 'rating' => '4.8', 'count' => '6,933', 'color' => '#4285F4'],
        ['name' => 'Facebook', 'rating' => '4.7', 'count' => '1,212', 'color' => '#1877F2'],
        ['name' => 'Switchup', 'rating' => '4.9', 'count' => '209', 'color' => '#ef4444'],
        ['name' => 'Course Report', 'rating' => '4.8', 'count' => '403', 'color' => '#f59e0b'],
    ];

    $hasWA = $whatsappChats && count($whatsappChats) > 0;
    $hasProofs = $proofs && count($proofs) > 0;
@endphp
@push('schema')
@php
       
   
        $canonical = $origin . '/';
        $ogImage = $origin . '/api/og-image';

        $orgJsonLd = [
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

        $websiteJsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $origin . '/#website',
            'url' => $origin,
            'name' => 'Corporate Academy',
            'description' => 'Expert-led technology training in Cloud, Data Science, DevOps, Cybersecurity, Salesforce, Workday, ServiceNow, and more.',
            'publisher' => ['@id' => $origin . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => $origin . '/courses?q={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
            'inLanguage' => 'en-IN',
        ];

        $faqJsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
            ], $faqsEn),
        ];

    @endphp
    <script type="application/ld+json">{!! json_ld($orgJsonLd) !!}</script>
    <script type="application/ld+json">{!! json_ld($websiteJsonLd) !!}</script>
    <script type="application/ld+json">{!! json_ld($faqJsonLd) !!}</script>
 @endpush
{{-- ── HERO ─────────────────────────────────────────────────── --}}
<section class="relative bg-[#060e24] pt-8 pb-10 md:pt-14 md:pb-16 border-b border-white/10 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:64px_64px]"></div>
        <div class="absolute -top-32 -left-32 w-[700px] h-[700px] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-[#7c3aed]/15 blur-[100px]"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    </div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Left: copy + search --}}
            <div class="text-center lg:text-start max-w-xl mx-auto lg:mx-0">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white/90 px-4 py-1.5 rounded-full text-xs font-semibold mb-5 border border-white/20 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                    </span>
                    {{ t('home.enrollmentOpen') }}
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tight text-white mb-4 leading-[1.08]">
                    {{ t('home.heroTitle') }}
                    <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-[#60a5fa] via-[#a78bfa] to-[#f472b6] ca-gradient-pan">Corporate Academy</span>
                </h1>
                <p class="text-base md:text-lg text-white/60 mb-6 leading-relaxed">{{ t('home.heroSubtitle') }}</p>

                {{-- Search box: GET /courses?search=... works without JS; JS enhances with autocomplete --}}
                <div class="relative mb-6 max-w-lg mx-auto lg:mx-0" data-hero-search>
                    <form action="{{ url('/courses') }}" method="GET" class="flex items-center gap-2 p-1.5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl shadow-black/30">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 rtl:left-auto rtl:right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <input
                                type="text"
                                name="search"
                                value=""
                                placeholder="{{ t('homeX.searchPlaceholder') }}"
                                aria-label="{{ t('courses.searchPlaceholder') }}"
                                role="combobox"
                                aria-expanded="false"
                                aria-autocomplete="list"
                                autocomplete="off"
                                data-hero-search-input
                                class="flex w-full rounded-md h-10 pl-10 rtl:pl-3 rtl:pr-10 border-0 bg-transparent shadow-none focus-visible:ring-0 focus-visible:outline-none text-base text-white placeholder:text-white/40"
                            >
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl h-10 px-5 shrink-0 shadow-md shadow-primary/20 bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium transition-transform duration-300 hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="h-4 w-4 sm:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <span class="hidden sm:inline">{{ t('home.search') }}</span>
                        </button>
                    </form>
                    {{-- Autocomplete suggestions rendered by app.js (fetch /api/courses?search=) --}}
                    <ul data-hero-suggestions class="hidden absolute z-50 left-0 right-0 top-full mt-2 max-h-72 overflow-y-auto overscroll-contain rounded-2xl border border-white/70 bg-white/95 backdrop-blur-xl shadow-xl shadow-primary/10 py-1.5 text-start [scrollbar-width:thin]"></ul>
                </div>

                <div class="flex flex-col sm:flex-row items-center lg:items-start gap-3 lg:justify-start justify-center">
                    <a href="{{ url('/courses') }}" class="w-full sm:w-auto inline-flex items-center justify-center h-12 px-8 text-sm font-semibold rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 shadow-xl shadow-primary/40 group transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 ring-2 ring-primary/30 ring-offset-2 ring-offset-transparent">
                        {{ t('home.explorePrograms') }}
                        <svg class="ms-2 w-4 h-4 group-hover:translate-x-1 transition-transform rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <a href="{{ url('/categories') }}" class="w-full sm:w-auto inline-flex items-center justify-center h-12 px-8 text-sm font-semibold rounded-xl border border-white/20 bg-white/10 text-white hover:bg-white/20 backdrop-blur-md">
                        {{ t('home.viewLearningPaths') }}
                    </a>
                </div>

                <div class="flex items-center gap-3 mt-6 justify-center lg:justify-start">
                    <div class="flex -space-x-3 rtl:space-x-reverse">
                        @foreach (['priya-nair', 'marcus-lee', 'sofia-hernandez', 'david-okoye'] as $a)
                            <img loading="lazy" decoding="async" src="/images/avatars/{{ $a }}.webp" alt="" class="w-10 h-10 rounded-full border-2 border-white/30 object-cover shadow-md">
                        @endforeach
                    </div>
                    <div class="text-start">
                        <div class="flex items-center gap-0.5">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <p class="text-xs text-white/50 mt-0.5">{{ t('home.trustedBy') }} jj</p>
                    </div>
                </div>
            </div>

            {{-- Right: floating image collage --}}
            <div class="relative hidden lg:block h-[460px]">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-[#7c3aed]/20 rounded-[3rem] blur-3xl"></div>

                <div class="absolute top-6 right-6 w-64 h-80 rounded-3xl overflow-hidden shadow-2xl shadow-primary/20 border-4 border-white ca-float-slow">
                    <a href="{{route('courses.show','six-sigma-training')}}">
                    <img loading="lazy" decoding="async" width="256" height="320" src="/images/courses/six-sigma.png" alt="" aria-hidden="true" class="w-full h-full object-cover">
                    <div class="absolute bottom-3 left-3 right-3 flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-xl px-3 py-2 shadow-md">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/15 text-primary shrink-0">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                        </span>
                        <span class="text-xs font-semibold text-foreground leading-tight">Six Sigma</span>
                    </div>
                    </a>
                </div>

                <div class="absolute top-0 left-0 w-44 h-56 rounded-3xl overflow-hidden shadow-xl shadow-secondary/20 border-4 border-white ca-float">
                     <a href="{{route('courses.show','workday-hcm-functional-course')}}">
                    <img loading="lazy" decoding="async" width="176" height="224" src="/images/courses/images-hcm.jpg" alt="" aria-hidden="true" class="w-full h-full object-cover">
                    <div class="absolute bottom-2 left-2 right-2 flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-xl px-2.5 py-1.5 shadow-md">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-secondary/20 text-secondary shrink-0">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                        </span>
                        <span class="text-[11px] font-semibold text-foreground leading-tight">Workday HCM</span>
                    </div>
                        </a>
                </div>
                <div class="absolute bottom-0 left-10 w-48 h-60 rounded-3xl overflow-hidden shadow-xl shadow-primary/20 border-4 border-white ca-float-slow">
                     <a href="{{route('courses.show','data-science-training')}}">
                    <img loading="lazy" decoding="async" width="192" height="240" src="/images/courses/data-science.png" alt="" aria-hidden="true" class="w-full h-full object-cover">
                    <div class="absolute bottom-2 left-2 right-2 flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-xl px-2.5 py-1.5 shadow-md">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-primary/15 text-primary shrink-0">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
                        </span>
                        <span class="text-[11px] font-semibold text-foreground leading-tight">Data Science</span>
                    </div>
                        </a>
                </div>
                <div class="absolute top-1/2 right-0 flex items-center justify-center w-14 h-14 rounded-2xl bg-white/70 backdrop-blur-md border border-white/70 shadow-lg text-primary ca-float">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                </div>
                <div class="absolute bottom-16 right-16 flex items-center justify-center w-12 h-12 rounded-2xl bg-white/70 backdrop-blur-md border border-white/70 shadow-lg text-secondary ca-float-slow">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── STATS BAR ────────────────────────────────────────────── --}}
<section class="py-10 bg-white border-b border-gray-100 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/5 via-transparent to-secondary/5 pointer-events-none"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="grid grid-cols-2 gap-y-8 md:flex md:flex-wrap md:justify-center md:divide-x md:divide-gray-100 text-center">
            @php
                $statCards = [
                    ['icon' => 'grad', 'value' => number_format($stats['careersTransformed'] / 1000, 0) . 'k+', 'label' => t('home.careersTransformed'), 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                    ['icon' => 'users', 'value' => number_format($stats['expertTrainers']) . '+', 'label' => t('home.industryExperts'), 'color' => 'text-violet-600', 'bg' => 'bg-violet-50'],
                    ['icon' => 'award', 'value' => '45+', 'label' => t('home.specializedPrograms'), 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
                    ['icon' => 'star', 'value' => number_format($stats['averageRating'], 1), 'label' => t('home.averageRating'), 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50'],
                ];
            @endphp
            @foreach ($statCards as $s)
                <div class="flex flex-col items-center gap-3 px-4 md:px-10 py-2 md:first:pl-0 md:last:pr-0">
                    <div class="w-11 h-11 rounded-2xl {{ $s['bg'] }} flex items-center justify-center">
                        @switch($s['icon'])
                            @case('grad')
                                <svg class="w-5 h-5 {{ $s['color'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                @break
                            @case('users')
                                <svg class="w-5 h-5 {{ $s['color'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                @break
                            @case('award')
                                <svg class="w-5 h-5 {{ $s['color'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                                @break
                            @default
                                <svg class="w-5 h-5 {{ $s['color'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endswitch
                    </div>
                    <div class="text-3xl md:text-4xl font-extrabold {{ $s['color'] }} leading-none">{{ $s['value'] }}</div>
                    <div class="text-sm text-gray-500 font-medium">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.home.global-impact')

{{-- ── CATEGORIES / LEARNING PATHS ─────────────────────────── --}}
<section class="py-24 bg-gray-50/60 relative">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(59,130,246,0.06),transparent_60%)] pointer-events-none"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="flex justify-between items-end mb-12">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                    {{ t('categories.learningPaths') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold mb-4 text-gray-900">{{ t('home.chooseYourPath') }}</h2>
                <p class="text-lg text-gray-500">{{ t('home.chooseYourPathDesc') }}</p>
            </div>
            <a href="{{ url('/categories') }}" class="hidden md:flex items-center gap-2 text-primary hover:text-primary/80 font-semibold whitespace-nowrap group bg-primary/5 px-5 py-2.5 rounded-xl hover:bg-primary/10 transition-colors">
                {{ t('home.viewAllPaths') }} hh
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Category tabs (JS filters via data-path-tab; without JS shows the "all" grid) --}}
        <div class="mb-10">
            <div class="flex flex-nowrap items-center gap-2 overflow-x-auto pb-1 -mx-4 px-4 md:mx-0 md:px-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-path-tabs>
                <button type="button" data-path-tab="all" aria-pressed="true" class="shrink-0 px-3.5 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-300 border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/50 focus-visible:ring-offset-2 bg-gradient-to-br from-primary to-secondary text-white border-transparent shadow-md shadow-primary/30">
                    {{ t('home.allCourses') }}
                </button>
                @php

                @endphp
                @foreach ($categories as $category)
                    <button type="button" data-path-tab="{{ $category->category_slug }}" aria-pressed="false" class="shrink-0 px-3.5 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-300 border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/50 focus-visible:ring-offset-2 bg-white/60 backdrop-blur-md text-muted-foreground border-white/70 hover:text-primary hover:border-primary/40">
                        {{ $tCategory($category->category_name) }}
                    </button>
                @endforeach
            </div>
        </div>
        @php
            // "all" shows first 6; each category slug shows first 6 (workday shows all).
            $pathGroups = [];
            $allSlice = $allCourses->take(6);

   
        @endphp

        @if ($allCourses->isEmpty())
            <p class="text-center text-muted-foreground py-16">{{ t('courses.noCoursesFound') }}</p>
        @else
            @foreach (array_merge(['all'], $categories->pluck('category_slug')->all()) as $pathSlug)
                @php
                    if ($pathSlug === 'all') {
                        $group = $allCourses->take(6);
                    } else {
                        $inPath = $allCourses->where('category_slug', $pathSlug)->values();
                        $group = $pathSlug === 'workday' ? $inPath : $inPath->take(6);
                    }

                @endphp
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 {{ $pathSlug === 'all' ? '' : 'hidden' }}"
                    data-path-panel="{{ $pathSlug }}"
                >
                    @forelse ($group as $course)
                        @php                                 
                        
                        $col = $getCol($course->category_slug);
                       
                         @endphp
                        <div class="h-full">
                            <a href="{{ route('courses.show',$course->slug) }}" class="block h-full">
                                <div class="group relative h-full flex flex-col rounded-2xl overflow-hidden bg-white border border-gray-100/80 shadow-sm cursor-pointer">
                                    <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-500" style="box-shadow: 0 12px 40px {{ $col['shadow'] }}"></div>
                                    <div class="relative h-36 overflow-hidden shrink-0">
                                        <div class="absolute top-0 inset-x-0 h-[3px] z-10" style="background: linear-gradient(90deg, {{ $col['from'] }}, {{ $col['to'] }})"></div>
                                        @if ($course->image_url)
                                            <img loading="lazy" decoding="async" src="{{ $course->image_url }}" alt="{{ $tDyn($course->title) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-600 ease-out">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center group-hover:scale-[1.06] transition-transform duration-600" style="background: linear-gradient(135deg, {{ $col['from'] }}, {{ $col['to'] }})">
                                                <svg class="h-12 w-12 opacity-30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/15 to-transparent"></div>
                                        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out bg-gradient-to-r from-transparent via-white/15 to-transparent pointer-events-none z-10"></div>
                                        @if ($course->featured)
                                            <span class="absolute top-3 left-3 rtl:left-auto rtl:right-3 z-20 inline-flex items-center rounded-md text-[10px] px-2 py-0.5 bg-gradient-to-br from-amber-400 to-orange-500 text-white border-0 shadow-sm font-semibold">{{ t('home.recommended') }}</span>
                                        @endif
                                        <span class="absolute top-3 right-3 rtl:right-auto rtl:left-3 z-20 inline-flex items-center rounded-md text-[10px] px-2 py-0.5 bg-white/90 backdrop-blur text-gray-700 border-0 shadow-sm font-semibold">{{ $tLevel($course->level) }}</span>
                                        <div class="absolute bottom-0 inset-x-0 z-10 px-3 py-2 flex items-center gap-3 text-white/85 text-[11px] font-medium">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                {{ $course->duration_hours }}h
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                                {{ number_format($course->enrolled) }}
                                            </span>
                                            @if ($course->rating > 0)
                                                <span class="flex items-center gap-1 ms-auto">
                                                    <svg class="w-3 h-3 fill-amber-400 text-amber-400 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                    {{ number_format($course->rating, 1) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col flex-1 p-4 pt-3.5">
                                        <div class="flex items-center gap-1.5 mb-2">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background: {{ $col['dot'] }}"></span>
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $tCategory($course->category_name) }}</span>
                                        </div>
                                        <h3 class="font-display font-bold text-[13px] leading-snug line-clamp-2 text-gray-900 group-hover:text-primary transition-colors duration-300 min-h-[2.5rem]">{{ $tDyn($course->title) }}</h3>
                                        <div class="mt-2.5">
                                            <span class="inline-flex items-center text-[10px] font-semibold px-2 py-0.5 rounded-full border" style="color: {{ $col['from'] }}; border-color: {{ $col['from'] }}30; background: {{ $col['from'] }}10">{{ implode(', ', json_decode($course->mode, true) ?? []) }}</span>
                                        </div>
                                        <div class="mt-auto pt-3 grid grid-cols-2 gap-2">
                                            <span class="inline-flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-700 text-xs px-2 py-1.5 font-medium">{{ t('home.viewCourse') }}</span>
                                            <span class="inline-flex items-center justify-center rounded-xl text-xs px-2 py-1.5 text-white font-medium" style="background: linear-gradient(135deg, {{ $col['from'] }}, {{ $col['to'] }})">{{ t('home.curriculum') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-muted-foreground py-16">{{ t('courses.noCoursesFound') }}</p>
                    @endforelse
                </div>
            @endforeach
        @endif





<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabsContainer = document.querySelector('[data-path-tabs]');
    if (!tabsContainer) return;

    const tabs = tabsContainer.querySelectorAll('[data-path-tab]');
    const panels = document.querySelectorAll('[data-path-panel]');

    tabsContainer.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-path-tab]');
        if (!btn) return;

        const targetSlug = btn.dataset.pathTab;

        // Toggle active tab styling + aria-pressed
        tabs.forEach(function (tab) {
            const isActive = tab === btn;
            tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            tab.classList.toggle('bg-gradient-to-br', isActive);
            tab.classList.toggle('from-primary', isActive);
            tab.classList.toggle('to-secondary', isActive);
            tab.classList.toggle('text-white', isActive);
            tab.classList.toggle('border-transparent', isActive);
            tab.classList.toggle('shadow-md', isActive);
            tab.classList.toggle('shadow-primary/30', isActive);

            tab.classList.toggle('bg-white/60', !isActive);
            tab.classList.toggle('backdrop-blur-md', !isActive);
            tab.classList.toggle('text-muted-foreground', !isActive);
            tab.classList.toggle('border-white/70', !isActive);
        });

        // Show only the matching panel
        panels.forEach(function (panel) {
            panel.classList.toggle('hidden', panel.dataset.pathPanel !== targetSlug);
        });
    });
});
</script>



        
    </div>
</section>

@include('partials.home.alumni', ['alumniRows' => $alumniRows, 'alumni' => $alumni])

{{-- ── FEATURED PROGRAMS ────────────────────────────────────── --}}
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(139,92,246,0.06),transparent_60%)] pointer-events-none"></div>
    <div class="absolute -top-20 -right-20 w-[400px] h-[400px] bg-primary/5 rounded-full blur-3xl pointer-events-none ca-float-slow"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="flex justify-between items-end mb-12">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 bg-violet-100 text-violet-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    {{ t('home.featuredBadge') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold mb-4 text-gray-900">{{ t('home.featuredPrograms') }}</h2>
                <p class="text-lg text-gray-500">{{ t('home.featuredProgramsDesc') }}</p>
            </div>
            <a href="{{ url('/courses') }}" class="hidden md:flex items-center gap-2 text-primary hover:text-primary/80 font-semibold whitespace-nowrap group bg-primary/5 px-5 py-2.5 rounded-xl hover:bg-primary/10 transition-colors">
                {{ t('home.viewAllPrograms') }}
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($featuredCourses->take(6) as $course)
                <div class="h-full">
                    <a href="{{ url('/courses/' . $course->slug) }}">
                        <div class="h-full hover:shadow-2xl transition-all duration-500 border border-white/60 bg-white/60 backdrop-blur-md hover:border-primary/40 cursor-pointer overflow-hidden group flex flex-col rounded-2xl shadow-sm">
                            <div class="h-48 bg-muted relative overflow-hidden">
                                @if ($course->image_url)
                                    <img loading="lazy" decoding="async" src="{{ $course->image_url }}" alt="{{ $tDyn($course->title) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                        <svg class="h-12 w-12 text-primary/40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <span class="absolute top-4 left-4 inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold bg-white/90 backdrop-blur-md text-foreground border border-white/50 shadow-sm">{{ $tCategory($course->category_name) }}</span>
                            </div>
                            <div class="flex flex-col space-y-1.5 p-6 flex-1 bg-transparent">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary border-none">{{ $tLevel($course->level) }}</span>
                                </div>
                                <h3 class="line-clamp-2 text-lg font-display leading-tight font-semibold">{{ $tDyn($course->title) }}</h3>
                                <p class="line-clamp-2 mt-2 text-sm text-muted-foreground">{{ $tDyn($course->summary) }}</p>
                            </div>
                            <div class="flex items-center justify-between text-sm text-muted-foreground p-6 pt-4 border-t border-white/50 mt-auto bg-white/30 backdrop-blur-sm">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-primary/60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $course->duration_hours }}h
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-500 fill-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    {{ number_format($course->rating, 1) }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-primary/60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    {{ number_format($course->enrolled) }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center md:hidden">
            <a href="{{ url('/courses') }}" class="inline-flex items-center justify-center w-full h-10 px-4 border border-input bg-white/50 backdrop-blur-md rounded-xl text-sm font-medium hover:bg-accent">{{ t('home.viewAllPrograms') }}</a>
        </div>
    </div>
</section>

@include('partials.home.why')

{{-- ── ABOUT / SKILLS CONSTELLATION ────────────────────────── --}}
<section class="py-8 md:py-10 relative overflow-hidden bg-gradient-to-br from-[hsl(217_45%_11%)] via-[hsl(220_40%_10%)] to-[hsl(224_50%_8%)] text-white">
    <div class="absolute -top-24 left-1/4 w-[360px] h-[360px] bg-primary/20 rounded-full blur-3xl pointer-events-none ca-float"></div>
    <div class="absolute bottom-0 right-0 w-[360px] h-[360px] bg-secondary/15 rounded-full blur-3xl pointer-events-none ca-float-slow"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_72%_28%,rgba(255,255,255,0.07),transparent_60%)] pointer-events-none"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-6 lg:gap-8 items-center">
            <div class="text-center lg:text-start">
                <span class="inline-flex items-center gap-1.5 bg-white/10 text-white px-3 py-1 rounded-full text-xs font-medium mb-3 border border-white/20 backdrop-blur-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    {{ t('home.aboutEyebrow') }}
                </span>
                <h2 class="text-2xl md:text-3xl font-display font-bold leading-[1.1] mb-2">
                    {{ t('home.aboutTitle1') }}
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary ca-gradient-pan">{{ t('home.aboutTitleAccent') }}</span>
                    {{ t('home.aboutTitle2') }}
                </h2>
                <p class="text-xs font-semibold uppercase tracking-wider text-primary mb-3">{{ t('home.aboutCategories') }}</p>
                <p class="text-sm text-white/65 leading-relaxed mb-4 max-w-xl mx-auto lg:mx-0">{{ t('home.aboutParagraph') }}</p>
                <ul class="space-y-1.5 mb-5 text-start inline-block">
                    @foreach ([t('home.aboutPoint1'), t('home.aboutPoint2'), t('home.aboutPoint3'), t('home.aboutPoint4')] as $p)
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
                            <span class="text-sm text-white/80">{{ $p }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex flex-col sm:flex-row items-center gap-3 lg:justify-start justify-center">
                    <a href="{{ route('contactUs') }}" class="w-full sm:w-auto inline-flex items-center justify-center h-10 px-6 rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 shadow-lg shadow-primary/25 text-sm font-medium transition-transform duration-300 hover:-translate-y-0.5 active:translate-y-0">{{ t('home.aboutBookDemo') }}</a>
                    <a href="{{ route('courses') }}" class="w-full sm:w-auto inline-flex items-center justify-center h-10 px-6 rounded-xl bg-white/5 border border-white/30 text-white hover:bg-white/15 hover:text-white backdrop-blur-md group text-sm font-medium">
                        {{ t('home.explorePrograms') }}
                        <svg class="ms-2 w-4 h-4 group-hover:translate-x-1 transition-transform rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            {{-- Skills constellation (static list — the animated globe is JS-only in React) --}}
            
            {{-- Skills constellation — CSS-only circular arrangement --}}
<div class="flex justify-center">
    <div class="relative aspect-square w-full max-w-[400px] rounded-full">

        <div class="absolute inset-0 rounded-full border border-white/10 bg-white/[0.02]"></div>
        <div class="absolute inset-[15%] rounded-full border border-white/10"></div>
        <div class="absolute inset-[35%] rounded-full border border-white/5"></div>

        @php
            $skills = $allCourses->take(18);
            $total  = $skills->count();
            $rings  = [
                ['radius' => 46, 'count' => 8],
                ['radius' => 30, 'count' => 6],
                ['radius' => 12, 'count' => 4],
            ];
            $flatIndex = 0;
        @endphp

        @foreach ($rings as $ring)
            @for ($i = 0; $i < $ring['count'] && $flatIndex < $total; $i++)
                @php
                    $course = $skills[$flatIndex];
                    $angle  = (360 / $ring['count']) * $i + ($ring['radius'] * 2);
                    $rad    = deg2rad($angle);
                    $x      = 50 + $ring['radius'] * cos($rad);
                    $y      = 50 + $ring['radius'] * sin($rad);
                    $delay  = $flatIndex * 0.15;
                    $flatIndex++;
                @endphp
                
                    <a href="{{ route('courses.show', $course->slug) }}"
                    class="absolute z-10 -translate-x-1/2 -translate-y-1/2 inline-flex items-center whitespace-nowrap rounded-full bg-white/8 border border-white/15 px-3 py-1 text-[11px] text-white/70 backdrop-blur-sm hover:bg-primary/20 hover:border-primary/40 hover:text-white transition-colors duration-300 ca-float"
                    style="left: {{ $x }}%; top: {{ $y }}%; animation-delay: {{ $delay }}s;"
                >
                    {{ $course->title }}
                </a>
            @endfor
        @endforeach

        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-secondary shadow-lg shadow-primary/30 ca-gradient-pan"></div>
        </div>
    </div>
</div>      
            
        </div>
    </div>
</section>

{{-- ── CAREER JOURNEY ──────────────────────────────────────── --}}
<section id="career-journey" class="relative overflow-hidden py-14 md:py-20 bg-gradient-to-b from-background via-primary/[0.04] to-background">
    <div class="pointer-events-none absolute -top-20 -left-20 w-80 h-80 rounded-full bg-primary/10 blur-3xl ca-float"></div>
    <div class="pointer-events-none absolute -bottom-20 -right-20 w-80 h-80 rounded-full bg-secondary/10 blur-3xl ca-float" style="animation-delay: -3.5s"></div>
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(0,0,0,0.03),transparent_55%)]"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-10 md:mb-14">
            <span class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-4 py-1.5 text-sm font-medium text-primary mb-4">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                {{ t('home.journeyEyebrow') }}
            </span>
            <h2 class="text-3xl md:text-4xl font-display font-bold leading-[1.1]">
                {{ t('home.journeyTitle') }}
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary ca-gradient-pan">{{ t('home.journeyTitleAccent') }}</span>
            </h2>
            <p class="mt-3 text-base text-muted-foreground">{{ t('home.journeySubtitle') }}</p>
        </div>
    </div>
    <div class="relative z-10 px-3 md:px-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            @foreach ($journeySteps as $i => $step)
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $journeyColors[$i] }} p-5 text-white shadow-lg transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl">
                    <span class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/30 to-transparent transition-transform duration-700 ease-out group-hover:translate-x-full"></span>
                    <span class="pointer-events-none absolute -top-10 -right-10 h-24 w-24 rounded-full bg-white/20 blur-2xl"></span>
                    <span class="pointer-events-none absolute -top-3 right-2 font-display text-6xl font-black leading-none text-white/15">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="relative z-[1] mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 ring-1 ring-white/40 backdrop-blur-sm transition-transform duration-300 group-hover:scale-110">
                        @switch($step['icon'])
                            @case('grad')
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                @break
                            @case('clipboard')
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                                @break
                            @case('code')
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                                @break
                            @case('messages')
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
                                @break
                            @case('file')
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        @endswitch
                    </div>
                    <h3 class="relative z-[1] font-display font-bold text-sm md:text-base mb-1 leading-tight">{{ t($step['titleKey']) }}</h3>
                    <p class="relative z-[1] text-xs text-white/85 leading-relaxed">{{ t($step['descKey']) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.home.social-proof', ['hasWA' => $hasWA, 'hasProofs' => $hasProofs, 'whatsappChats' => $whatsappChats, 'proofs' => $proofs])

@include('partials.home.video-stories', ['videos' => $videos, 'thumbGradients' => $thumbGradients])

@include('partials.home.reviews', ['testimonials' => $testimonials, 'reviewAggregates' => $reviewAggregates, 'translations' => $translations])

@include('partials.home.associations', ['associations' => $associations])

{{-- ── CTA / LEAD CAPTURE (newsletter) ─────────────────────── --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#060e24] via-[#0f1f5c] to-[#1e0a3c]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:56px_56px] pointer-events-none"></div>
    <div class="absolute -top-40 left-1/4 w-[600px] h-[600px] rounded-full bg-primary/25 blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 right-1/4 w-[500px] h-[500px] rounded-full bg-violet-500/20 blur-[100px] pointer-events-none"></div>
    <div class="px-4 md:px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 backdrop-blur-md rounded-full px-5 py-2 mb-8 text-white/80 text-sm font-semibold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                </span>
                {{ t('home.applicationsOpenNextCohort') }}
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-display font-extrabold mb-6 text-white leading-tight">{{ t('home.readyToTakeNextStep') }}</h2>
            <p class="text-lg text-white/60 mb-10 leading-relaxed max-w-2xl mx-auto">{{ t('home.readyDesc') }}</p>

            @if (session('success'))
                <div class="max-w-lg mx-auto mb-6 flex items-center justify-center gap-2 rounded-xl bg-green-500/15 border border-green-400/30 text-green-200 px-5 py-4 text-sm font-semibold">
                    <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>
                    {{ t('home.subscribedSuccessfully') }}
                </div>
            @else
                <form action="{{ route('leads.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto mb-6">
                    @csrf
                    <input type="hidden" name="name" value="Subscriber">
                    <input type="hidden" name="message" value="Newsletter signup">
                    <input
                        type="email"
                        name="email"
                        placeholder="{{ t('home.emailPlaceholder') }}"
                        class="flex w-full rounded-xl h-14 px-4 bg-white/10 backdrop-blur border border-white/20 text-white placeholder:text-white/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary shadow-inner"
                        required
                    >
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap h-14 px-8 shrink-0 bg-primary hover:bg-primary/90 text-white shadow-xl shadow-primary/30 rounded-xl font-semibold transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0">{{ t('home.getInformation') }}</button>
                </form>
                @error('email')
                    <p class="text-sm text-red-300 mb-4">{{ $message }}</p>
                @enderror
            @endif

            <div class="flex flex-wrap items-center justify-center gap-6 text-white/40 text-xs font-medium">
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> {{ t('homeX.noSpam') }}</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg> {{ t('homeX.freeCourseGuide') }}</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> {{ t('homeX.learnerSatisfaction') }}</span>
            </div>
        </div>
    </div>
</section>


<section class="py-20 bg-white"><div class="container mx-auto px-4 lg:px-8"><div class="flex items-end justify-between mb-10 max-w-6xl mx-auto flex-wrap gap-4"><div><span class="inline-block bg-primary/10 text-primary text-xs font-bold px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">From the Blog</span><h2 class="text-3xl md:text-4xl font-extrabold text-[#272C37]">Read Our <span class="text-primary">Latest Blogs</span></h2><p class="text-muted-foreground mt-2">Insights, tutorials, and career advice from industry experts.</p></div><a href="/blog/top-data-science-skills-2026"><button class="inline-flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all">View All Articles <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></a></div><div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto"><a href="/blog/top-data-science-skills-2026"><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-primary/25 transition-all group cursor-pointer flex flex-col h-full" style="opacity: 1; transform: none;"><div class="h-44 bg-gradient-to-br from-blue-500 to-indigo-600 relative flex items-center justify-center overflow-hidden flex-shrink-0"><div class="absolute -top-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div><div class="absolute -bottom-6 -left-4 w-24 h-24 bg-black/10 rounded-full"></div><div class="text-white text-7xl font-black opacity-15 select-none">DS</div><span class="absolute top-3 left-3 bg-white/95 text-[#272C37] text-xs font-bold px-2.5 py-1 rounded-lg">Data Science</span><span class="absolute top-3 right-3 bg-black/25 backdrop-blur border border-white/20 text-white text-[10px] font-semibold px-2 py-1 rounded-lg">7 min read</span></div><div class="p-5 flex flex-col flex-1"><div class="flex items-center gap-2 mb-3"><div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-black text-white text-[9px] flex-shrink-0">DS</div><div class="min-w-0"><p class="text-xs font-bold text-[#272C37] truncate">Priya Sharma</p><p class="text-[10px] text-gray-400 truncate">Sr. Data Scientist · Google</p></div></div><h3 class="font-bold text-[#272C37] text-base mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">Top 10 Data Science Skills You Need in 2026</h3><p class="text-sm text-gray-500 mb-4 leading-relaxed line-clamp-2 flex-1">From LLM engineering to causal inference, here's what hiring managers are screening for this year.</p><div class="flex items-center justify-between text-xs text-gray-400 border-t border-gray-100 pt-3"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 18, 2026</span><span class="flex items-center gap-1 text-primary font-bold group-hover:gap-2 transition-all">Read more <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3 h-3" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></div><div class="h-[3px] bg-gradient-to-br from-blue-500 to-indigo-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div></article></a><a href="/blog/aws-vs-azure-vs-gcp-2026"><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-primary/25 transition-all group cursor-pointer flex flex-col h-full" style="opacity: 1; transform: none;"><div class="h-44 bg-gradient-to-br from-orange-500 to-red-600 relative flex items-center justify-center overflow-hidden flex-shrink-0"><div class="absolute -top-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div><div class="absolute -bottom-6 -left-4 w-24 h-24 bg-black/10 rounded-full"></div><div class="text-white text-7xl font-black opacity-15 select-none">CL</div><span class="absolute top-3 left-3 bg-white/95 text-[#272C37] text-xs font-bold px-2.5 py-1 rounded-lg">Cloud</span><span class="absolute top-3 right-3 bg-black/25 backdrop-blur border border-white/20 text-white text-[10px] font-semibold px-2 py-1 rounded-lg">9 min read</span></div><div class="p-5 flex flex-col flex-1"><div class="flex items-center gap-2 mb-3"><div class="w-7 h-7 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center font-black text-white text-[9px] flex-shrink-0">CL</div><div class="min-w-0"><p class="text-xs font-bold text-[#272C37] truncate">Rahul Mehta</p><p class="text-[10px] text-gray-400 truncate">Cloud Architect · Amazon</p></div></div><h3 class="font-bold text-[#272C37] text-base mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">AWS vs Azure vs GCP: A 2026 Career Roadmap</h3><p class="text-sm text-gray-500 mb-4 leading-relaxed line-clamp-2 flex-1">Which cloud certification pays the most, hires the fastest, and future-proofs your role? Full breakdown.</p><div class="flex items-center justify-between text-xs text-gray-400 border-t border-gray-100 pt-3"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 14, 2026</span><span class="flex items-center gap-1 text-primary font-bold group-hover:gap-2 transition-all">Read more <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3 h-3" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></div><div class="h-[3px] bg-gradient-to-br from-orange-500 to-red-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div></article></a><a href="/blog/crack-faang-interviews-90-days"><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-primary/25 transition-all group cursor-pointer flex flex-col h-full" style="opacity: 1; transform: none;"><div class="h-44 bg-gradient-to-br from-emerald-500 to-teal-600 relative flex items-center justify-center overflow-hidden flex-shrink-0"><div class="absolute -top-6 -right-6 w-28 h-28 bg-white/10 rounded-full"></div><div class="absolute -bottom-6 -left-4 w-24 h-24 bg-black/10 rounded-full"></div><div class="text-white text-7xl font-black opacity-15 select-none">CR</div><span class="absolute top-3 left-3 bg-white/95 text-[#272C37] text-xs font-bold px-2.5 py-1 rounded-lg">Career</span><span class="absolute top-3 right-3 bg-black/25 backdrop-blur border border-white/20 text-white text-[10px] font-semibold px-2 py-1 rounded-lg">12 min read</span></div><div class="p-5 flex flex-col flex-1"><div class="flex items-center gap-2 mb-3"><div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center font-black text-white text-[9px] flex-shrink-0">CR</div><div class="min-w-0"><p class="text-xs font-bold text-[#272C37] truncate">Anjali Verma</p><p class="text-[10px] text-gray-400 truncate">Software Engineer · Meta</p></div></div><h3 class="font-bold text-[#272C37] text-base mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">How to Crack Tech Interviews at FAANG in 90 Days</h3><p class="text-sm text-gray-500 mb-4 leading-relaxed line-clamp-2 flex-1">A week-by-week plan from engineers who've cleared Google, Amazon, and Meta interviews.</p><div class="flex items-center justify-between text-xs text-gray-400 border-t border-gray-100 pt-3"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 10, 2026</span><span class="flex items-center gap-1 text-primary font-bold group-hover:gap-2 transition-all">Read more <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3 h-3" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></div><div class="h-[3px] bg-gradient-to-br from-emerald-500 to-teal-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div></article></a></div></div></section>



    <section class="py-20 bg-gradient-to-b from-gray-50 to-white"><div class="container mx-auto px-4 lg:px-8"><div class="text-center mb-12" style="opacity: 1; transform: none;"><span class="inline-block bg-primary/10 text-primary text-xs font-bold px-3 py-1.5 rounded-full mb-3 uppercase tracking-wider">In the Press</span><h2 class="text-3xl md:text-4xl font-extrabold text-[#272C37] mb-3">News <span class="text-primary">Highlights</span></h2><p class="text-muted-foreground max-w-2xl mx-auto">What top publications are saying about TrailFuture.</p></div><div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto"><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all group cursor-pointer flex flex-col" style="opacity: 1; transform: none;"><div class="h-48 bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500 relative overflow-hidden"><div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, white 1px, transparent 1px), radial-gradient(circle at 80% 70%, white 1.5px, transparent 1.5px); background-size: 30px 30px, 50px 50px;"></div><div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div><div class="absolute -bottom-10 -left-10 w-44 h-44 bg-black/10 rounded-full blur-2xl"></div><div class="absolute top-4 left-4 bg-white/95 backdrop-blur text-[#272C37] text-xs font-extrabold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper w-3 h-3 text-primary" aria-hidden="true"><path d="M15 18h-5"></path><path d="M18 14h-8"></path><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"></path><rect width="8" height="4" x="10" y="6" rx="1"></rect></svg>Forbes</div><div class="absolute bottom-4 left-4 text-white"><div class="text-4xl font-black leading-none drop-shadow">4M+</div><div class="text-xs uppercase tracking-widest opacity-90 mt-1">Learners</div></div><div class="absolute top-1/2 right-6 -translate-y-1/2 w-16 h-16 bg-white/15 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20" style="transform: translateY(-6.13697px);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-8 h-8 text-white" aria-hidden="true"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg></div></div><div class="p-6 flex-1 flex flex-col"><div class="flex items-center justify-between text-[11px] text-gray-500 mb-3 uppercase tracking-wider"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 22, 2026</span><span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-3 h-3" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>12.4K</span></div><h3 class="font-bold text-[#272C37] text-lg mb-3 leading-snug group-hover:text-primary transition-colors flex-1">TrailFuture Crosses 4 Million Learners Globally, Expands Into Generative AI Programs</h3><p class="text-sm text-muted-foreground leading-relaxed mb-4 line-clamp-3">The bootcamp leader announced a major curriculum overhaul focused on LLMs, RAG, and agentic AI workflows for working professionals.</p><span class="text-primary text-sm font-bold inline-flex items-center gap-1.5 group-hover:gap-2 transition-all border-t pt-3">Read full story <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></article><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all group cursor-pointer flex flex-col" style="opacity: 1; transform: none;"><div class="h-48 bg-gradient-to-br from-orange-500 via-rose-500 to-pink-600 relative overflow-hidden"><div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, white 1px, transparent 1px), radial-gradient(circle at 80% 70%, white 1.5px, transparent 1.5px); background-size: 30px 30px, 50px 50px;"></div><div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div><div class="absolute -bottom-10 -left-10 w-44 h-44 bg-black/10 rounded-full blur-2xl"></div><div class="absolute top-4 left-4 bg-white/95 backdrop-blur text-[#272C37] text-xs font-extrabold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper w-3 h-3 text-primary" aria-hidden="true"><path d="M15 18h-5"></path><path d="M18 14h-8"></path><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"></path><rect width="8" height="4" x="10" y="6" rx="1"></rect></svg>Economic Times</div><div class="absolute bottom-4 left-4 text-white"><div class="text-4xl font-black leading-none drop-shadow">IIT-K</div><div class="text-xs uppercase tracking-widest opacity-90 mt-1">Partner</div></div><div class="absolute top-1/2 right-6 -translate-y-1/2 w-16 h-16 bg-white/15 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20" style="transform: translateY(-2.64444px);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap w-8 h-8 text-white" aria-hidden="true"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg></div></div><div class="p-6 flex-1 flex flex-col"><div class="flex items-center justify-between text-[11px] text-gray-500 mb-3 uppercase tracking-wider"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 16, 2026</span><span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-3 h-3" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>8.9K</span></div><h3 class="font-bold text-[#272C37] text-lg mb-3 leading-snug group-hover:text-primary transition-colors flex-1">TrailFuture Partners With IIT Kanpur for New AI &amp; Robotics Bootcamp</h3><p class="text-sm text-muted-foreground leading-relaxed mb-4 line-clamp-3">Joint program offers 9-month bootcamp with industry capstones, IIT certification, and guaranteed interviews with 200+ partners.</p><span class="text-primary text-sm font-bold inline-flex items-center gap-1.5 group-hover:gap-2 transition-all border-t pt-3">Read full story <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></article><article class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all group cursor-pointer flex flex-col" style="opacity: 1; transform: none;"><div class="h-48 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 relative overflow-hidden"><div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, white 1px, transparent 1px), radial-gradient(circle at 80% 70%, white 1.5px, transparent 1.5px); background-size: 30px 30px, 50px 50px;"></div><div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div><div class="absolute -bottom-10 -left-10 w-44 h-44 bg-black/10 rounded-full blur-2xl"></div><div class="absolute top-4 left-4 bg-white/95 backdrop-blur text-[#272C37] text-xs font-extrabold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper w-3 h-3 text-primary" aria-hidden="true"><path d="M15 18h-5"></path><path d="M18 14h-8"></path><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"></path><rect width="8" height="4" x="10" y="6" rx="1"></rect></svg>TechCrunch</div><div class="absolute bottom-4 left-4 text-white"><div class="text-4xl font-black leading-none drop-shadow">AI</div><div class="text-xs uppercase tracking-widest opacity-90 mt-1">Coach</div></div><div class="absolute top-1/2 right-6 -translate-y-1/2 w-16 h-16 bg-white/15 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20" style="transform: translateY(-0.281203px);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-8 h-8 text-white" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg></div></div><div class="p-6 flex-1 flex flex-col"><div class="flex items-center justify-between text-[11px] text-gray-500 mb-3 uppercase tracking-wider"><span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar w-3 h-3" aria-hidden="true"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Apr 09, 2026</span><span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-3 h-3" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>15.2K</span></div><h3 class="font-bold text-[#272C37] text-lg mb-3 leading-snug group-hover:text-primary transition-colors flex-1">How TrailFuture's AI-Powered Career Coach Is Reshaping Online Learning</h3><p class="text-sm text-muted-foreground leading-relaxed mb-4 line-clamp-3">The new AI coach personalizes learning paths, predicts skill gaps, and matches learners to roles in real-time across the platform.</p><span class="text-primary text-sm font-bold inline-flex items-center gap-1.5 group-hover:gap-2 transition-all border-t pt-3">Read full story <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></span></div></article></div></div></section>

{{-- ── FAQ ─────────────────────────────────────────────────── --}}
@if (count($faqs))
<section class="py-16 md:py-20 bg-white">
    <div class="mx-auto max-w-4xl px-4 md:px-6">
        <h2 class="text-2xl md:text-3xl font-display font-extrabold text-foreground mb-2">{{ t('faq.home.title') }}</h2>
        <p class="text-sm text-muted-foreground mb-8">{{ t('faq.home.subtitle') }}</p>
        <div class="flex flex-col gap-3">
            @foreach ($faqs as $f)
                <details class="group border rounded-xl overflow-hidden transition-colors border-gray-100 bg-white open:border-primary/30 open:bg-primary/[0.02]" data-accordion>
                    <summary class="w-full flex items-center justify-between px-5 py-4 text-start gap-3 cursor-pointer list-none">
                        <span class="text-sm font-bold text-foreground leading-snug">{{ $f['question'] }}</span>
                        <svg class="h-4 w-4 text-muted-foreground shrink-0 group-open:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        <svg class="h-4 w-4 text-primary shrink-0 hidden group-open:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                    </summary>
                    <div class="px-5 pb-4">
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ $f['answer'] }}</p>
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
