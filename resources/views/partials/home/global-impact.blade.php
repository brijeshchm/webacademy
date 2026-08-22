{{-- GlobalImpactSection — port of src/components/GlobalImpactSection.tsx --}}
<section class="py-0 bg-white relative overflow-hidden">
 

  

    <div class="sm:hidden px-4 mt-6">
        <div class="flex gap-2.5 overflow-x-auto pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x">
            @foreach ($impactPins as $pin)
                <div class="flex items-center gap-2 shrink-0 snap-start bg-white rounded-xl shadow-md shadow-gray-200/70 border border-gray-100 px-2.5 py-2">
                    <img loading="lazy" decoding="async" src="/images/avatars/{{ $pin['name'] }}.webp" alt="" class="w-7 h-7 rounded-full object-cover ring-2 ring-white shadow-sm flex-shrink-0">
                    <div>
                        <p class="text-xs font-bold text-gray-900 leading-tight">{{ $pin['count'] }}</p>
                        <p class="text-[9px] text-gray-500 font-medium">{{ $pin['country'] }} hhh</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</section>
