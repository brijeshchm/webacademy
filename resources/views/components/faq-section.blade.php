@props([
    'title',
    'subtitle' => null,
    'faqs' => [],
    'class' => '',
])
@php
    $faqs = is_array($faqs) ? $faqs : (array) $faqs;
@endphp
@if(count($faqs))
<section {{ $attributes->merge(['class' => 'py-16 md:py-20 bg-white ' . $class]) }}>
    <div class="mx-auto max-w-4xl px-4 md:px-6">
        <h2 class="text-2xl md:text-3xl font-display font-extrabold text-foreground mb-2">{{ $title }}</h2>
        @if($subtitle)
            <p class="text-sm text-muted-foreground mb-8">{{ $subtitle }}</p>
        @endif
        <div class="flex flex-col gap-3 {{ $subtitle ? '' : 'mt-6' }}">
            @foreach($faqs as $f)
                <details class="group border rounded-xl overflow-hidden transition-colors border-gray-100 bg-white open:border-primary/30 open:bg-primary/[0.02]">
                    <summary class="w-full flex items-center justify-between px-5 py-4 text-start gap-3 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                        <span class="text-sm font-bold text-foreground leading-snug">{{ $f['question'] }}</span>
                        <svg class="h-4 w-4 text-muted-foreground shrink-0 group-open:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        <svg class="h-4 w-4 text-primary shrink-0 hidden group-open:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
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
