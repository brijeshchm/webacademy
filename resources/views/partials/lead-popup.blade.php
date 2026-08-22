<div data-lead-popup data-lead-error="{{ t('popup.emailRequired') }}"
    class="hidden fixed inset-0 z-[60] items-end sm:items-center justify-center sm:p-4 bg-black/60 backdrop-blur-sm">
    <div data-lead-panel class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden">
        {{-- Gradient top bar (recolored per step by app.js) --}}
        <div data-lead-bar class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-primary transition-all duration-700"></div>

        {{-- Close --}}
        <button type="button" data-lead-close aria-label="Close"
            class="absolute top-4 end-4 w-8 h-8 rounded-full bg-muted/60 hover:bg-muted flex items-center justify-center transition-colors z-10">
            <svg class="w-4 h-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="px-6 pt-5 pb-7">
            {{-- ── Success state (hidden until submit succeeds) ── --}}
            <div data-lead-success class="hidden flex-col items-center py-8 text-center gap-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-indigo-500 flex items-center justify-center shadow-xl shadow-primary/30">
                        <svg class="w-9 h-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path></svg>
                    </div>
                    <div class="absolute -top-1 -end-1 w-6 h-6 rounded-full bg-green-500 border-2 border-white flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-black text-foreground mb-1">{{ t('popup.successTitle') }}</h3>
                    <p data-lead-success-body data-template="{{ t('popup.successBody', ['name' => '__NAME__']) }}" class="text-sm text-muted-foreground leading-relaxed max-w-xs"></p>
                </div>
                <div class="flex items-center gap-2 bg-green-50 border border-green-100 rounded-xl px-4 py-2.5 text-xs text-green-700 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span data-lead-success-inbox data-template="{{ t('popup.checkInbox', ['email' => '__EMAIL__']) }}"></span>
                </div>
            </div>

            {{-- ── Wizard ── --}}
            <div data-lead-wizard>
                {{-- Brand header --}}
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-[linear-gradient(135deg,#1e3a8a,#2563eb,#38bdf8)] flex items-center justify-center shadow-md shadow-primary/30 shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-primary/60">{{ t('popup.brandEyebrow') }}</p>
                        <h3 class="text-[15px] font-bold text-foreground leading-tight">{{ t('popup.title') }}</h3>
                    </div>
                </div>

                {{-- Step bar --}}
                <div class="flex items-center gap-0 mb-6">
                    @foreach ([
                        '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>',
                        '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/>',
                        '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
                    ] as $i => $icon)
                        <div class="flex items-center flex-1">
                            <div data-lead-step-dot="{{ $i }}" class="flex items-center justify-center w-7 h-7 rounded-full border-2 shrink-0 transition-all duration-300 border-muted-foreground/20 text-muted-foreground/30">
                                <svg data-lead-step-check class="hidden w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                <svg data-lead-step-icon class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg>
                            </div>
                            @if ($i < 2)
                                <div data-lead-step-line="{{ $i }}" class="h-[2px] flex-1 mx-1 rounded-full transition-all duration-500 bg-muted-foreground/15"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Step labels --}}
                @foreach (['stepAboutYou', 'stepBackground', 'stepGoals'] as $i => $labelKey)
                    <p data-lead-step-label="{{ $i }}" class="{{ $i === 0 ? '' : 'hidden ' }}text-[11px] font-semibold uppercase tracking-widest text-primary/60 mb-4">
                        {{ t('popup.stepLabel', ['current' => $i + 1, 'label' => t('popup.' . $labelKey)]) }}
                    </p>
                @endforeach

                <form data-lead-form method="POST" action="{{ route('leads.store') }}" novalidate>
                    @csrf
                    {{-- Step 1: About you --}}
                    <div data-lead-step="0" class="space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.fullName') }}<span class="text-red-400">*</span></label>
                            <input name="name" type="text" autocomplete="name" placeholder="{{ t('popup.namePlaceholder') }}" data-testid="input-popup-name"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <p data-lead-err="name" class="hidden text-[11px] text-red-500 mt-1">{{ t('popup.nameRequired') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.emailAddress') }}<span class="text-red-400">*</span></label>
                            <input name="email" type="email" autocomplete="email" placeholder="{{ t('popup.emailPlaceholder') }}" data-testid="input-popup-email"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <p data-lead-err="email" class="hidden text-[11px] text-red-500 mt-1">{{ t('popup.emailRequired') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.phoneNumber') }}</label>
                            @include('partials.phone-input', ['required' => false, 'testId' => 'input-popup-phone', 'inputClass' => 'h-11 rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary', 'selectClass' => 'h-11'])
                        </div>
                    </div>

                    {{-- Step 2: Background --}}
                    <div data-lead-step="1" class="hidden space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.yourAge') }}</label>
                            <input data-lead-age type="number" min="16" max="70" placeholder="{{ t('popup.agePlaceholder') }}" data-testid="input-popup-age"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.yearsExperience') }}</label>
                            <select data-lead-experience data-testid="select-popup-experience"
                                class="w-full h-11 rounded-xl border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                <option value="">{{ t('popup.selectExperience') }}</option>
                                <option value="Fresher (0 years)">{{ t('popup.expFresher') }}</option>
                                <option value="0-1 years">{{ t('popup.exp01') }}</option>
                                <option value="1-3 years">{{ t('popup.exp13') }}</option>
                                <option value="3-5 years">{{ t('popup.exp35') }}</option>
                                <option value="5-10 years">{{ t('popup.exp510') }}</option>
                                <option value="10+ years">{{ t('popup.exp10plus') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Step 3: Goals --}}
                    <div data-lead-step="2" class="hidden space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.courseInterest') }}</label>
                            <select data-lead-course data-testid="select-popup-course"
                                class="w-full h-11 rounded-xl border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                <option value="">{{ t('popup.selectCourse') }}</option>
                                <option value="Data Science & Machine Learning">{{ t('popup.courseDataScience') }}</option>
                                <option value="Cloud Computing & DevOps">{{ t('popup.courseCloud') }}</option>
                                <option value="Web & Software Development">{{ t('popup.courseWeb') }}</option>
                                <option value="Agile & Project Management">{{ t('popup.courseAgile') }}</option>
                                <option value="Workday & Enterprise Platforms">{{ t('popup.courseWorkday') }}</option>
                                <option value="Cybersecurity">{{ t('popup.courseCyber') }}</option>
                                <option value="Artificial Intelligence">{{ t('popup.courseAI') }}</option>
                                <option value="Other">{{ t('popup.courseOther') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.anythingElse') }}</label>
                            <textarea data-lead-message rows="3" placeholder="{{ t('popup.messagePlaceholder') }}" data-testid="textarea-popup-message"
                                class="w-full rounded-xl border border-input bg-background px-3 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"></textarea>
                        </div>
                    </div>

                    {{-- Composed server payload (filled by app.js before submit) --}}
                    <input type="hidden" name="message" data-lead-hidden-message>

                    {{-- CTA --}}
                    <button type="submit" data-lead-cta data-testid="button-popup-submit"
                        data-label-continue="{{ t('popup.continue') }}" data-label-submit="{{ t('popup.submit') }}" data-label-submitting="{{ t('popup.submitting') }}"
                        class="w-full h-11 mt-5 rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 shadow-lg shadow-primary/25 font-semibold transition-transform duration-200 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:pointer-events-none flex items-center justify-center gap-2">
                        <span data-lead-cta-text>{{ t('popup.continue') }}</span>
                        <svg data-lead-cta-arrow class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </button>

                    <p class="text-center text-[11px] text-muted-foreground mt-3">{{ t('popup.privacy') }}</p>
                </form>
            </div>
        </div>
    </div>
</div>




<div data-enquery-popup data-lead-error="{{ t('popup.emailRequired') }}"
    class="hidden fixed inset-0 z-[60] items-end sm:items-center justify-center sm:p-4 bg-black/60 backdrop-blur-sm">
    <div data-lead-panel class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden">
        {{-- Gradient top bar (recolored per step by app.js) --}}
        <div data-lead-bar class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-primary transition-all duration-700"></div>

        {{-- Close --}}
        <button type="button" data-lead-close aria-label="Close"
            class="absolute top-4 end-4 w-8 h-8 rounded-full bg-muted/60 hover:bg-muted flex items-center justify-center transition-colors z-10">
            <svg class="w-4 h-4 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="px-6 pt-5 pb-7">
            {{-- ── Success state (hidden until submit succeeds) ── --}}
            <div data-lead-success class="hidden flex-col items-center py-8 text-center gap-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-indigo-500 flex items-center justify-center shadow-xl shadow-primary/30">
                        <svg class="w-9 h-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path></svg>
                    </div>
                    <div class="absolute -top-1 -end-1 w-6 h-6 rounded-full bg-green-500 border-2 border-white flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-black text-foreground mb-1">{{ t('popup.successTitle') }}</h3>
                    <p data-lead-success-body data-template="{{ t('popup.successBody', ['name' => '__NAME__']) }}" class="text-sm text-muted-foreground leading-relaxed max-w-xs"></p>
                </div>
                <div class="flex items-center gap-2 bg-green-50 border border-green-100 rounded-xl px-4 py-2.5 text-xs text-green-700 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span data-lead-success-inbox data-template="{{ t('popup.checkInbox', ['email' => '__EMAIL__']) }}"></span>
                </div>
            </div>

            {{-- ── Wizard ── --}}
            <div data-lead-wizard>
                {{-- Brand header --}}
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-[linear-gradient(135deg,#1e3a8a,#2563eb,#38bdf8)] flex items-center justify-center shadow-md shadow-primary/30 shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"></path><path d="M22 10v6"></path><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-primary/60">{{ t('popup.brandEyebrow') }}</p>
                        <h3 class="text-[15px] font-bold text-foreground leading-tight">{{ t('popup.title') }}</h3>
                    </div>
                </div>

                {{-- Step bar --}}
                <div class="flex items-center gap-0 mb-6">
                    @foreach ([
                        '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>',
                        '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/>',
                        '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
                    ] as $i => $icon)
                        <div class="flex items-center flex-1">
                            <div data-lead-step-dot="{{ $i }}" class="flex items-center justify-center w-7 h-7 rounded-full border-2 shrink-0 transition-all duration-300 border-muted-foreground/20 text-muted-foreground/30">
                                <svg data-lead-step-check class="hidden w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                <svg data-lead-step-icon class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg>
                            </div>
                            @if ($i < 2)
                                <div data-lead-step-line="{{ $i }}" class="h-[2px] flex-1 mx-1 rounded-full transition-all duration-500 bg-muted-foreground/15"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Step labels --}}
                @foreach (['stepAboutYou', 'stepBackground', 'stepGoals'] as $i => $labelKey)
                    <p data-lead-step-label="{{ $i }}" class="{{ $i === 0 ? '' : 'hidden ' }}text-[11px] font-semibold uppercase tracking-widest text-primary/60 mb-4">
                        {{ t('popup.stepLabel', ['current' => $i + 1, 'label' => t('popup.' . $labelKey)]) }}
                    </p>
                @endforeach

                <form data-lead-form method="POST" action="{{ route('leads.store') }}" novalidate>
                    @csrf
                    {{-- Step 1: About you --}}
                    <div data-lead-step="0" class="space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.fullName') }}<span class="text-red-400">*</span></label>
                            <input name="name" type="text" autocomplete="name" placeholder="{{ t('popup.namePlaceholder') }}" data-testid="input-popup-name"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <p data-lead-err="name" class="hidden text-[11px] text-red-500 mt-1">{{ t('popup.nameRequired') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.emailAddress') }}<span class="text-red-400">*</span></label>
                            <input name="email" type="email" autocomplete="email" placeholder="{{ t('popup.emailPlaceholder') }}" data-testid="input-popup-email"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <p data-lead-err="email" class="hidden text-[11px] text-red-500 mt-1">{{ t('popup.emailRequired') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.phoneNumber') }}</label>
                            @include('partials.phone-input', ['required' => false, 'testId' => 'input-popup-phone', 'inputClass' => 'h-11 rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary', 'selectClass' => 'h-11'])
                        </div>
                    </div>

                    {{-- Step 2: Background --}}
                    <div data-lead-step="1" class="hidden space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 flex gap-1">{{ t('popup.yourAge') }}</label>
                            <input data-lead-age type="number" min="16" max="70" placeholder="{{ t('popup.agePlaceholder') }}" data-testid="input-popup-age"
                                class="h-11 w-full rounded-xl border border-input bg-background px-3 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.yearsExperience') }}</label>
                            <select data-lead-experience data-testid="select-popup-experience"
                                class="w-full h-11 rounded-xl border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                <option value="">{{ t('popup.selectExperience') }}</option>
                                <option value="Fresher (0 years)">{{ t('popup.expFresher') }}</option>
                                <option value="0-1 years">{{ t('popup.exp01') }}</option>
                                <option value="1-3 years">{{ t('popup.exp13') }}</option>
                                <option value="3-5 years">{{ t('popup.exp35') }}</option>
                                <option value="5-10 years">{{ t('popup.exp510') }}</option>
                                <option value="10+ years">{{ t('popup.exp10plus') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Step 3: Goals --}}
                    <div data-lead-step="2" class="hidden space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.courseInterest') }}</label>
                            <select data-lead-course data-testid="select-popup-course"
                                class="w-full h-11 rounded-xl border border-input bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors">
                                <option value="">{{ t('popup.selectCourse') }}</option>
                                <option value="Data Science & Machine Learning">{{ t('popup.courseDataScience') }}</option>
                                <option value="Cloud Computing & DevOps">{{ t('popup.courseCloud') }}</option>
                                <option value="Web & Software Development">{{ t('popup.courseWeb') }}</option>
                                <option value="Agile & Project Management">{{ t('popup.courseAgile') }}</option>
                                <option value="Workday & Enterprise Platforms">{{ t('popup.courseWorkday') }}</option>
                                <option value="Cybersecurity">{{ t('popup.courseCyber') }}</option>
                                <option value="Artificial Intelligence">{{ t('popup.courseAI') }}</option>
                                <option value="Other">{{ t('popup.courseOther') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-foreground/70 mb-1.5 block">{{ t('popup.anythingElse') }}</label>
                            <textarea data-lead-message rows="3" placeholder="{{ t('popup.messagePlaceholder') }}" data-testid="textarea-popup-message"
                                class="w-full rounded-xl border border-input bg-background px-3 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"></textarea>
                        </div>
                    </div>

                    {{-- Composed server payload (filled by app.js before submit) --}}
                    <input type="hidden" name="message" data-lead-hidden-message>

                    {{-- CTA --}}
                    <button type="submit" data-lead-cta data-testid="button-popup-submit"
                        data-label-continue="{{ t('popup.continue') }}" data-label-submit="{{ t('popup.submit') }}" data-label-submitting="{{ t('popup.submitting') }}"
                        class="w-full h-11 mt-5 rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 shadow-lg shadow-primary/25 font-semibold transition-transform duration-200 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:pointer-events-none flex items-center justify-center gap-2">
                        <span data-lead-cta-text>{{ t('popup.continue') }}</span>
                        <svg data-lead-cta-arrow class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </button>

                    <p class="text-center text-[11px] text-muted-foreground mt-3">{{ t('popup.privacy') }}</p>
                </form>
            </div>
        </div>
    </div>
</div>
