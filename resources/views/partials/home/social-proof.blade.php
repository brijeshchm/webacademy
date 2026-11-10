@php
    $reviews = collect($whatsappChats ?? [])
        ->filter(fn ($item) => !empty($item->image_data))
        ->values();

    $documents = collect($proofs ?? [])
        ->filter(fn ($item) => !empty($item->image_data))
        ->values();

    // Dummy slides with fallback data
    $dummyReviews = collect([
        (object)[
            'image_data' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=900&q=80',
            'caption'    => 'Student Review 1'
        ],
        (object)[
            'image_data' => 'https://images.unsplash.com/photo-1577563908411-5077b6dc7624?auto=format&fit=crop&w=900&q=80',
            'caption'    => 'Student Review 2'
        ],
    ]);

    $dummyProofs = collect([
        (object)[
            'image_data' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=900&q=80',
            'caption'    => 'Placement Proof 1'
        ],
        (object)[
            'image_data' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=900&q=80',
            'caption'    => 'Placement Proof 2'
        ],
    ]);

    $groups = [
        [
            'type'  => 'whatsapp',
            'title' => t('socialProof.studentReviews') ?? 'Student Reviews',
            'badge' => 'WhatsApp Chats',
            'items' => $reviews->isNotEmpty() ? $reviews : '',
        ],
        [
            'type'  => 'proof',
            'title' => t('socialProof.placementProofs') ?? 'Placement Proofs',
            'badge' => 'Offer Letters',
            'items' => $documents->isNotEmpty() ? $documents :'',
        ],
        [
            'type'  => 'banner',
            'title' =>  'Mook Proofs',
            'badge' => 'Offer Letters',
            'items' =>  $dummyProofs,
        ],
    ];
@endphp

@php
    $gradients = [
        'linear-gradient(90deg, #fb8e28 0%, #08366a 73%)',
        'linear-gradient(90deg, #7c3aed 0%, #0dd840 73%)',
        'linear-gradient(90deg, #059669 0%, #083344 73%)',
        'linear-gradient(90deg, #e11d48 0%, #4c1d95 73%)',
    ];
@endphp

<section class="py-16 md:py-24 bg-white text-black bg-gradient-to-r from-[#eef5ff] via-[#f5f3ff] to-[#dddddd]" style=" background: url(/images/Corporate-placement.png);background-size: cover;
    background-position: center;
    background-repeat: no-repeat;">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 ">

        {{-- Heading --}}
        <div class="mx-auto mb-12 max-w-2xl text-center">
            <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-black shadow-sm mb-4">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ t('home.proofSection') ?? 'Social Proof' }}</span>
            </div>

            <h2 class="text-3xl font-extrabold tracking-tight text-black sm:text-4xl">
                <span class="text-emerald-600">{{ t('home.whatsappTitle1') ?? 'Real Success Stories' }}</span>
                <span class="block text-blue-600">{{ t('home.whatsappTitle2') ?? '& Direct Proofs' }}</span>
            </h2>

            
        </div>

        {{-- 2 Sliders Side by Side --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($groups as $group)
                <div
                    data-slider-container
                    class="group relative flex flex-col justify-between rounded-2xl  bg-white p-5 md:p-6  bg-[radial-gradient(circle_at_50%_0%,rgba(0,0,0,0.03),transparent_55%)]"
                >
                    <div>
                        {{-- Card Header --}}
                        <div class="mb-5 flex items-center justify-between pb-4">
                            <div class="flex items-center gap-3">
                                @if($group['type'] === 'whatsapp')
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22z"/>
                                        </svg>
                                    </div>
                                @elseif($group['type'] === 'proof')
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                                            <path d="m9 12 2 2 4-4"/>
                                        </svg>
                                    </div>
                                @else

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                            <path d="m9 12 2 2 4-4"/>
                            </svg>
                            </div>

                                @endif

                                <div>
                                    <h3 class="text-sm font-bold text-blue">{{ $group['title'] }}</h3>
                                    
                                </div>
                            </div>

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-black">
                                {{ $group['badge'] }}
                            </span>
                        </div>

                        {{-- Slide Display Viewport with On-Image Buttons & Indicators --}}
                        <div class="relative overflow-hidden rounded-xl">
                            {{-- Slides Track --}}
                            <div
                                data-slider-track
                                class="flex transition-transform duration-500 ease-in-out"
                                style="transform: translateX(0%);"
                            >
                                @foreach($group['items'] as $item)
                                    <div class="w-full shrink-0 flex items-center justify-center p-3 sm:p-4" style="background: {{ $gradients[$loop->index % count($gradients)] }};">
                                        <div class="flex h-[360px] sm:h-[420px] w-full items-center justify-center">
                                            <img
                                                src="{{ $item->image_data }}"
                                                alt="{{ $item->caption ?? $group['title'] }}"
                                                loading="lazy"
                                                class="h-full w-full rounded-lg object-contain pointer-events-none"
                                            />
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Floating Overlay Buttons Directly On Image --}}
                            <button
                                type="button"
                                data-slider-prev
                                aria-label="Previous slide"
                                class="absolute left-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-black shadow-md border border-gray-200 backdrop-blur-sm transition-all hover:bg-white hover:scale-105 active:scale-95 z-10"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"/>
                                </svg>
                            </button>

                            <button
                                type="button"
                                data-slider-next
                                aria-label="Next slide"
                                class="absolute right-3 top-1/2 -translate-y-1/2 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-black shadow-md border border-gray-200 backdrop-blur-sm transition-all hover:bg-white hover:scale-105 active:scale-95 z-10"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 6 6 6-6 6"/>
                                </svg>
                            </button>

                            {{-- Bottom Indicators (Dots) On Image --}}
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-10 bg-black/40 backdrop-blur-sm px-2.5 py-1 rounded-full">
                                @foreach($group['items'] as $index => $item)
                                    <button
                                        type="button"
                                        data-slider-dot="{{ $index }}"
                                        aria-label="Go to slide {{ $index + 1 }}"
                                        class="h-2 w-2 rounded-full transition-all {{ $index === 0 ? 'bg-white w-4' : 'bg-white/50' }}"
                                    ></button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Information Bar --}}
                    
                </div>
            @endforeach
        </div>

    </div>
</section>

@once
<script>
    (function () {
        function setupSliders() {
            document.querySelectorAll('[data-slider-container]').forEach(function (container) {
                if (container.dataset.initialized === 'true') return;
                container.dataset.initialized = 'true';

                var track = container.querySelector('[data-slider-track]');
                var prevBtn = container.querySelector('[data-slider-prev]');
                var nextBtn = container.querySelector('[data-slider-next]');
                var counter = container.querySelector('[data-slider-counter]');
                var dots = container.querySelectorAll('[data-slider-dot]');

                if (!track) return;

                var slides = track.children;
                var total = slides.length;
                var currentIndex = 0;
                var autoSlideTimer = null;
                var intervalDelay = 3000; // Changes slide every 3 seconds

                function updateView() {
                    track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
                    
                    if (counter) {
                        counter.textContent = (currentIndex + 1) + ' / ' + total;
                    }

                    // Update dot indicators
                    dots.forEach(function (dot, index) {
                        if (index === currentIndex) {
                            dot.className = 'h-2 w-4 rounded-full bg-white transition-all';
                        } else {
                            dot.className = 'h-2 w-2 rounded-full bg-white/50 transition-all';
                        }
                    });
                }

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % total;
                    updateView();
                }

                function prevSlide() {
                    currentIndex = (currentIndex - 1 + total) % total;
                    updateView();
                }

                function startAutoPlay() {
                    stopAutoPlay();
                    if (total > 1) {
                        autoSlideTimer = setInterval(nextSlide, intervalDelay);
                    }
                }

                function stopAutoPlay() {
                    if (autoSlideTimer) {
                        clearInterval(autoSlideTimer);
                        autoSlideTimer = null;
                    }
                }

                // Event Listeners for Prev/Next Buttons
                prevBtn?.addEventListener('click', function (e) {
                    e.preventDefault();
                    prevSlide();
                    startAutoPlay(); // Reset timer on manual action
                });

                nextBtn?.addEventListener('click', function (e) {
                    e.preventDefault();
                    nextSlide();
                    startAutoPlay(); // Reset timer on manual action
                });

                // Dot click events
                dots.forEach(function (dot, idx) {
                    dot.addEventListener('click', function (e) {
                        e.preventDefault();
                        currentIndex = idx;
                        updateView();
                        startAutoPlay();
                    });
                });

                // Pause autoplay when cursor hovers over card, resume when leaves
                container.addEventListener('mouseenter', stopAutoPlay);
                container.addEventListener('mouseleave', startAutoPlay);

                // Initial run
                updateView();
                startAutoPlay();
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupSliders);
        } else {
            setupSliders();
        }
    })();
</script>
@endonce