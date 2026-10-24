@extends('layouts.app')
@section('title','Professional Training Courses & Certification Programs')
@section('description', 'Explore professional courses in Workday, AWS, Artificial Intelligence, Data Science, Salesforce, Python, ServiceNow and other career-focused technologies.')
@php
    use App\Support\JsonLd;

    // $coursesFaqs (English source translated via the controller's shared
    // lookup map) is passed in from CoursesController@index.
    $ld = [JsonLd::faq($coursesFaqs)];
    if (count($courses)) {
        $ld[] = JsonLd::courseList($courses);
    }

    // Category label translation map (same keys as catalogTranslations tCategory).
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
    $tCat = fn ($name) => isset($categoryKeys[$name]) ? t($categoryKeys[$name]) : $name;
@endphp


@push('schema')
        @if($ld)
        @foreach($ld as $schema)
            <script type="application/ld+json">{!! json_ld($schema) !!}</script>
        @endforeach
        @endif
@endpush
@section('meta_robots')
<meta name="robots" content="noindex, nofollow">
@endsection
@section('content')
<div class="py-12 bg-background min-h-screen relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-3xl pointer-events-none ca-float"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary/5 rounded-full blur-3xl pointer-events-none ca-float-slow"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="mb-12">
            <h1 class="text-4xl font-display font-bold mb-4">{{ t('courses.courseCatalog') }}</h1>
            <p class="text-muted-foreground text-lg max-w-2xl">{{ t('courses.catalogDesc') }}</p>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Filters Sidebar --}}
            <div class="w-full md:w-64 shrink-0 space-y-6">
                <form method="GET" action="{{ route('courses') }}" class="space-y-4 bg-white/40 backdrop-blur-md border border-white/60 p-6 rounded-2xl shadow-sm">
                    @if($category !== '')
                        <input type="hidden" name="category" value="{{ $category }}">
                    @endif
                    <div class="relative">
                        <svg class="absolute left-3 rtl:left-auto rtl:right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="{{ t('courses.searchPlaceholder') }}"
                            class="flex h-10 w-full rounded-xl border border-white/50 bg-white/50 backdrop-blur px-3 py-2 text-sm pl-9 rtl:pl-3 rtl:pr-9 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                        >
                    </div>
                    <div>

                      <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl h-10 px-5 shrink-0 shadow-md shadow-primary/20 bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium transition-transform duration-300 hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="h-4 w-4 sm:hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <span class="hidden sm:inline">{{ t('home.search') }}</span>
                        </button>
                        
                        
                    </div>
                </form>
            </div>

            {{-- Course Grid --}}
            <div class="flex-1">
                @if(count($courses) === 0)
                    <div class="text-center py-20 bg-white/40 backdrop-blur-md rounded-2xl border border-dashed border-primary/20">
                        <p class="text-lg text-muted-foreground">{{ t('courses.noCoursesFound') }}</p>
                        <a
                            href="{{ route('courses') }}"
                            class="mt-4 inline-block text-primary font-medium hover:underline bg-white/50 px-4 py-2 rounded-xl border border-white/80 transition-all hover:bg-white/80"
                        >
                            {{ t('courses.clearFilters') }}
                        </a>
                    </div>
                @else
                    <div class="flex flex-col gap-2">
                        @foreach($courses as $course)
                            <x-course-card :course="$course" :title="$translatedTitles[$course->id] ?? $course->title" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- FAQ --}}
        <x-faq-section
            :title="t('faq.courses.title')"
            :subtitle="t('faq.courses.subtitle')"
            :faqs="$coursesFaqs"
            class="!bg-transparent"
        />
    </div>
</div>
@endsection
