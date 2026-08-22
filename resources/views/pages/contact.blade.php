@extends('layouts.app')

@php
    $origin = rtrim(config('services.site.origin'), '/');
    $title = 'Contact Us';
    $desc = 'Get in touch with the Corporate Academy team. We answer enquiries within 24 hours and offer group pricing for teams of 5 or more.';
    $canonical = $origin . '/contact';
    $ogImage = $origin . '/api/og-image';

    $contactJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'url' => $origin . '/contact',
        'name' => 'Contact Corporate Academy',
        'description' => 'Contact the Corporate Academy team for course enquiries, group pricing, and corporate training.',
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => 'Corporate Academy',
            'url' => $origin,
            'telephone' => '+91-88001-82225',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+91-88001-82225',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Hindi'],
                'hoursAvailable' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'opens' => '09:00',
                    'closes' => '19:00',
                ],
            ],
        ],
    ];
@endphp
@section('title', ' Contact us |  Corporate Academy')
@section('description', 'Corporate Academy trains professionals at every stage — from individual contributors to enterprise teams. 63,000+ professionals trained, 92% placement rate, industry-expert faculty.')
@push('schema')
<script type="application/ld+json">{!! json_ld($contactJsonLd) !!}</script>
@endpush
@section('content')
<main class="relative min-h-[100dvh] overflow-hidden bg-background pb-20 text-foreground md:pb-28">
    <div class="pointer-events-none absolute -right-40 -top-48 h-[620px] w-[620px] rounded-full bg-primary/10 blur-3xl ca-float"></div>
    <div class="pointer-events-none absolute -bottom-56 -left-48 h-[560px] w-[560px] rounded-full bg-secondary/15 blur-3xl ca-float-slow"></div>
    <div class="pointer-events-none absolute left-[46%] top-[36%] h-32 w-32 rounded-full border border-primary/10"></div>
    <div class="pointer-events-none absolute left-[calc(46%+24px)] top-[calc(36%+24px)] h-20 w-20 rounded-full border border-primary/10"></div>

    <section class="relative z-10 border-b border-primary/10">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 pb-14 pt-12 sm:px-8 md:grid-cols-[1.08fr_0.92fr] md:items-end md:gap-16 md:px-12 md:pb-20 md:pt-20 lg:px-16">
            <div>
                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-3.5 py-2 text-[11px] font-bold uppercase tracking-[0.18em] text-primary">
                    <span class="h-1.5 w-1.5 rounded-full bg-primary ca-glow"></span>
                    {{ t('contactX.eyebrow') }}
                </div>
                <h1 class="max-w-3xl font-display text-5xl font-bold leading-[0.98] tracking-[-0.045em] text-foreground sm:text-6xl md:text-7xl">
                    {{ t('contactX.heroTitle1') }}
                    <span class="mt-2 block text-primary">{{ t('contactX.heroTitle2') }}</span>
                </h1>
            </div>

            <div class="md:pb-1">
                <p class="max-w-md text-lg leading-8 text-muted-foreground">
                    {{ t('contact.contactTeamDesc') }}
                </p>
                <div class="mt-7 flex items-center gap-3 text-sm font-semibold text-foreground">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-primary-foreground">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </span>
                    <span>{{ t('contactX.mapTheWay') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 mx-auto max-w-7xl px-5 pt-10 sm:px-8 md:px-12 md:pt-16 lg:px-16">
        <div class="grid gap-8 lg:grid-cols-[0.82fr_1.18fr] lg:gap-14">
            <div class="self-start">
                <div class="mb-6 flex items-end justify-between gap-4">
                    <div>
                        <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-primary">{{ t('contactX.connectStep') }}</p>
                        <h2 class="font-display text-3xl font-bold tracking-[-0.03em]">{{ t('contact.getInTouch') }}</h2>
                    </div>
                    <div class="hidden h-px flex-1 bg-primary/15 sm:block"></div>
                </div>

                <div class="space-y-3">
                    <a href="mailto:corporatesacademy2@gmail.com" data-testid="link-contact-email"
                        class="group block rounded-2xl border border-primary/10 bg-card/70 p-5 shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:bg-card hover:shadow-lg hover:shadow-primary/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary transition-colors group-hover:bg-primary group-hover:text-primary-foreground">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-10 5L2 7"></path></svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-base font-bold">{{ t('contact.emailUs') }}</span>
                                <span class="mt-1 block text-sm leading-6 text-muted-foreground">{{ t('contact.emailUsDesc') }}</span>
                                <span class="mt-3 flex items-center gap-1 text-sm font-bold text-primary">
                                    corporatesacademy2@gmail.com
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg>
                                </span>
                            </span>
                        </div>
                    </a>

                    <div class="rounded-2xl border border-primary/10 bg-card/70 p-5 shadow-sm backdrop-blur-sm">
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </span>
                            <div>
                                <h3 class="text-base font-bold">{{ t('contact.callUs') }}</h3>
                                <p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t('contact.callUsDesc') }}</p>
                                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                                    <a href="tel:+918800182225" data-testid="link-contact-phone" class="text-sm font-bold text-primary underline-offset-4 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                        +91 8800182225
                                    </a>
                                    <a href="https://wa.me/918800182225" target="_blank" rel="noopener noreferrer" data-testid="link-contact-whatsapp"
                                        class="inline-flex items-center gap-1.5 text-sm font-bold text-[#147d68] underline-offset-4 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"></path></svg>
                                        {{ t('contactX.whatsappUs') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-primary/10 bg-card/70 p-5 shadow-sm backdrop-blur-sm">
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </span>
                            <div>
                                <h3 class="text-base font-bold">{{ t('contact.visitUs') }}</h3>
                                <p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t('contact.visitUsDesc') }}</p>
                                <address class="mt-4 grid gap-4 text-sm leading-6 not-italic text-foreground/80 sm:grid-cols-2">
                                    <span><strong class="text-foreground">Corporate Academy Official</strong><br>G-13, Sector-3, Noida, India</span>
                                    <span><strong class="text-foreground">{{ t('contactX.officeHeadBranch') }}</strong><br>1,2,3,4 Badarpur, New Delhi 110044, India</span>
                                    <span><strong class="text-foreground">{{ t('contactX.officeInternational') }}</strong><br>Limbecker Platz 7, 45147 Essen, Germany<br>212, Burlington Tower, Business Bay, Dubai</span>
                                    <span><strong class="text-foreground">{{ t('contactX.officeRegistration') }}</strong><br>Building No. H-324, Faridabad, Haryana 121003, India</span>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="mailto:corporatesacademy2@gmail.com?subject=Enterprise%20training%20enquiry" data-testid="link-enterprise-sales"
                    class="group mt-6 block rounded-2xl bg-primary p-5 text-primary-foreground shadow-xl shadow-primary/20 transition-transform duration-300 hover:-translate-y-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="mb-3 flex items-center gap-2 text-primary-foreground/75">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg>
                                <span class="text-xs font-bold uppercase tracking-[0.15em]">{{ t('contactX.forTeams') }}</span>
                            </div>
                            <h3 class="font-display text-xl font-bold">{{ t('contact.enterpriseTraining') }}</h3>
                            <p class="mt-2 max-w-sm text-sm leading-6 text-primary-foreground/75">{{ t('contact.enterpriseTrainingDesc') }}</p>
                            <span class="mt-4 inline-flex items-center gap-2 text-sm font-bold">
                                {{ t('contact.contactEnterpriseSales') }}
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg>
                            </span>
                        </div>
                        <span class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-full border border-primary-foreground/25 sm:flex">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h10v10"></path><path d="M7 17 17 7"></path></svg>
                        </span>
                    </div>
                </a>
            </div>

            <div class="relative">
                <div class="absolute -inset-2 rounded-[2rem] bg-primary/5 blur-xl" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-[1.75rem] border border-primary/15 bg-card p-6 shadow-2xl shadow-primary/10 sm:p-9 md:p-10">
                    <div class="mb-8 flex items-start justify-between gap-5 border-b border-border pb-6">
                        <div>
                            <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-primary">{{ t('contactX.yourMessageStep') }}</p>
                            <h2 class="font-display text-3xl font-bold tracking-[-0.03em]">{{ t('contact.sendMessage') }}</h2>
                            <p class="mt-2 max-w-md text-sm leading-6 text-muted-foreground">{{ t('contactX.realAdvisorReads') }}</p>
                        </div>
                        <div class="hidden h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary sm:flex">
                            <svg class="h-5 w-5 -rotate-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </div>
                    </div>

                    @if (session('success'))
                        <div data-testid="contact-success" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm leading-6 text-emerald-800">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
                            <span><strong class="block">{{ t('contact.success') }}</strong>{{ t('contact.successDesc') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('leads.store') }}" class="space-y-5 @if(session('success')) mt-5 @endif" aria-label="{{ t('contact.sendMessage') }}">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold">{{ t('contact.fullName') }}</label>
                                <input id="name" name="name" required autocomplete="name" placeholder="{{ t('contact.fullNamePlaceholder') }}" data-testid="input-contact-name" value="{{ old('name') }}"
                                    class="h-12 w-full rounded-xl border border-border bg-background px-4 transition-shadow placeholder:text-muted-foreground/70 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20">
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-bold">{{ t('contact.workEmail') }}</label>
                                <input id="email" name="email" type="email" required autocomplete="email" placeholder="{{ t('contact.workEmailPlaceholder') }}" data-testid="input-contact-email" value="{{ old('email') }}"
                                    class="h-12 w-full rounded-xl border border-border bg-background px-4 transition-shadow placeholder:text-muted-foreground/70 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-bold">{{ t('contact.phone') }}</label>
                            @include('partials.phone-input', ['id' => 'phone', 'required' => false, 'value' => old('phone'), 'testId' => 'input-contact-phone', 'inputClass' => 'h-12 w-full rounded-xl border border-border bg-background px-4 transition-shadow placeholder:text-muted-foreground/70 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20', 'selectClass' => 'h-12'])
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="text-sm font-bold">{{ t('contact.howCanWeHelp') }}</label>
                            <textarea id="message" name="message" required placeholder="{{ t('contact.howCanWeHelpPlaceholder') }}" data-testid="textarea-contact-message"
                                class="min-h-[154px] w-full resize-y rounded-xl border border-border bg-background px-4 py-3 transition-shadow placeholder:text-muted-foreground/70 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex items-start gap-3 rounded-xl bg-primary/5 px-4 py-3 text-xs leading-5 text-muted-foreground">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
                            <span>{{ t('contactX.privacyNote') }}</span>
                        </div>

                        <button type="submit" data-testid="button-contact-submit"
                            class="inline-flex h-14 w-full items-center justify-center rounded-xl bg-primary text-base font-bold text-primary-foreground shadow-lg shadow-primary/20 transition-transform duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-primary/25 active:translate-y-0">
                            {{ t('contact.sendMessageBtn') }}
                            <svg class="ml-2 h-5 w-5 rtl:ml-0 rtl:mr-2 rtl:-scale-x-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="relative z-10 mx-auto mt-16 max-w-7xl px-5 sm:px-8 md:mt-24 md:px-12 lg:px-16">
        <div class="grid gap-5 border-t border-primary/15 pt-7 sm:grid-cols-3 sm:gap-8">
            <div class="flex gap-3">
                <span class="font-display text-2xl font-bold text-primary">01</span>
                <div><p class="font-bold">{{ t('contactX.step1Title') }}</p><p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t('contactX.step1Desc') }}</p></div>
            </div>
            <div class="flex gap-3">
                <span class="font-display text-2xl font-bold text-primary">02</span>
                <div><p class="font-bold">{{ t('contactX.step2Title') }}</p><p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t('contactX.step2Desc') }}</p></div>
            </div>
            <div class="flex gap-3">
                <span class="font-display text-2xl font-bold text-primary">03</span>
                <div><p class="font-bold">{{ t('contactX.step3Title') }}</p><p class="mt-1 text-sm leading-6 text-muted-foreground">{{ t('contactX.step3Desc') }}</p></div>
            </div>
        </div>
    </div>
</main>
@endsection
