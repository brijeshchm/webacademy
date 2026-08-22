@props([
    'course',
    'title' => null,
])
@php
    // Per-category accent colours — ported verbatim from Courses.tsx CAT_COLORS.
    $catColors = [
        'data-science'       => ['from' => '#3b82f6', 'to' => '#6366f1', 'text' => 'text-indigo-600'],
        'ai'                 => ['from' => '#8b5cf6', 'to' => '#ec4899', 'text' => 'text-violet-600'],
        'machine-learning'   => ['from' => '#0ea5e9', 'to' => '#06b6d4', 'text' => 'text-sky-600'],
        'workday'            => ['from' => '#f59e0b', 'to' => '#f97316', 'text' => 'text-amber-600'],
        'servicenow'         => ['from' => '#10b981', 'to' => '#14b8a6', 'text' => 'text-emerald-600'],
        'salesforce'         => ['from' => '#0ea5e9', 'to' => '#3b82f6', 'text' => 'text-sky-600'],
        'microsoft-dynamics' => ['from' => '#6366f1', 'to' => '#8b5cf6', 'text' => 'text-indigo-600'],
        'oracle'             => ['from' => '#ef4444', 'to' => '#f97316', 'text' => 'text-red-600'],
    ];
    $col = $catColors[$course->category_slug] ?? ['from' => '#3b82f6', 'to' => '#6366f1', 'text' => 'text-indigo-600'];

    $levelKeys = [
        'Beginner'     => 'catalog.level.beginner',
        'Intermediate' => 'catalog.level.intermediate',
        'Advanced'     => 'catalog.level.advanced',
        'All Levels'   => 'catalog.level.allLevels',
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
    $catName = isset($categoryKeys[$course->category_name]) ? t($categoryKeys[$course->category_name]) : $course->category_name;
    $levelLabel = isset($levelKeys[$course->level]) ? t($levelKeys[$course->level]) : $course->level;
    $displayTitle = $title ?? $course->title;
@endphp
<a href="/courses/{{ $course->slug }}" class="block">
    <div class="group flex items-center gap-3 bg-white border border-gray-100 rounded-xl px-3 py-2.5 hover:border-primary/20 hover:shadow-sm transition-all duration-200 cursor-pointer">
        {{-- Color accent stripe --}}
        <div class="w-1 self-stretch rounded-full shrink-0" style="background: linear-gradient(180deg, {{ $col['from'] }}, {{ $col['to'] }});"></div>

        {{-- Icon --}}
        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: {{ $col['from'] }}15;">
            <x-category-icon :key="$course->category_slug" class="w-4 h-4" />
        </div>

        {{-- Main text --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-1.5 mb-0.5">
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $catName }}</span>
            </div>
            <h3 class="font-semibold text-[13px] text-gray-900 leading-tight line-clamp-1 group-hover:text-primary transition-colors">{{ $displayTitle }}</h3>
        </div>

        {{-- Meta chips — hidden on very small screens --}}
        <div class="hidden sm:flex items-center gap-2 shrink-0 text-[11px] text-gray-400">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>{{ $course->duration_hours }}h
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>{{ number_format($course->enrolled) }}
            </span>
            @if($course->rating > 0)
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>{{ number_format($course->rating, 1) }}
                </span>
            @endif
        </div>

        {{-- Level badge --}}
        <span class="hidden md:inline-flex items-center text-[10px] px-2 py-0.5 rounded-md border bg-gray-50 text-gray-500 border-gray-100 shadow-none shrink-0 font-semibold">{{ $levelLabel }}</span>

        {{-- Arrow --}}
        <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-primary group-hover:translate-x-0.5 transition-all shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </div>
</a>
