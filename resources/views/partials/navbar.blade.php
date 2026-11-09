@php
    $current = request()->path();
    $activeLng = app()->getLocale();
    $languages = [
        ['code' => 'en', 'name' => 'English'],
        ['code' => 'hi', 'name' => 'हिन्दी'],
        ['code' => 'zh', 'name' => '中文'],
        ['code' => 'fr', 'name' => 'Français'],
        ['code' => 'es', 'name' => 'Español'],
        ['code' => 'de', 'name' => 'Deutsch'],
        ['code' => 'ru', 'name' => 'Русский'],
        ['code' => 'ar', 'name' => 'العربية'],
    ];
    // Build a language-switch URL preserving other query params.
    $lngUrl = function (string $code) {
        $params = request()->query();
        $params['lng'] = $code;
        return url(request()->path()) . '?' . http_build_query($params);
    };
    $isActive = function (string $href) use ($current) {
        $path = '/' . ltrim($current, '/');
        return $path === $href || str_starts_with($path, $href . '/');
    };
    $navLinkBase = 'px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200';
    $navLinkOn = 'text-blue-600 bg-white/10';
    $navLinkOff = 'text-sm font-semibold text-slate-700 transition-colors hover:text-blue-600';
@endphp


<header data-navbar style="top:0px;height:72px" class="fixed left-0 right-0 z-50 transition-all duration-300 bg-white text-slate-900 shadow-sm backdrop-blur-md border-b border-white/5">
    <div class="w-full px-4 md:px-6 xl:px-12">
        <div class="flex items-center h-[68px] gap-3 xl:gap-6">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0 group" aria-label="Corporate Academy home">
                <img loading="eager" decoding="async" src="{{ asset('images/logo-academy.webp') }}" alt="Corporates Academy" width="802" height="205" class="h-10 w-auto max-w-[200px] object-contain transition-all duration-300 group-hover:scale-[1.04]">
            </a>

            {{-- DESKTOP NAV hidden --}}
            <nav class="hidden xl:flex items-center gap-1 flex-1">

                {{-- Courses (dropdown) --}}

  @php
    $coursesMenuList = \App\Models\Course::query()
    ->where(function ($query) {
        $query->whereNull('city')
              ->orWhere('city', '');
    })
    ->with('categoryIcon')
    ->where('show_top_menu', '1')
    ->select(
        'id',
        'slug',
        'title',
        'course_name',
        'category',
        'category_name'
    )
    ->orderBy('course_name')
    ->get();

$menuCategories = $coursesMenuList
    ->filter(function ($course) {
        return trim((string) $course->category) !== '';
    })
    ->groupBy('category')
    ->map(function ($courses, $categoryId) {
        $categoryName = $courses
            ->pluck('category_name')
            ->first(function ($name) {
                return trim((string) $name) !== '';
            });

        return [
            'category'     => $categoryId,
            'categoryName' => $categoryName ?: 'Other Courses',
            'courses'      => $courses->values(),
            'categoryIcon' => $courses->first()?->categoryIcon,
        ];
    })
    ->sortBy('categoryName', SORT_NATURAL | SORT_FLAG_CASE)
    ->values();
        
@endphp


<div class="ca-course-menu" data-ca-course-menu>
    <button
        type="button"
        data-ca-toggle
        aria-expanded="false"
        class="ca-course-menu__toggle rounded-xl px-3 py-2.5
               text-sm font-semibold transition-colors
               {{ $isActive('/courses')
                    ? $navLinkOn
                    : $navLinkOff }}"
    >
        {{ t('nav.courses') }}

        <svg
            class="ca-course-menu__caret"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div class="ca-course-menu__panel" data-ca-panel hidden>
        @if ($menuCategories->isNotEmpty())
            <div class="ca-course-menu__layout">

                {{-- Left categories --}}
                <div class="ca-course-menu__categories">
                    <div
                        role="tablist"
                        aria-label="Course categories"
                        aria-orientation="vertical"
                    >
                        @foreach ($menuCategories as $index => $category)
                            <button
                                type="button"
                                role="tab"
                                class="ca-course-menu__category"
                                data-ca-category="{{ $index }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                tabindex="{{ $loop->first ? '0' : '-1' }}"
                            >
                                <span class="ca-course-menu__icon" aria-hidden="true">
                                   
                            @php
                                $iconImg = null;

                               
                                $categoryIcon = $category['categoryIcon'] ?? null;

                                $rawIcons = is_string($categoryIcon)
                                    ? $categoryIcon
                                    : data_get($categoryIcon, 'category_icons');

                                $icons = is_array($rawIcons) ? $rawIcons : [];

                                if (is_string($rawIcons) && trim($rawIcons) !== '') {
                                    $decoded = @unserialize($rawIcons, [
                                        'allowed_classes' => false,
                                    ]);

                                    $icons = is_array($decoded) ? $decoded : [];
                                }

                                $src = data_get($icons, 'category_icons.src');

                                if (is_string($src) && trim($src) !== '') {
                                    $iconImg = asset(trim($src));
                                }
                            @endphp

                            @if ($iconImg)
                                <img
                                    src="{{ $iconImg }}"
                                    alt=""
                                    width="22"
                                    height="22"
                                    style="width:22px;height:22px;object-fit:contain;"
                                >
                            @else
                                <svg
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    aria-hidden="true"
                                >
                                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                                </svg>
                            @endif
                

                                   
                                </span>

                                <span class="ca-course-menu__category-name">
                                    {{ $category['categoryName'] }}
                                </span>

                                <span class="ca-course-menu__arrow" aria-hidden="true">
                                    ›
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Right courses --}}
                <div class="ca-course-menu__right">
                    @foreach ($menuCategories as $index => $category)
                        <div
                            role="tabpanel"
                            class="ca-course-menu__content"
                            data-ca-content="{{ $index }}"
                            @if (!$loop->first) hidden @endif
                        >
                            <h3 class="ca-course-menu__heading">
                                Popular Courses
                            </h3>

                            @forelse ($category['courses'] as $course)
                                <a
                                    href="{{ route('courses.show', ['slug' => $course->slug]) }}"
                                    class="ca-course-menu__link"
                                >
                                    <svg
                                        viewBox="0 0 12 12"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path d="M4 1.5 8.5 6 4 10.5z" />
                                    </svg>

                                    <span>
                                        {{ trim((string) $course->course_name) !== ''
                                            ? $course->course_name
                                            : $course->title }}
                                    </span>
                                </a>
                            @empty
                                <p class="ca-course-menu__empty">
                                    No courses available.
                                </p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="ca-course-menu__empty">
                No featured courses available.
            </p>
        @endif

        <div class="ca-course-menu__footer">
            <span>Explore our training programmes</span>

            <a href="{{ route('courses') }}">
                {{ t('navX.viewAll') }} →
            </a>
        </div>
    </div>
</div>

<script>
(() => {
    function initializeCourseMenus() {
        document.querySelectorAll('[data-ca-course-menu]').forEach(menu => {
            if (menu.dataset.caReady === 'true') return;

            const toggle = menu.querySelector('[data-ca-toggle]');
            const panel = menu.querySelector('[data-ca-panel]');
            const buttons = [...menu.querySelectorAll('[data-ca-category]')];
            const contents = [...menu.querySelectorAll('[data-ca-content]')];

            if (!toggle || !panel) return;

            menu.dataset.caReady = 'true';

            let closeTimer;

            window.caCourseMenuCounter = (window.caCourseMenuCounter || 0) + 1;
            const prefix = `ca-course-menu-${window.caCourseMenuCounter}`;

            panel.id = `${prefix}-dropdown`;
            toggle.setAttribute('aria-controls', panel.id);

            buttons.forEach(button => {
                const key = button.dataset.caCategory;
                const content = contents.find(
                    item => item.dataset.caContent === key
                );

                button.id = `${prefix}-tab-${key}`;

                if (content) {
                    content.id = `${prefix}-content-${key}`;
                    content.setAttribute('aria-labelledby', button.id);
                    button.setAttribute('aria-controls', content.id);
                }
            });

            function cancelClose() {
                clearTimeout(closeTimer);
            }

            function positionPanel() {
                panel.style.transform = '';

                const bounds = panel.getBoundingClientRect();
                const viewportWidth = document.documentElement.clientWidth;

                let shift = 0;

                if (bounds.right > viewportWidth - 12) {
                    shift = viewportWidth - 12 - bounds.right;
                }

                if (bounds.left + shift < 12) {
                    shift += 12 - (bounds.left + shift);
                }

                panel.style.transform = `translateX(${shift}px)`;
            }

            function setOpen(open) {
                cancelClose();

                panel.hidden = !open;
                toggle.setAttribute('aria-expanded', String(open));

                if (open) positionPanel();
            }

            function scheduleClose() {
                cancelClose();

                closeTimer = setTimeout(() => {
                    setOpen(false);
                }, 200);
            }

            function activateCategory(button) {
                const selected = button.dataset.caCategory;

                buttons.forEach(item => {
                    const active = item === button;

                    item.setAttribute('aria-selected', String(active));
                    item.tabIndex = active ? 0 : -1;
                });

                contents.forEach(content => {
                    content.hidden = content.dataset.caContent !== selected;
                });
            }

            // Mouse hover opens the dropdown.
            menu.addEventListener('pointerenter', event => {
                if (event.pointerType === 'mouse') {
                    setOpen(true);
                }
            });

            // Close after leaving the complete menu.
            menu.addEventListener('pointerleave', event => {
                if (event.pointerType === 'mouse') {
                    scheduleClose();
                }
            });

            // Cancel any pending close when entering the panel.
            panel.addEventListener('pointerenter', cancelClose);

            // Click also opens it, including touch and keyboard activation.
            toggle.addEventListener('click', () => {
                setOpen(true);
            });

            toggle.addEventListener('keydown', event => {
                if (event.key === 'ArrowDown' && buttons.length) {
                    event.preventDefault();
                    setOpen(true);

                    const active = buttons.find(
                        button => button.getAttribute('aria-selected') === 'true'
                    );

                    (active || buttons[0]).focus();
                }
            });

            buttons.forEach((button, index) => {
                // Category mouse hover.
                button.addEventListener('pointerenter', event => {
                    if (event.pointerType === 'mouse') {
                        activateCategory(button);
                    }
                });

                // Category click/touch.
                button.addEventListener('click', () => {
                    cancelClose();
                    activateCategory(button);
                });

                // Keyboard focus.
                button.addEventListener('focus', () => {
                    cancelClose();
                    activateCategory(button);
                });

                button.addEventListener('keydown', event => {
                    let nextIndex;

                    switch (event.key) {
                        case 'ArrowDown':
                            nextIndex = (index + 1) % buttons.length;
                            break;

                        case 'ArrowUp':
                            nextIndex = (index - 1 + buttons.length) % buttons.length;
                            break;

                        case 'Home':
                            nextIndex = 0;
                            break;

                        case 'End':
                            nextIndex = buttons.length - 1;
                            break;

                        default:
                            return;
                    }

                    event.preventDefault();
                    buttons[nextIndex].focus();
                });
            });

            // Outside click closes the dropdown.
            document.addEventListener('click', event => {
                if (!menu.contains(event.target)) {
                    setOpen(false);
                }
            });

            // Escape closes and restores focus.
            menu.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    event.preventDefault();
                    setOpen(false);
                    toggle.focus();
                }
            });

            menu.addEventListener('focusin', cancelClose);

            // Close when keyboard focus leaves the menu.
            menu.addEventListener('focusout', event => {
                if (!menu.contains(event.relatedTarget)) {
                    setOpen(false);
                }
            });

            window.addEventListener('resize', () => {
                if (!panel.hidden) positionPanel();
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCourseMenus);
    } else {
        initializeCourseMenus();
    }
})();
</script>


<style>
    .ca-course-menu {
        position: relative;
        flex-shrink: 0;
    }

    .ca-course-menu *,
    .ca-course-menu *::before,
    .ca-course-menu *::after {
        box-sizing: border-box;
    }

    .ca-course-menu [hidden] {
        display: none !important;
    }

    .ca-course-menu__toggle {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        cursor: pointer;
    }

    .ca-course-menu__caret {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        transition: transform .2s ease;
    }

    .ca-course-menu__toggle[aria-expanded="true"]
    .ca-course-menu__caret {
        transform: rotate(180deg);
    }

    .ca-course-menu .ca-course-menu__panel {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 9999;
        display: block;
        width: 820px;
        max-width: calc(100vw - 24px);
        margin-top: 10px;
        padding: 8px;
        overflow: visible;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 18px 50px rgb(15 23 42 / 20%);
        text-align: left;
        white-space: normal;
    }

    /* Mouse can cross the gap without closing the menu. */
    .ca-course-menu__panel::before {
        content: "";
        position: absolute;
        top: -11px;
        left: 0;
        width: 100%;
        height: 11px;
    }

    .ca-course-menu__layout {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 8px;
        width: 100%;
        min-width: 0;
        overflow: hidden;
        border-radius: 8px;
    }

    .ca-course-menu__categories,
    .ca-course-menu__content {
        height: 400px;
        max-height: 60vh;
        overflow-x: hidden;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #2563eb #e5e7eb;
    }

    .ca-course-menu__categories::-webkit-scrollbar,
    .ca-course-menu__content::-webkit-scrollbar {
        width: 5px;
    }

    .ca-course-menu__categories::-webkit-scrollbar-thumb,
    .ca-course-menu__content::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background: #2563eb;
    }

    .ca-course-menu__categories {
        min-width: 0;
        padding: 8px;
        background: #f1f1f1;
    }

    .ca-course-menu .ca-course-menu__category {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        min-height: 42px;
        margin: 0 0 4px;
        padding: 9px 10px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #334155;
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.5;
        text-align: left;
        cursor: pointer;
        transition: background .15s ease, color .15s ease;
    }

    .ca-course-menu__category:hover,
    .ca-course-menu__category[aria-selected="true"] {
        background: #dcdcdc;
        color: #0f172a;
    }

    .ca-course-menu__category:focus-visible,
    .ca-course-menu__link:focus-visible {
        outline: 2px solid #2563eb;
        outline-offset: -2px;
    }

    .ca-course-menu__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        flex: 0 0 22px;
        color: #2563eb;
    }

    .ca-course-menu__icon svg {
        width: 20px;
        height: 20px;
    }

    .ca-course-menu__category-name {
        flex: 1;
        min-width: 0;
        white-space: normal;
        word-break: normal;
        overflow-wrap: break-word;
    }

    .ca-course-menu__arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        flex: 0 0 26px;
        border-radius: 5px;
        background: #bfc1c4;
        color: #fff;
        font-size: 22px;
        line-height: 1;
        visibility: hidden;
    }

    .ca-course-menu__category[aria-selected="true"]
    .ca-course-menu__arrow {
        visibility: visible;
    }

    .ca-course-menu__right {
        min-width: 0;
        background: #f0faff;
    }

    .ca-course-menu__content {
        padding: 22px;
    }

    .ca-course-menu__heading {
        margin: 0 0 14px;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.5;
    }

    .ca-course-menu .ca-course-menu__link {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 3px;
        padding: 8px;
        border-radius: 6px;
        color: #526173;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.6;
        text-decoration: none;
        white-space: normal;
        word-break: normal;
        overflow-wrap: break-word;
        transition: background .15s ease, color .15s ease;
    }

    .ca-course-menu__link:hover {
        background: #fff;
        color: #1d4ed8;
    }

    .ca-course-menu__link svg {
        width: 12px;
        height: 12px;
        margin-top: 4px;
        flex: 0 0 12px;
        color: #8491a0;
    }

    .ca-course-menu__link span {
        min-width: 0;
    }

    .ca-course-menu__empty {
        margin: 0;
        padding: 20px;
        color: #64748b;
        font-size: 13px;
    }

    .ca-course-menu__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 8px 4px;
        color: #64748b;
        font-size: 12px;
    }

    .ca-course-menu__footer a {
        flex-shrink: 0;
        color: #2563eb;
        font-weight: 700;
        text-decoration: none;
    }

    @media (max-width: 640px) {
        .ca-course-menu .ca-course-menu__panel {
            width: calc(100vw - 24px);
            padding: 5px;
        }

        .ca-course-menu__layout {
            grid-template-columns: minmax(0, 42%) minmax(0, 1fr);
            gap: 5px;
        }

        .ca-course-menu__categories {
            padding: 4px;
        }

        .ca-course-menu .ca-course-menu__category {
            gap: 6px;
            padding: 9px 6px;
            font-size: 12px;
        }

        .ca-course-menu__icon {
            width: 18px;
            flex-basis: 18px;
        }

        .ca-course-menu__icon svg {
            width: 17px;
            height: 17px;
        }

        .ca-course-menu__arrow {
            display: none;
        }

        .ca-course-menu__content {
            padding: 14px 8px;
        }

        .ca-course-menu .ca-course-menu__link {
            gap: 4px;
            padding: 7px 3px;
            font-size: 12px;
        }

        .ca-course-menu__footer {
            font-size: 11px;
        }
    }
</style>
        

                {{-- Simple links --}}
                
                <a href="{{ route('aboutUs')}}" class="{{ $navLinkBase }} {{ $isActive('/about-us') ? $navLinkOn : $navLinkOff }}">{{ t('nav.about') }}</a>

                {{-- Corporate Training (dropdown) --}}
                <div class="relative" data-dropdown>
                    <button type="button" data-dropdown-toggle class="flex items-center gap-1 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isActive('/corporate-training') || $isActive('/doctorate') ? $navLinkOn : $navLinkOff }}">
                        {{ t('navX.corporate') }}
                        <svg class="h-3.5 w-3.5 transition-transform duration-200" data-dropdown-caret viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div data-dropdown-panel class="hidden absolute top-full left-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl shadow-black/30 border border-gray-100 overflow-hidden z-50">
                        <div class="p-3">
                            @foreach ([
                                ['navX.corpTeamTitle', 'navX.corpTeamDesc'],
                                ['navX.corpLeadershipTitle', 'navX.corpLeadershipDesc'],
                                ['navX.corpEnterpriseTitle', 'navX.corpEnterpriseDesc'],
                            ] as [$labelKey, $descKey])
                                <a href="{{ route('corporate-training') }}" class="flex flex-col gap-0.5 p-3.5 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <span class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">{{ t($labelKey) }}</span>
                                    <span class="text-xs text-gray-400">{{ t($descKey) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            

                <a href="{{ route('scholarship')}}" class="{{ $navLinkBase }} {{ $isActive('/scholarship') ? $navLinkOn : 'text-amber-400/90 hover:text-amber-300 hover:bg-amber-400/10' }}">{{ t('navX.scholarship') }}</a>
                <a href="{{ route('contactUs')}}" class="{{ $navLinkBase }} {{ $isActive('/contact-us') ? $navLinkOn : $navLinkOff }}">{{ t('nav.contact') }}</a>

                <a href="{{ route('courses.enquiry') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-bold text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10 transition-all duration-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                    </span>
                    {{ t('navX.freeDemo') }}
                </a>
            </nav>

            {{-- RIGHT ACTIONS --}}
            <div class="hidden xl:flex items-center gap-2 shrink-0 ml-auto">
               

                
                <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 px-3.5 py-2 text-sm font-bold rounded-xl bg-amber-500 hover:bg-amber-400 text-white shadow-lg shadow-amber-500/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">{{ t('navX.payNow') }}</a>
                <a href="{{ route('courses') }}" class="flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl bg-primary hover:bg-primary/90 text-white shadow-xl shadow-primary/30 ring-2 ring-primary/30 ring-offset-1 ring-offset-[#060e24] transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">{{ t('nav.explorePrograms') }}</a>
            </div>

            {{-- MOBILE TOGGLE --}}
            <div class="flex xl:hidden items-center gap-2 ml-auto">
               
                <button type="button" data-mobile-toggle class="w-10 h-10 flex items-center justify-center rounded-xl bg-black/10 text-black border border-black/15 hover:bg-gray/15 transition-colors active:scale-90" aria-label="{{ t('navX.openMenu') }}">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>


        </div>
    </div>
</header>

{{-- ── MOBILE DRAWER ────────────────────────────────── --}}
<div data-mobile-backdrop class="hidden fixed inset-0 z-[45] bg-black/60 backdrop-blur-sm xl:hidden"></div>
<div data-mobile-drawer class="hidden fixed top-0 right-0 bottom-0 z-[48] w-[min(300px,85vw)] bg-[#060e24] border-l border-white/10 shadow-2xl xl:hidden flex-col overflow-y-auto">
    <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
        <img loading="lazy" decoding="async" src="{{ asset('images/logo-academy.webp') }}" alt="Corporate Academy" width="802" height="205" class="h-8 w-auto">
        <button type="button" data-mobile-close aria-label="{{ t('navX.closeMenu') }}" class="w-11 h-11 -mr-2 flex items-center justify-center rounded-lg text-white/50 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <div class="flex-1 py-4 px-3 space-y-1 bg-white text-gray-400">
     @php
    $links = [
        ['courses', 'nav.courses'],
        ['aboutUs', 'About Us'],
        ['corporate-training', 'navX.corporateTraining'],
       
        ['scholarship', 'navX.scholarship'],
        ['contactUs', 'Contact us'],
    ];
@endphp

@foreach ($links as [$routeName, $labelKey])

    <a href="{{ route($routeName) }}"
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-colors
       {{ request()->routeIs($routeName)
            ? 'text-blue-600 bg-white/10'
            : 'text-sm font-semibold text-slate-700 transition-colors hover:text-blue-600' }}">

        {{ t($labelKey) }}

    </a>

@endforeach
    </div>
    <div class="border-t border-white/10 p-4 space-y-2.5">

        <a href="https://u.payu.in/PIwPV343Esho" target="_blank" rel="noopener noreferrer" class="flex w-full items-center gap-2 justify-start rounded-xl bg-amber-500 hover:bg-amber-400 text-white font-bold shadow-lg shadow-amber-600/30 px-4 py-2.5 text-sm">{{ t('navX.payNow') }}</a>
        <a href="{{ route('courses') }}" class="flex w-full items-center gap-2 justify-start rounded-xl bg-primary hover:bg-primary/90 text-white font-bold shadow-xl shadow-primary/30 ring-2 ring-primary/30 ring-offset-2 ring-offset-[#060e24] px-4 py-2.5 text-sm">{{ t('nav.explorePrograms') }}</a>
    </div>
    <div class="px-5 py-4 border-t border-white/5 text-xs text-white/30 font-medium">{{ t('navX.location') }}</div>
</div>
