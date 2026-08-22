{{-- SocialProofSection — port of src/components/SocialProofSection.tsx
     Returns nothing when there is no WhatsApp/proof data (matches React early return). --}}
@if ($hasWA || $hasProofs)
<section class="py-20 relative overflow-hidden bg-gradient-to-br from-[hsl(217_91%_12%)] via-[hsl(214_85%_16%)] to-[hsl(210_80%_20%)]">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-[600px] h-[600px] rounded-full bg-primary/20 blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] rounded-full bg-blue-400/10 blur-[100px]"></div>
    </div>
    <div class="absolute inset-0 pointer-events-none opacity-[0.04]" style="background-image: radial-gradient(circle,white 1px,transparent 1px); background-size: 32px 32px;"></div>

    <div class="relative z-10 px-4 md:px-6 max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs font-semibold uppercase tracking-widest text-white/70">{{ t('home.proofSection') }}</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-display font-black text-white mb-3 leading-tight">
                @if ($hasWA)
                    <span class="text-green-400">{{ t('home.whatsappTitle1') }}</span>
                    <br>
                    <span class="text-white">{{ t('home.whatsappTitle2') }}</span>
                @elseif ($hasProofs)
                    <span class="text-white">{{ t('home.proofTitle1') }}</span>
                    <span class="bg-gradient-to-r from-primary to-blue-300 bg-clip-text text-transparent">{{ t('home.proofTitle2') }}</span>
                @endif
            </h2>
            <p class="text-white/50 text-sm max-w-md mx-auto">{{ $hasWA ? t('home.whatsappSubtitle') : t('home.proofSubtitle') }}</p>
        </div>

        <div class="grid gap-6 {{ $hasWA && $hasProofs ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-1 max-w-sm mx-auto' }}">
            @if ($hasWA)
                <div>
                    <div class="flex items-center gap-3 mb-5 bg-white/8 backdrop-blur-sm border border-white/12 rounded-xl px-4 py-2.5">
                        <div class="w-8 h-8 rounded-lg bg-green-500/20 border border-green-400/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold leading-tight">{{ t('socialProof.studentReviews') }}</p>
                            <p class="text-white/40 text-[10px]">{{ t('socialProof.verifiedMessages', ['count' => count($whatsappChats)]) }}</p>
                        </div>
                        <div class="ml-auto flex gap-0.5">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-3 h-3 fill-yellow-400 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                    </div>
                    <div class="relative overflow-y-auto max-h-[500px] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden space-y-3">
                        @foreach ($whatsappChats as $chat)
                            <div class="w-full rounded-2xl overflow-hidden bg-white border border-white/60 shadow-md shadow-black/8 text-left block group">
                                <div class="relative w-full overflow-hidden bg-slate-50" style="height: 160px">
                                    <img loading="lazy" decoding="async" src="{{ $chat->image_data }}" alt="{{ $chat->caption ?: 'review' }}" class="absolute inset-0 w-full h-full object-cover object-top">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                </div>
                                <div class="flex items-center gap-2.5 px-3 py-2.5">
                                    <div class="w-7 h-7 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $chat->caption ?: t('common.student') }}</p>
                                        <div class="flex gap-0.5 mt-0.5">
                                            @for ($i = 0; $i < 5; $i++)
                                                <svg class="w-2.5 h-2.5 fill-yellow-400 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-[9px] font-medium text-green-600 bg-green-50 border border-green-100 rounded-full px-2 py-0.5 shrink-0">{{ t('common.verified') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($hasProofs)
                <div>
                    <div class="flex items-center gap-3 mb-5 bg-white/8 backdrop-blur-sm border border-white/12 rounded-xl px-4 py-2.5">
                        <div class="w-8 h-8 rounded-lg bg-primary/20 border border-primary/30 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold leading-tight">{{ t('socialProof.placementProofs') }}</p>
                            <p class="text-white/40 text-[10px]">{{ t('socialProof.offerLetters', ['count' => count($proofs)]) }}</p>
                        </div>
                        <span class="ml-auto text-[10px] font-semibold text-primary bg-primary/20 border border-primary/30 rounded-full px-2.5 py-1">{{ t('common.verified') }}</span>
                    </div>
                    <div class="relative overflow-y-auto max-h-[500px] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden space-y-3">
                        @foreach ($proofs as $proof)
                            <div class="w-full rounded-2xl overflow-hidden bg-white border border-white/60 shadow-md shadow-black/8 group text-left block">
                                <div class="bg-gradient-to-r from-primary/5 to-blue-50 px-3 py-2 flex items-center gap-2 border-b border-primary/10">
                                    <div class="w-5 h-5 rounded-md bg-primary/10 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    </div>
                                    <span class="text-[10px] font-bold text-primary/70 uppercase tracking-wide">{{ t('socialProof.offerLetter') }}</span>
                                    @if ($proof->proof_date)
                                        <span class="ml-auto text-[10px] text-slate-400 shrink-0">{{ $proof->proof_date }}</span>
                                    @endif
                                </div>
                                <div class="relative overflow-hidden bg-slate-50" style="height: 120px">
                                    <img loading="lazy" decoding="async" src="{{ $proof->image_data }}" alt="{{ $proof->caption ?: 'proof' }}" class="w-full h-full object-cover object-top">
                                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-white/20"></div>
                                </div>
                                @if ($proof->caption)
                                    <div class="px-3 py-2 border-t border-slate-100 flex items-center gap-2">
                                        <svg class="w-3 h-3 text-primary shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                                        <p class="text-[10px] text-slate-500 line-clamp-1 flex-1">{{ $proof->caption }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
