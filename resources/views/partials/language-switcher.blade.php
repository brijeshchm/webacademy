@php
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
    $lngUrl = function (string $code) {
        $params = request()->query();
        $params['lng'] = $code;
        return url('/' . ltrim(request()->path(), '/')) . '?' . http_build_query($params);
    };
@endphp
<div class="relative" data-lang-switcher>
    <button type="button" data-lang-toggle aria-label="{{ t('common.switchLanguage') }}" class="group w-9 h-9 rounded-full bg-background/50 backdrop-blur border border-border/50 hover:bg-primary/10 hover:text-primary transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 hover:shadow-sm hover:shadow-primary/10 text-[11px] font-bold tracking-wide flex items-center justify-center">
        {{ strtoupper($activeLng) }}
    </button>
    <div data-lang-panel class="hidden absolute end-0 mt-2 min-w-[10rem] rounded-md bg-background/80 backdrop-blur-xl border border-border/50 shadow-xl p-1 z-[70]">
        @foreach ($languages as $lang)
            @php $isActive = $activeLng === $lang['code']; @endphp
            <a href="{{ $lngUrl($lang['code']) }}" class="cursor-pointer flex items-center justify-between gap-3 rounded-sm px-3 py-1.5 text-sm transition-all duration-200 hover:translate-x-0.5 rtl:hover:-translate-x-0.5 hover:bg-primary/5 {{ $isActive ? 'bg-primary/10 text-primary font-medium' : 'text-foreground' }}">
                <span>{{ $lang['name'] }}</span>
                @if ($isActive)
                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                @endif
            </a>
        @endforeach
    </div>
</div>
