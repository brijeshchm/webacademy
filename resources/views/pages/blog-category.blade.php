@extends('layouts.app')
@section('title', 'Training & Career Insights Blog | Corporates Academy')
@section('description', 'Explore expert articles on IT training, certifications, career growth and interview preparation. Get practical learning tips from Corporates Academy.')

@section('meta_robots')
<meta name="robots" content="noindex, nofollow">
@endsection
@section('content')	
 
@php
 
$city = '';
@endphp
<style>
    .view-btn.active {
        background-color: #4f46e5;  /* indigo-600 */
        color: white;
        border-color: #4f46e5;
    }
    .view-btn.active svg {
        color: white;
    }
</style>
<div class="min-h-screen bg-slate-50">

    {{-- ════════════════════════════════
         PAGE HEADER
    ════════════════════════════════ --}}
    <div class="bg-slate-900 text-white py-12">
        <div class="container mx-auto px-4">
               <nav class="text-black text-xs sm:text-sm mb-1 flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                    <span>›</span>
                     
                    <a href="{{ route('blog')}}" class="hover:text-indigo-600">Blog</a>
                    <span>›</span>
                    
                    <span>{{ $blog_category->category }} </span>

                      
                </nav>
               
                         
            <p class="text-slate-300 text-lg"> </p>
        </div>
    </div>

    {{-- ════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════ --}}
    <div class="container mx-auto px-4 py-8">

        {{-- Search + Controls --}}
        <div class="flex flex-col md:flex-row gap-3 mb-6">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input id="course-search" type="text"
                       placeholder="Search courses or keywords..."
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white
                              outline-none text-sm transition-all"
                       autocomplete="off">
            </div>
            <div class="flex gap-2">
                <select id="sort-select"
                        class="px-3 py-3 border border-slate-200 rounded-xl bg-white text-sm
                               outline-none focus:border-indigo-400 text-slate-700">
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                </select>

                <button id="btn-grid"
                        class="view-btn active p-3 rounded-xl border border-slate-200 bg-white
                               text-slate-600 hover:border-indigo-300 transition-colors"
                        title="Grid view">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
                    </svg>
                </button>
                <button id="btn-list"
                        class="view-btn p-3 rounded-xl border border-slate-200 bg-white
                               text-slate-600 hover:border-indigo-300 transition-colors"
                        title="List view">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/>
                        <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/>
                        <line x1="3" y1="18" x2="3.01" y2="18"/>
                    </svg>
                </button>
                <button id="btn-filters-toggle"
                        class="md:hidden flex items-center gap-2 px-4 py-3 bg-white
                               border border-slate-200 rounded-xl text-sm text-slate-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/>
                        <line x1="10" y1="18" x2="14" y2="18"/>
                    </svg>
                    Filters
                </button>
            </div>
        </div>

        <div class="flex gap-8" id="layout-wrap">

            {{-- ── SIDEBAR FILTERS ── --}}
             

            {{-- ── COURSE LISTING ── --}}
            <div class="flex-1 min-w-0" id="course-area">

                <div class="flex items-center justify-between mb-5">
                    <p class="text-slate-600 text-sm">
                        <span id="result-count" class="font-bold text-slate-900">{{ count($blogs) }}</span>
                        courses found
                    </p>
                </div>

                {{-- GRID VIEW --}}
                <div id="grid-view"
                     class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                     @if($blogs)
                    @foreach($blogs as $i => $blog)
                    <div class="course-card reveal d-{{ min($i % 6, 5) }} bg-white border border-slate-200
                                rounded-xl overflow-hidden flex flex-col"
                         data-title="{{ $blog->title ?? '' }}"
                         data-name="{{ strtolower($blog->name ?? '') }}"
                         data-slug="{{ $blog->category_slug ?? '' }}"
                         data-rating="{{ $blog->rating ?? 0 }}"
                         data-count="{{ $blog->total_rating ?? 0 }}">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="block h-full flex flex-col">
                            {{-- Card image/header --}}
                            <div class="h-36 bg-gradient-to-br from-slate-100 to-indigo-50
                                        flex items-center justify-center p-5 relative overflow-hidden">
                                <div class="card-bg-overlay"></div>
                                <h3 class="font-bold text-lg text-slate-700 text-center leading-tight
                                           relative z-10 group-hover:text-indigo-700">
                                    {{$blog->title ?? '' }}
                                </h3>
                                <span class="absolute top-3 right-3 px-2 py-0.5 bg-white/90 text-indigo-700
                                             text-xs font-semibold rounded-full border border-indigo-100 shadow-sm">
                                    {{ $blog->name ?? '' }}
                                </span>
                            </div>

                            {{-- Card body --}}
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-slate-700 truncate">
                                        {{ $blog->title ?? '' }}
                                    </span>
                                    <div class="flex items-center gap-1 text-amber-500 flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span class="text-xs font-medium text-slate-700">
                                            {{ $blog->rating ?? '' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-3 text-xs text-slate-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                     

                                        {{ date('d, M Y', strtotime($blog->created_at)) ?? ''}}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                        </svg>
                                        Advance
                                    </span>
                                </div>
                                <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100">
                                    <span class="text-xs text-indigo-600 font-medium flex items-center gap-0.5 view-arrow">
                                        View Details
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                     @endforeach
                    @else
                    <div class="col-span-3 text-center py-16">
                        <p class="text-slate-500 text-lg font-medium">No blog available.</p>
                    </div>
                   @endif
                </div>

             

                {{-- Empty state --}}
                <div id="empty-state" class="hidden text-center py-16">
                    <p class="text-slate-500 text-lg font-medium">No blog match your filters.</p>
                    <p class="text-slate-400 text-sm mt-2">Try adjusting your search or filters.</p>
                </div>

            </div>
        </div>
    </div>
</div>

 
 
 <script>
(function () {

    /* ── IntersectionObserver reveals ── */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    /* ── State ── */
    let currentView   = 'grid';
    let selectedSlugs = new Set();
    let currentSort   = 'popular';
    let currentSearch = '';

    /* ── DOM refs ── */
    const searchInput = document.getElementById('course-search');
    const sortSelect  = document.getElementById('sort-select');
    const btnGrid     = document.getElementById('btn-grid');
    const btnList     = document.getElementById('btn-list');
    const btnClear    = document.getElementById('btn-clear');     // may not exist
    const btnFilters  = document.getElementById('btn-filters-toggle');
    const sidebar     = document.getElementById('sidebar-filters');
    const gridView    = document.getElementById('grid-view');
    // const listView    = document.getElementById('list-view');
    const emptyState  = document.getElementById('empty-state');
    const resultCount = document.getElementById('result-count');
    const layoutWrap  = document.getElementById('layout-wrap');

    /* ── All cards ── */
    const allGridCards = Array.from(gridView.querySelectorAll('[data-title]'));
    // const allListCards = Array.from(listView.querySelectorAll('[data-title]'));

    /* ────────────────────────────────────────────
       VIEW SWITCHER  ← main fix
       ──────────────────────────────────────────── */
    function setView(view) {
        currentView = view;

        if (view === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
        } else {
            listView.classList.remove('hidden');
            gridView.classList.add('hidden');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
        }

        applyFilters();
    }

    btnGrid.addEventListener('click', () => setView('grid'));
    btnList.addEventListener('click', () => setView('list'));

    /* ── Mobile filter toggle ── */
    btnFilters?.addEventListener('click', () => sidebar?.classList.toggle('open'));

    /* ── Search ── */
    searchInput.addEventListener('input', () => {
        currentSearch = searchInput.value.toLowerCase().trim();
        applyFilters();
    });

    /* ── Sort ── */
    sortSelect.addEventListener('change', () => {
        currentSort = sortSelect.value;
        applyFilters();
    });

    /* ── Checkbox filters (safe: only if they exist) ── */
    document.querySelectorAll('.child-filter').forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) selectedSlugs.add(cb.value);
            else selectedSlugs.delete(cb.value);

            btnClear?.classList.toggle('hidden', selectedSlugs.size === 0);
            applyFilters();
        });
    });

    /* ── Clear filters (safe) ── */
    btnClear?.addEventListener('click', () => {
        selectedSlugs.clear();
        document.querySelectorAll('.child-filter').forEach(cb => cb.checked = false);
        btnClear.classList.add('hidden');
        applyFilters();
    });

    /* ── Core filter + sort ── */
    function applyFilters() {
        const cards = currentView === 'grid' ? allGridCards : '';

        let visible = cards.filter(card => {
            const title = card.dataset.title || '';
            const name  = card.dataset.name  || '';
            const slug  = card.dataset.slug  || '';

            const matchSearch = !currentSearch ||
                title.includes(currentSearch) ||
                name.includes(currentSearch)  ||
                slug.includes(currentSearch);

            const matchCat = selectedSlugs.size === 0 || selectedSlugs.has(slug);

            return matchSearch && matchCat;
        });

        /* Sort */
        visible.sort((a, b) => {
            if (currentSort === 'popular') return Number(b.dataset.count)  - Number(a.dataset.count);
            if (currentSort === 'rating')  return Number(b.dataset.rating) - Number(a.dataset.rating);
            return 0;
        });

        /* Hide all, then show sorted visible ones */
        cards.forEach(c => c.style.display = 'none');
        const parent = currentView === 'grid' ? gridView : listView;

        visible.forEach(card => {
            card.style.display = '';
            parent.appendChild(card);
        });

        /* Empty state */
        emptyState.classList.toggle('hidden', visible.length > 0);
        resultCount.textContent = visible.length;

        /* Re-observe for reveal */
        visible.forEach(c => { c.classList.remove('visible'); io.observe(c); });
    }

    /* Initial render */
    applyFilters();

})();
</script>
<!--  
<script>
(function () {

    /* ── IntersectionObserver reveals ── */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    /* ── State ── */
    let currentView       = 'grid';
    let selectedSlugs     = new Set();
    let currentSort       = 'popular';
    let currentSearch     = '';

    /* ── DOM refs ── */
    const searchInput  = document.getElementById('course-search');
    const sortSelect   = document.getElementById('sort-select');
    const btnGrid      = document.getElementById('btn-grid');
    const btnList      = document.getElementById('btn-list');
    const btnClear     = document.getElementById('btn-clear');
    const btnFilters   = document.getElementById('btn-filters-toggle');
    const sidebar      = document.getElementById('sidebar-filters');
    const gridView     = document.getElementById('grid-view');
    const listView     = document.getElementById('list-view');
    const emptyState   = document.getElementById('empty-state');
    const resultCount  = document.getElementById('result-count');
    const layoutWrap   = document.getElementById('layout-wrap');

    /* ── All cards (both grid + list share same data-* attrs) ── */
    const allGridCards = Array.from(gridView.querySelectorAll('[data-title]'));
    const allListCards = Array.from(listView.querySelectorAll('[data-title]'));

    /* ── View toggle ── */
    btnGrid.addEventListener('click', () => {
        currentView = 'grid';
        btnGrid.classList.add('active');
        btnList.classList.remove('active');
        layoutWrap.classList.remove('list-active');
        applyFilters();
    });
    btnList.addEventListener('click', () => {
        currentView = 'list';
        btnList.classList.add('active');
        btnGrid.classList.remove('active');
        layoutWrap.classList.add('list-active');
        applyFilters();
    });

    /* ── Mobile filter toggle ── */
    btnFilters?.addEventListener('click', () => sidebar.classList.toggle('open'));

    /* ── Search ── */
    searchInput.addEventListener('input', () => {
        currentSearch = searchInput.value.toLowerCase().trim();
        applyFilters();
    });

    /* ── Sort ── */
    sortSelect.addEventListener('change', () => {
        currentSort = sortSelect.value;
        applyFilters();
    });

    /* ── Checkbox filters ── */
    document.querySelectorAll('.child-filter').forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) {
               
                selectedSlugs.add(cb.value);
            } else {
                selectedSlugs.delete(cb.value);
            }
            btnClear.classList.toggle('hidden', selectedSlugs.size === 0);
            applyFilters();
        });
    });

    /* ── Clear filters ── */
    btnClear.addEventListener('click', () => {
        selectedSlugs.clear();
        document.querySelectorAll('.child-filter').forEach(cb => cb.checked = false);
        btnClear.classList.add('hidden');
        applyFilters();
    });

    /* ── Core filter + sort function ── */
    function applyFilters() {
        console.log(selectedSlugs);
        const cards = currentView === 'grid' ? allGridCards : allListCards;
        const other = currentView === 'grid' ? allListCards : allGridCards;

        // Hide the inactive view's cards (so counts are consistent)
        other.forEach(c => c.style.display = 'none');

        let visible = cards.filter(card => {
 
            const title = card.dataset.title || '';
            const name  = card.dataset.name  || '';
            const slug  = card.dataset.slug  || '';
            // const child_slug  = card.dataset.child_slug  || '';

            const matchSearch = !currentSearch ||
                title.includes(currentSearch) ||
                name.includes(currentSearch)  ||
                slug.includes(currentSearch);

            const matchCat = selectedSlugs.size === 0 || selectedSlugs.has(slug);

            return matchSearch && matchCat;
        });

        /* Sort */
        visible.sort((a, b) => {
            if (currentSort === 'popular') return Number(b.dataset.count)  - Number(a.dataset.count);
            if (currentSort === 'rating')  return Number(b.dataset.rating) - Number(a.dataset.rating);
            return 0;
        });

        /* Re-render: hide all, then show sorted visible ones */
        cards.forEach(c => c.style.display = 'none');
        const parent = currentView === 'grid' ? gridView : listView;

        visible.forEach(card => {
            card.style.display = '';
            parent.appendChild(card); // moves to end = sorted order
        });

        /* Empty state */
        emptyState.classList.toggle('hidden', visible.length > 0);
        resultCount.textContent = visible.length;

        /* Re-observe new positions for reveal */
        visible.forEach(c => { c.classList.remove('visible'); io.observe(c); });
    }

})();
</script> -->
 
       
@endsection