{{--
    Country-code phone field mirroring the React PhoneInput component:
    a flag + dial-code selector next to the local-number input.

    The visible tel input keeps name="phone"; on submit, app.js prepends the
    selected dial code (e.g. "+91 9876543210") so the leads API payload is
    identical to the React app's. Without JS, the plain number submits as-is.

    Props:
      $inputClass    — classes for the tel input (page-specific styling)
      $selectClass   — optional extra classes for the dial-code select
      $id            — optional input id
      $required      — bool, default true
      $placeholder   — optional placeholder (default matches React: 98765 43210)
      $value         — optional old value
      $testId        — optional data-testid for the input
--}}
@php
    $countries = \App\Data\CountryDialCodes::all();
    $required = $required ?? true;
    $placeholder = $placeholder ?? '98765 43210';
    $value = $value ?? '';
    $selectClass = $selectClass ?? '';
@endphp
<div class="flex gap-2" data-phone-group>
    <div class="relative shrink-0">
        <select data-phone-dial aria-label="{{ t('common.countryCode') }}"
            class="appearance-none h-10 rounded-xl border border-input bg-background ps-2.5 pe-7 text-sm font-medium hover:bg-accent/50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring {{ $selectClass }}">
            @foreach ($countries as $c)
                <option value="{{ $c['dial'] }}" @selected($c['iso'] === 'IN')>{{ $c['flag'] }} {{ $c['dial'] }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute end-2 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
    </div>
    <input @isset($id) id="{{ $id }}" @endisset name="phone" type="tel" inputmode="tel" autocomplete="tel-national"
        @if ($required) required @endif
        placeholder="{{ $placeholder }}" value="{{ $value }}"
        @isset($testId) data-testid="{{ $testId }}" @endisset
        class="flex-1 min-w-0 {{ $inputClass }}">
</div>
