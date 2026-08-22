{{-- Alumni logo wall — port of the Home.tsx alumni section (ca-marquee CSS) --}}
<section class="py-14 md:py-16 bg-gray-50 relative overflow-hidden border-y border-gray-100">
    <div class="px-4 md:px-6 relative z-10">
        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">{{ t('homeX.trustedByAt') }}</p>
            <h2 class="text-3xl md:text-4xl font-display font-extrabold">
                <span class="text-transparent bg-clip-text bg-[linear-gradient(90deg,#1e3a8a,#1d4ed8,#2563eb,#38bdf8)] ca-gradient-pan">{{ t('home.alumniWorkAt') }}</span>
            </h2>
        </div>
    </div>
    <ul class="sr-only">
        @foreach ($alumni as $c)
            <li>{{ $c['name'] }}</li>
        @endforeach
    </ul>
    <div class="ca-marquee-group relative space-y-4" aria-hidden="true">
        <div class="pointer-events-none absolute inset-y-0 left-0 w-16 md:w-32 bg-gradient-to-r from-background to-transparent z-10"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-16 md:w-32 bg-gradient-to-l from-background to-transparent z-10"></div>
        @foreach ($alumniRows as $rowIdx => $row)
            <div class="flex overflow-hidden">
                <div class="flex shrink-0 items-center gap-3 pr-3 {{ $rowIdx === 0 ? 'ca-marquee' : 'ca-marquee-rev' }}">
                    @foreach (array_merge($row, $row) as $i => $c)
                        <span class="inline-flex shrink-0 items-center gap-2.5 whitespace-nowrap rounded-xl border border-border bg-card px-5 py-3 shadow-sm transition-colors hover:border-primary/40">
                            <img src="/images/logos/{{ $c['slug'] }}.svg" alt="" class="h-6 w-6 object-contain" loading="lazy" decoding="async">
                            <span class="text-base font-display font-semibold text-foreground/70">{{ $c['name'] }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
