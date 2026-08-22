{{-- VideoStories — port of src/components/VideoStories.tsx.
     Poster thumbnails are static; clicking a card opens the video via <a> to
     the raw file (no-JS graceful). Scroll arrows are horizontal-scroll anchors. --}}
<section class="py-24 bg-background relative overflow-hidden">
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10 mb-14">
        <div class="text-center">
            <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4 bg-primary/10 px-4 py-1.5 rounded-full">{{ t('home.videoStories') }}</span>
            <h2 class="text-3xl md:text-4xl font-display font-bold mb-4">{{ t('home.successStoriesTitle') }}</h2>
            <p class="text-muted-foreground text-lg max-w-xl mx-auto">{{ t('home.successStoriesSubtitle') }}</p>
        </div>
    </div>

    <div class="relative z-10">
        <div class="flex gap-4 overflow-x-auto scroll-smooth pb-4 px-12 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-video-scroll>
            @foreach ($videos as $i => $v)
                @php $gradient = $thumbGradients[$i % count($thumbGradients)]; @endphp
                <a href="{{ $v['src'] }}" target="_blank" rel="noopener" class="relative flex-none w-44 sm:w-52 cursor-pointer group">
                    <div class="relative rounded-2xl overflow-hidden aspect-[9/16] bg-foreground/10 border border-white/30 shadow-xl shadow-primary/10">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }}"></div>
                        <div class="absolute inset-0 opacity-25 [background-image:radial-gradient(circle_at_25%_20%,rgba(255,255,255,0.55),transparent_45%),radial-gradient(circle_at_80%_75%,rgba(255,255,255,0.3),transparent_40%)]"></div>
                        <svg class="absolute right-3 top-3 w-8 h-8 text-white/25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                        <div class="absolute inset-0 bg-gradient-to-t from-foreground/80 via-foreground/10 to-transparent"></div>
                        <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-white/90 backdrop-blur-md flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 group-hover:bg-primary group-hover:text-white">
                                <svg class="w-6 h-6 text-primary group-hover:text-white fill-current translate-x-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 inset-x-0 p-4">
                            <div class="text-xs font-semibold text-white/70 uppercase tracking-widest mb-1">{{ t('common.student') }}</div>
                            <div class="text-sm font-bold text-white leading-tight">{{ $v['label'] }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
