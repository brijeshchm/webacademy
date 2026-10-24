@extends('layouts.app')

@php
    $article = $blog_details ?? $blogDetails ?? null;
    abort_if(!$article, 404);

    $articleTitle = data_get($article, 'title', 'Blog');
    $articleSlug = data_get($article, 'slug', '');

    $latestArticles = collect($blogList ?? $blogs ?? [])
        ->filter(fn ($item) =>
            filled(data_get($item, 'slug')) &&
            data_get($item, 'slug') !== $articleSlug
        )
        ->take(6)
        ->values();

    $ticker = collect($tickerItems ?? [])
        ->filter(fn ($item) =>
            filled(data_get($item, 'slug', data_get($item, 'url')))
        )
        ->values();

    $categoryItems = collect($categories ?? []);
    $courseItems = collect($trendCourse ?? [])->take(6);

    $faqItems = collect($faqs ?? []);

    if ($faqItems->isEmpty()) {
        for ($i = 1; $i <= 6; $i++) {
            $question = data_get($article, 'faqq' . $i);
            $answer = data_get($article, 'faqa' . $i);

            if (filled($question) && filled($answer)) {
                $faqItems->push(['q' => $question, 'a' => $answer]);
            }
        }
    }

    $faqItems = $faqItems
        ->filter(fn ($item) =>
            filled(data_get($item, 'q')) &&
            filled(data_get($item, 'a'))
        )
        ->values();

    $articleParagraphs = collect($paragraphs ?? []);

    if ($articleParagraphs->isEmpty()) {
        for ($i = 1; $i <= 6; $i++) {
            $paragraph = data_get($article, 'paragraph' . $i);

            if (filled($paragraph)) {
                $articleParagraphs->push($paragraph);
            }
        }
    }

    // Support existing image fields and JSON image data.
    $getBlogImage = function ($item) {
        $resolve = function ($value) {
            if (!is_string($value) || trim($value) === '') {
                return null;
            }

            $value = trim($value);

            if (preg_match('~^https?://~i', $value)) {
                return $value;
            }

            if (str_starts_with($value, '//')) {
                return 'https:' . $value;
            }

            // Reject unsupported URL schemes.
            if (preg_match('~^[a-z][a-z0-9+.-]*:~i', $value)) {
                return null;
            }

            return asset(ltrim($value, '/'));
        };

        foreach (['blogImage', 'blog_image', 'blog_iamge'] as $field) {
            $value = data_get($item, $field);

            if (is_string($value)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $value = $decoded;
                }
            }

            if (is_array($value) || is_object($value)) {
                $value = data_get($value, 'blog_iamge.src')
                    ?? data_get($value, 'blog_image.src')
                    ?? data_get($value, 'src');
            }

            if ($url = $resolve($value)) {
                return $url;
            }
        }

        return null;
    };

    $heroImage = $getBlogImage($article);

    if (empty($heroImage) && !empty($bgImage)) {
        $heroImage = preg_match('~^https?://~i', $bgImage)
            ? $bgImage
            : asset(ltrim($bgImage, '/'));
    }

    $rating = max(0, min(5, (float) data_get($article, 'rating', 0)));
    $ratingCount = max(0, (int) data_get($article, 'total_rating', 0));

    $author = data_get($article, 'author_name');
    $publishedAt = data_get($article, 'created_at');

    $publishedLabel = '';
    $publishedIso = '';

    if ($publishedAt) {
        try {
            $publishedDate = \Illuminate\Support\Carbon::parse($publishedAt);
            $publishedLabel = $publishedDate->format('d M Y');
            $publishedIso = $publishedDate->toIso8601String();
        } catch (\Throwable $exception) {
            $publishedLabel = '';
        }
    }

    $readingText = implode(' ', [
        data_get($article, 'blog_about', ''),
        data_get($article, 'blog_defination', ''),
        data_get($article, 'top_content', ''),
        data_get($article, 'bottom_content', ''),
        $articleParagraphs->implode(' '),
    ]);

    

    $previousArticle = $previous ?? null;
    $nextArticle = $next ?? null;
@endphp

@section('title', data_get($article, 'meta_title') ?: $articleTitle)
@section('description', data_get($article, 'meta_description', ''))
@section('og_image', $heroImage ?? '')

@section('content')

<style>
    .blog-content {
        color: #374151;
        font-size: 1rem;
        line-height: 1.85;
        overflow-wrap: anywhere;
    }

    .blog-content h1,
    .blog-content h2,
    .blog-content h3,
    .blog-content h4 {
        margin: 1.75rem 0 .8rem;
        color: #0f172a;
        font-weight: 700;
        line-height: 1.35;
    }

    .blog-content h1,
    .blog-content h2 { font-size: 1.5rem; }
    .blog-content h3 { font-size: 1.25rem; }

    .blog-content p { margin-bottom: 1rem; }

    .blog-content ul,
    .blog-content ol {
        margin: 0 0 1.25rem;
        padding-left: 1.5rem;
    }

    .blog-content ul { list-style: disc; }
    .blog-content ol { list-style: decimal; }
    .blog-content li { margin-bottom: .4rem; }

    .blog-content a {
        color: #2563eb;
        text-decoration: underline;
    }

    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: .75rem;
    }

    .blog-content table {
        display: block;
        max-width: 100%;
        overflow-x: auto;
        margin-bottom: 1.25rem;
        border-collapse: collapse;
    }

    .blog-content th,
    .blog-content td {
        padding: .75rem;
        border: 1px solid #e2e8f0;
        text-align: left;
    }

    .blog-content th { background: #f1f5f9; }

    .blog-content blockquote {
        margin: 1.5rem 0;
        padding-left: 1rem;
        border-left: 4px solid #2563eb;
        color: #64748b;
    }

    .blog-content pre {
        max-width: 100%;
        overflow-x: auto;
        padding: 1rem;
        border-radius: .75rem;
        background: #0f172a;
        color: #e2e8f0;
    }

    .blog-rating-fill {
        width: var(--rating-width);
    }
</style>

{{-- Reading progress --}}
<div
    id="blog-scroll-progress"
    class="fixed left-0 right-0 top-0 z-[9999] h-1 origin-left scale-x-0 bg-blue-600"
    aria-hidden="true"
></div>

{{-- Breadcrumb --}}
<div class="border-b border-slate-200 bg-white">
    <nav
        aria-label="Breadcrumb"
        class="mx-auto flex max-w-7xl flex-wrap items-center gap-2 px-4 py-4 text-sm text-slate-500 sm:px-6"
    >
        <a href="{{ route('home') }}" class="hover:text-blue-600">
            Home
        </a>

        <span aria-hidden="true">/</span>

        <a href="{{ route('blog') }}" class="hover:text-blue-600">
            Blog
        </a>

        <span aria-hidden="true">/</span>

        <span class="text-slate-800" aria-current="page">
            {{ $articleTitle }}
        </span>
    </nav>
</div>

{{-- Latest headlines --}}
@if($ticker->isNotEmpty())
    <div class="bg-blue-950 text-white">
        <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6">
            <span class="shrink-0 rounded bg-blue-600 px-3 py-1 text-xs font-bold">
                Latest
            </span>

            <div class="flex min-w-0 gap-6 overflow-x-auto text-sm">
                @foreach($ticker as $item)
                    <a
                        href="{{ route('blog.details', data_get($item, 'slug', data_get($item, 'url'))) }}"
                        class="shrink-0 hover:text-blue-200"
                    >
                        {{ data_get($item, 'title', '') }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<main class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:py-12">
        <div class="grid items-start gap-8 lg:grid-cols-12">

            {{-- ARTICLE --}}
            <article id="blog-article" class="min-w-0 lg:col-span-8">

                <header class="mb-7">
                    @if(filled(data_get($article, 'categoryname')))
                        <span class="mb-4 inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ data_get($article, 'categoryname') }}
                        </span>
                    @endif

                    <h1 class="text-3xl font-bold leading-tight text-slate-900 sm:text-4xl">
                        {{ $articleTitle }}
                    </h1>

                    <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-3 text-sm text-slate-500">
                        @if(filled($author))
                            <span class="font-semibold text-slate-700">
                                {{ $author }}
                            </span>
                        @endif

                        @if($publishedLabel)
                            <time datetime="{{ $publishedIso }}">
                                {{ $publishedLabel }}
                            </time>
                        @endif
 

                        <span>
                            {{ number_format((int) data_get($article, 'views', 0)) }}
                            views
                        </span>
                    </div>

                    @if($ratingCount > 0 && $rating > 0)
                        <div class="mt-4 flex flex-wrap items-center gap-2 text-sm">
                            <span
                                class="relative inline-block text-lg leading-none tracking-wide text-slate-300"
                                role="img"
                                aria-label="{{ $rating }} out of 5 stars"
                            >
                                <span aria-hidden="true">★★★★★</span>

                                <span
                                    aria-hidden="true"
                                    class="blog-rating-fill absolute inset-y-0 left-0 overflow-hidden whitespace-nowrap text-amber-500"
                                    style="--rating-width: {{ $rating * 20 }}%;"
                                >★★★★★</span>
                            </span>

                            <span class="font-semibold text-slate-800">
                                {{ number_format($rating, 1) }}/5
                            </span>

                            <span class="text-slate-500">
                                ({{ number_format($ratingCount) }} ratings)
                            </span>
                        </div>
                    @endif
                </header>

                {{-- Hero image is visible immediately --}}
                <div class="mb-7 overflow-hidden rounded-2xl bg-blue-950 shadow-sm">
                    @if($heroImage)
                        <img
                            src="{{ $heroImage }}"
                            alt="{{ $articleTitle }}"
                            width="1200"
                            height="675"
                            fetchpriority="high"
                            decoding="async"
                            class="aspect-video w-full object-cover"
                        >
                    @else
                        <div class="flex aspect-video items-center justify-center bg-gradient-to-br from-blue-950 via-blue-700 to-cyan-600">
                            <span class="text-8xl font-black text-white/25">
                                {{ \Illuminate\Support\Str::upper(
                                    \Illuminate\Support\Str::substr($articleTitle, 0, 1)
                                ) }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Share / bookmark --}}
                <div class="mb-7 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white p-4">
                    <button
                        type="button"
                        data-copy-link
                        class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700"
                    >
                        Copy article link
                    </button>

                    <button
                        id="blog-bookmark"
                        type="button"
                        aria-pressed="false"
                        class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-50"
                    >
                        Save article
                    </button>

                    <p id="blog-action-status" role="status" class="w-full text-xs text-slate-500"></p>
                </div>

                {{-- Main content --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-8">

                    @if(filled(data_get($article, 'blog_about')))
                        <section class="mb-7 rounded-xl bg-blue-50 p-5">
                            @if(filled(data_get($article, 'heading')))
                                <h2 class="mb-3 text-xl font-bold text-blue-950">
                                    {{ data_get($article, 'heading') }}
                                </h2>
                            @endif

                            <div class="blog-content">
                                {!! data_get($article, 'blog_about', '') !!}
                            </div>

                            @if($articleParagraphs->isNotEmpty())
                                <ul class="mt-4 space-y-3">
                                    @foreach($articleParagraphs as $paragraph)
                                        <li class="flex gap-3 text-sm leading-7 text-slate-700">
                                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                                            <span>{{ $paragraph }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </section>
                    @endif

                    <div class="blog-content">
                        @if(filled(data_get($article, 'blog_defination')))
                            @if(
                                blank(data_get($article, 'blog_about')) &&
                                filled(data_get($article, 'heading'))
                            )
                                <h2>{{ data_get($article, 'heading') }}</h2>
                            @endif

                            {!! data_get($article, 'blog_defination', '') !!}
                        @endif

                        @if(filled(data_get($article, 'top_content')))
                            @if(filled(data_get($article, 'top_heading')))
                                <h2>{{ data_get($article, 'top_heading') }}</h2>
                            @endif

                            {!! data_get($article, 'top_content', '') !!}
                        @endif

                        @if(filled(data_get($article, 'bottom_content')))
                            @if(filled(data_get($article, 'bottom_heading')))
                                <h2>{{ data_get($article, 'bottom_heading') }}</h2>
                            @endif

                            {!! data_get($article, 'bottom_content', '') !!}
                        @endif
                    </div>
                </div>

                {{-- FAQ: works without JavaScript --}}
                @if($faqItems->isNotEmpty())
                    <section class="mt-7 rounded-2xl border border-slate-200 bg-white p-5 sm:p-8">
                        <h2 class="mb-5 text-xl font-bold text-slate-900">
                            Frequently Asked Questions
                        </h2>

                        <div class="space-y-3">
                            @foreach($faqItems as $faq)
                                <details class="group rounded-xl border border-slate-200">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-4 font-semibold text-slate-800">
                                        <span>{{ data_get($faq, 'q') }}</span>

                                        <svg
                                            class="h-4 w-4 shrink-0 transition-transform group-open:rotate-180"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            aria-hidden="true"
                                        >
                                            <path d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </summary>

                                    <div class="blog-content border-t border-slate-100 p-4">
                                        {!! data_get($faq, 'a') !!}
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Previous / next --}}
                @if($previousArticle || $nextArticle)
                    <nav aria-label="Article navigation" class="mt-7 grid gap-4 sm:grid-cols-2">
                        @if($previousArticle)
                            <a
                                href="{{ route('blog.details', data_get($previousArticle, 'slug')) }}"
                                class="rounded-xl border border-slate-200 bg-white p-5 hover:border-blue-400"
                            >
                                <span class="text-xs font-semibold text-blue-600">← Previous article</span>
                                <span class="mt-2 block font-semibold text-slate-800">
                                    {{ data_get($previousArticle, 'title') }}
                                </span>
                            </a>
                        @endif

                        @if($nextArticle)
                            <a
                                href="{{ route('blog.details', data_get($nextArticle, 'slug')) }}"
                                class="rounded-xl border border-slate-200 bg-white p-5 hover:border-blue-400"
                            >
                                <span class="text-xs font-semibold text-blue-600">Next article →</span>
                                <span class="mt-2 block font-semibold text-slate-800">
                                    {{ data_get($nextArticle, 'title') }}
                                </span>
                            </a>
                        @endif
                    </nav>
                @endif

                <a
                    href="{{ route('blog') }}"
                    class="mt-7 inline-flex font-semibold text-blue-700 hover:underline"
                >
                    ← Back to all articles
                </a>
            </article>

            {{-- SIDEBAR --}}
            <aside class="min-w-0 space-y-6 lg:col-span-4">

                @if($categoryItems->isNotEmpty())
                    <section class="rounded-2xl border border-slate-200 bg-white p-5">
                        <h2 class="mb-4 text-lg font-bold text-slate-900">
                            Categories
                        </h2>

                        <ul class="divide-y divide-slate-100">
                            @foreach($categoryItems as $category)
                                @php
                                    $categorySlug = data_get($category, 'category_slug');
                                    $categoryName = data_get($category, 'category', '');
                                @endphp

                                @if(filled($categoryName))
                                    <li class="py-3 text-sm text-slate-600">
                                        @if(filled($categorySlug))
                                            <a
                                                href="{{ route('blog.blogCategory', $categorySlug) }}"
                                                class="hover:text-blue-700"
                                            >
                                                {{ $categoryName }}
                                            </a>
                                        @else
                                            {{ $categoryName }}
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if($latestArticles->isNotEmpty())
                    <section class="rounded-2xl border border-slate-200 bg-white p-5">
                        <h2 class="mb-5 text-lg font-bold text-slate-900">
                            Latest Articles
                        </h2>

                        <div class="space-y-5">
                            @foreach($latestArticles as $related)
                                @php $relatedImage = $getBlogImage($related); @endphp

                                <a
                                    href="{{ route('blog.details', data_get($related, 'slug')) }}"
                                    class="group flex items-start gap-3"
                                >
                                    @if($relatedImage)
                                        <img
                                            src="{{ $relatedImage }}"
                                            alt="{{ data_get($related, 'title', '') }}"
                                            width="80"
                                            height="80"
                                            loading="lazy"
                                            decoding="async"
                                            class="h-20 w-20 shrink-0 rounded-xl object-cover"
                                        >
                                    @else
                                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-2xl font-bold text-blue-700">
                                            {{ \Illuminate\Support\Str::upper(
                                                \Illuminate\Support\Str::substr(
                                                    data_get($related, 'title', 'B'), 0, 1
                                                )
                                            ) }}
                                        </div>
                                    @endif

                                    <span class="min-w-0 text-sm font-semibold leading-6 text-slate-800 group-hover:text-blue-700">
                                        {{ data_get($related, 'title', '') }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($courseItems->isNotEmpty())
                    <section class="rounded-2xl border border-slate-200 bg-white p-5">
                        <h2 class="mb-4 text-lg font-bold text-slate-900">
                            Trending Courses
                        </h2>

                        <div class="space-y-3">
                            @foreach($courseItems as $course)
                                @if(filled(data_get($course, 'slug')))
                                    <a
                                        href="{{ route('courses.show', data_get($course, 'slug')) }}"
                                        class="block rounded-xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700"
                                    >
                                        {{ data_get($course, 'title', data_get($course, 'name', 'Course')) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endif

                <section class="rounded-2xl bg-gradient-to-br from-blue-950 to-blue-700 p-6 text-white">
                    <h2 class="text-xl font-bold">Share this article</h2>

                    <p class="mt-2 text-sm leading-6 text-blue-100">
                        Share this article with your colleagues and friends.
                    </p>

                    <button
                        type="button"
                        data-copy-link
                        class="mt-5 rounded-xl bg-white px-5 py-3 text-sm font-bold text-blue-800 hover:bg-blue-50"
                    >
                        Copy link
                    </button>
                </section>
            </aside>
        </div>
    </div>
</main>

<script>
(function () {
    'use strict';

    function initBlog() {
        const article = document.getElementById('blog-article');

        if (!article || article.dataset.ready === '1') return;
        article.dataset.ready = '1';

        const progress = document.getElementById('blog-scroll-progress');
        const status = document.getElementById('blog-action-status');

        function updateProgress() {
            const start = article.getBoundingClientRect().top + window.scrollY;
            const distance = article.offsetHeight - window.innerHeight;
            const value = distance > 0
                ? Math.min(1, Math.max(0, (window.scrollY - start) / distance))
                : 1;

            if (progress) {
                progress.style.transform = `scaleX(${value})`;
            }
        }

        let scheduled = false;

        window.addEventListener('scroll', () => {
            if (scheduled) return;

            scheduled = true;

            requestAnimationFrame(() => {
                updateProgress();
                scheduled = false;
            });
        }, { passive: true });

        window.addEventListener('resize', updateProgress);
        window.addEventListener('load', updateProgress, { once: true });
        updateProgress();

        document.querySelectorAll('[data-copy-link]').forEach(button => {
            button.addEventListener('click', async () => {
                const original = button.textContent;

                try {
                    if (!navigator.clipboard?.writeText) {
                        throw new Error('Clipboard unavailable');
                    }

                    await navigator.clipboard.writeText(window.location.href);

                    button.textContent = 'Copied!';
                    status.textContent = 'Article link copied.';

                    setTimeout(() => {
                        button.textContent = original;
                    }, 2000);
                } catch {
                    status.textContent =
                        'Unable to copy automatically. Copy the URL from your browser address bar.';
                }
            });
        });

        const bookmark = document.getElementById('blog-bookmark');
        const key = 'saved-blog:' + window.location.pathname;

        function renderBookmark(saved) {
            bookmark.setAttribute('aria-pressed', String(saved));
            bookmark.textContent = saved ? 'Saved article ✓' : 'Save article';
        }

        try {
            renderBookmark(localStorage.getItem(key) === '1');
        } catch {
            renderBookmark(false);
        }

        bookmark.addEventListener('click', () => {
            const saved = bookmark.getAttribute('aria-pressed') !== 'true';

            try {
                if (saved) {
                    localStorage.setItem(key, '1');
                } else {
                    localStorage.removeItem(key);
                }

                renderBookmark(saved);
                status.textContent = saved
                    ? 'Article saved on this browser.'
                    : 'Article removed from saved items.';
            } catch {
                status.textContent = 'Your browser could not save this article.';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBlog, { once: true });
    } else {
        initBlog();
    }
})();
</script>

@endsection