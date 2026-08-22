@php
    $year = date('Y');
    $arrowUpRight = '<svg aria-hidden="true" class="h-3.5 w-3.5 -translate-y-0.5 opacity-0 transition-opacity group-hover:opacity-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>';
@endphp
<footer class="relative overflow-hidden border-t border-primary/15 bg-[hsl(217_32%_93%)] text-foreground">

    {{-- Decorative layers ONLY — never put real content inside these, they're pointer-events-none and absolutely positioned --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-primary via-sky-400 to-primary ca-gradient-pan"></div>
    <div class="pointer-events-none absolute -right-28 -top-28 h-80 w-80 rounded-full bg-primary/10 blur-3xl ca-float-slow"></div>
    <div class="pointer-events-none absolute -bottom-36 left-1/4 h-96 w-96 rounded-full bg-sky-300/25 blur-3xl ca-float"></div>

    <div class="container relative z-10 mx-auto px-4 pb-8 pt-14 md:px-6 md:pt-20">
        <div class="grid grid-cols-1 gap-12 border-b border-primary/10 pb-12 md:grid-cols-2 lg:grid-cols-[1.35fr_0.8fr_0.8fr_1.2fr] lg:gap-10 lg:pb-14">
            <div class="space-y-6">
                <a href="/" aria-label="Corporate Academy home" class="group inline-flex items-center">
                    <img loading="lazy" decoding="async" src="/images/logo-academy.webp" alt="Corporates Academy" width="802" height="205" class="h-16 w-auto max-w-[260px] object-contain transition-transform duration-300 group-hover:scale-[1.03]">
                </a>
                <p class="max-w-sm text-sm leading-7 text-muted-foreground">{{ t('footer.empowering') }}</p>
                <div class="flex items-center gap-3 pt-1">
                    <a href="https://in.linkedin.com/company/corporatelearningofficial" target="_blank" rel="noopener noreferrer" aria-label="Corporate Academy on LinkedIn" class="flex h-10 w-10 items-center justify-center rounded-xl border border-primary/15 bg-card/70 text-muted-foreground shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:bg-primary hover:text-primary-foreground hover:shadow-md hover:shadow-primary/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                    </a>
                    <a href="https://www.instagram.com/corporatesacademyofficial/" target="_blank" rel="noopener noreferrer" aria-label="Corporate Academy on Instagram" class="flex h-10 w-10 items-center justify-center rounded-xl border border-primary/15 bg-card/70 text-muted-foreground shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:bg-primary hover:text-primary-foreground hover:shadow-md hover:shadow-primary/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                </div>
            </div>

            <div>
                <p class="mb-5 text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">{{ t('footer.programs') }}</p>
                <ul class="space-y-3.5">
                    <li><a href="{{ route('courses.show','aws-certification-training')}}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">AWS Certification {!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('courses.show','servicenow-training') }}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Servicenow Training{!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('courses.show','cloud-computing-training')}}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Cloud Computing {!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('courses.show','cybersecurity-training') }}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Cybersecurity Training{!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('courses')}}" class="group inline-flex items-center gap-1 text-sm font-semibold text-primary transition-colors hover:text-primary/75">{{ t('footer.viewAllCourses') }}{!! $arrowUpRight !!}<svg aria-hidden="true" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a></li>
                </ul>
            </div>

            <div>
                <p class="mb-5 text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">{{ t('footer.company') }}</p>
                <ul class="space-y-3.5">
                    <li><a href="{{ route('aboutUs') }}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">{{ t('footer.aboutUs') }}{!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('courses') }}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">{{ t('footer.learningPaths') }}{!! $arrowUpRight !!}</a></li>
                    <li><a href="{{ route('contactUs')}}" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">{{ t('footer.contactSupport') }}{!! $arrowUpRight !!}</a></li>
                    <li><a href="/blog" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Blog</a></li>

                    <li><a href="{{ route('privacy.policy') }}" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Privacy Policy {!! $arrowUpRight !!}</a></li>

                    <li><a href="{{ route('terms.conditions') }}" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Terms Conditions {!! $arrowUpRight !!}</a></li>

                    <li><a href="{{ route('refund.cancellation.policy') }}" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-1 text-sm text-muted-foreground transition-colors hover:text-primary">Refund Cancellation Policy {!! $arrowUpRight !!}</a></li>
                </ul>
            </div>

            <div class="rounded-2xl border border-primary/10 bg-card/80 p-5 shadow-[0_16px_40px_-28px_hsl(var(--primary)/0.45)] md:p-6">
                <p class="mb-5 text-[11px] font-bold uppercase tracking-[0.18em] text-primary/70">{{ t('footer.contact') }}</p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-sm leading-6 text-muted-foreground">
                        <svg aria-hidden="true" class="mt-0.5 h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>G-13, Sector-3, Noida, India<br>Head Branch: 1,2,3,4 Badarpur, New Delhi 110044</span>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-muted-foreground">
                        <svg aria-hidden="true" class="h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <a href="tel:+918800182225" class="transition-colors hover:text-primary">+91 8800182225</a>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-muted-foreground">
                        <svg aria-hidden="true" class="h-4 w-4 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <a href="https://wa.me/918800182225" target="_blank" rel="noopener noreferrer" class="transition-colors hover:text-primary">WhatsApp: +91 8800182225</a>
                    </li>
                    <li class="flex items-center gap-3 text-sm text-muted-foreground">
                        <svg aria-hidden="true" class="h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <a href="mailto:corporatesacademy2@gmail.com" class="break-all transition-colors hover:text-primary">corporatesacademy2@gmail.com</a>
                    </li>
                    <li class="flex items-start gap-3 text-sm leading-6 text-muted-foreground">
                        <svg aria-hidden="true" class="mt-0.5 h-4 w-4 shrink-0 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Germany: Limbecker Platz 7, 45147 Essen<br>Dubai: 212, Burlington Tower, Business Bay</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Courses in Top Cities — kept ONCE, for local SEO internal linking. Each city currently points to the same generic /courses URL. --}}
       
        <div class="border-t border-primary/10 pt-8 mb-8">
            <h4 class="text-sm font-bold mb-4 uppercase tracking-wide text-foreground flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4 text-primary" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Courses in Top Noida
            </h4>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-muted-foreground">

            @php
            $noidas = App\Models\Course::where('city','noida')->get();
            @endphp
@if($noidas)
@foreach($noidas as $noida)

 <a href="{{ route('courses.show',$noida->slug) }}" class="hover:text-primary transition-colors">{{ $noida->title }}</a> I
@endforeach
@endif
  
            </div>
        </div>


         <div class="border-t border-primary/10 pt-8 mb-8">
            <h4 class="text-sm font-bold mb-4 uppercase tracking-wide text-foreground flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4 text-primary" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Courses in Top Delhi
            </h4>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-muted-foreground">

            @php
            $delhis = App\Models\Course::where('city','delhi')->get();
            @endphp
@if($delhis)
@foreach($delhis as $delhi)

 <a href="{{ route('courses.show',$delhi->slug) }}" class="hover:text-primary transition-colors">{{ $delhi->title }}</a> I
@endforeach
@endif
  
            </div>
        </div>


         <div class="border-t border-primary/10 pt-8 mb-8">
            <h4 class="text-sm font-bold mb-4 uppercase tracking-wide text-foreground flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4 text-primary" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Courses in Top Bangalore 
            </h4>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-muted-foreground">

            @php
            $bangalores  = App\Models\Course::where('city','bangalore')->get();
            @endphp
@if($bangalores)
@foreach($bangalores as $bangalore)

 <a href="{{ route('courses.show',$bangalore->slug) }}" class="hover:text-primary transition-colors">{{ $bangalore->title }}</a> I
@endforeach
@endif
  
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 pt-7 text-center md:flex-row md:text-left">
            <p class="text-xs text-muted-foreground">&copy; {{ $year }} {{ t('footer.rightsReserved') }}</p>
            <div class="flex gap-5 text-xs text-muted-foreground">
                <a href="{{ route('privacy.policy') }}" class="transition-colors hover:text-primary">{{ t('footer.privacyPolicy') }}</a>
                <a href="{{ route('terms.conditions') }}" class="transition-colors hover:text-primary">{{ t('footer.termsOfService') }}</a>
            </div>
        </div>
    </div>
</footer>