{{-- WhySection — port of src/components/WhySection.tsx (tilt/animation degrade gracefully) --}}
<section class="relative overflow-hidden py-10 bg-white border-t border-gray-100">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[480px] h-[480px] rounded-full bg-rose-200/40 blur-[100px]"></div>
        <div class="absolute -bottom-32 -right-32 w-[480px] h-[480px] rounded-full bg-violet-200/40 blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full bg-sky-100/50 blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.035]" style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px); background-size: 28px 28px;"></div>
    </div>

    <div class="px-4 md:px-6 relative z-10">
        <div class="max-w-2xl mx-auto text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-primary/8 border border-primary/15 text-primary px-4 py-1.5 rounded-full text-sm font-medium mb-5">
                <svg class="w-3.5 h-3.5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>
                {{ t('home.whyEyebrow') }}
            </span>
            <h2 class="text-3xl md:text-4xl font-display font-black leading-[1.08] mb-3 text-gray-900">{{ t('home.whyTitle') }}</h2>
            <p class="text-base text-gray-500 leading-relaxed max-w-md mx-auto">{{ t('home.whySubtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-6xl mx-auto">
            @foreach ($whyCards as $card)
                <div style="perspective: 1000px">
                    <div class="group relative rounded-2xl overflow-hidden cursor-pointer h-full bg-white border {{ $card['borderColor'] }} {{ $card['hoverBorder'] }} shadow-sm hover:shadow-xl transition-all duration-400">
                        <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-transparent {{ $card['borderClass'] }} to-transparent opacity-70 group-hover:opacity-100 transition-opacity duration-400"></div>
                        <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full {{ $card['glowClass'] }} blur-2xl opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 ease-in-out bg-gradient-to-r from-transparent via-white/60 to-transparent pointer-events-none"></div>
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" style="box-shadow: inset 0 0 40px {{ $card['shadowColor'] }}"></div>
                        <div class="relative p-4 flex items-start gap-3.5">
                            <div class="shrink-0">
                                <div class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br {{ $card['gradientClass'] }} shadow-md">
                                    @switch($card['icon'])
                                        @case('grad')
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                            @break
                                        @case('rocket')
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                                            @break
                                        @case('trending')
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/></svg>
                                            @break
                                        @default
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                                    @endswitch
                                </div>
                            </div>
                            <div class="min-w-0 pt-0.5">
                                <h3 class="text-[14px] font-display font-bold mb-1 text-gray-900 group-hover:{{ $card['textAccent'] }} transition-colors duration-300">{{ t($card['titleKey']) }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ t($card['descKey']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
