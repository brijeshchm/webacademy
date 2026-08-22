{{-- AssociationsSection — port of src/components/AssociationsSection.tsx --}}
@php
    $associations = [
        ['name' => 'Ministry of Corporate Affairs', 'file' => 'mca.jpg'],
        ['name' => 'Ministry of MSME', 'file' => 'msme.webp'],
        ['name' => 'NSDC', 'file' => 'nsdc.webp'],
        ['name' => 'Skill India', 'file' => 'skill-india.svg'],
        ['name' => 'Digital India', 'file' => 'digital-india.webp'],
        ['name' => 'ISO 27001', 'file' => 'iso.webp'],
        ['name' => 'IAF', 'file' => 'iaf.webp'],
        ['name' => 'Microsoft', 'file' => 'microsoft.svg'],
        ['name' => 'IBM', 'file' => 'ibm.svg'],
        ['name' => 'Google Analytics', 'file' => 'google-analytics.webp'],
        ['name' => 'MeitY', 'file' => 'meity.jpg'],
        ['name' => 'National Career Service', 'file' => 'ncs.jpg'],
    ];
@endphp
<section class="relative py-16 md:py-20 overflow-hidden bg-gradient-to-br from-[#3b0f7a] via-[#2d2a8e] to-[#1a1460]">
    <div class="pointer-events-none absolute top-0 left-1/4 w-[500px] h-[500px] rounded-full bg-purple-500/10 blur-[120px]"></div>
    <div class="pointer-events-none absolute bottom-0 right-1/4 w-[400px] h-[400px] rounded-full bg-indigo-400/10 blur-[100px]"></div>

    <div class="relative z-10 px-4 md:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display font-bold text-white tracking-tight mb-3">{{ t('home.proudAssociations') }}</h2>
            <div class="mx-auto w-16 h-1 rounded-full bg-primary"></div>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 md:gap-4 mb-10">
            @foreach ($associations as $a)
                <div class="group flex flex-col items-center justify-center bg-white rounded-2xl p-3 md:p-4 aspect-square shadow-lg transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <img src="/images/associations/{{ $a['file'] }}" alt="{{ $a['name'] }}" class="w-full h-full object-contain" loading="lazy" decoding="async">
                </div>
            @endforeach
        </div>

        <div class="flex justify-center">
            <div class="inline-flex items-center gap-2.5 bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold px-5 py-2.5 rounded-full shadow-lg">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                {{ t('home.verifiedPartnerships') }}
            </div>
        </div>
    </div>
</section>
