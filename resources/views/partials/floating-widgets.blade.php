{{-- Floating chat widget + floating contacts. Enhanced by /assets/app.js. --}}
<div data-chat-widget class="fixed bottom-5 end-5 z-[80]">
    {{-- Launcher --}}
    <button type="button" data-chat-open aria-label="{{ t('chat.title') }}" class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-primary-foreground shadow-xl shadow-primary/30 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 animate-pulse-ring">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
    </button>

    {{-- Panel --}}
    <div data-chat-panel data-chat-error="{{ t('chat.error') }}" class="hidden absolute bottom-16 end-0 w-[min(360px,90vw)] flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-2xl">
        <div class="flex items-center justify-between gap-2 bg-[#060e24] px-4 py-3 text-white">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="ca-glow absolute inline-flex h-full w-full rounded-full bg-emerald-400"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                </span>
                <span class="text-sm font-semibold">{{ t('chat.title') }}</span>
                <span class="text-[11px] text-white/50">{{ t('chat.online') }}</span>
            </div>
            <button type="button" data-chat-close aria-label="Close" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/60 hover:bg-white/10 hover:text-white transition-colors">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div data-chat-messages class="flex max-h-[50vh] min-h-[220px] flex-col gap-3 overflow-y-auto bg-background/60 p-4 text-sm">
            <div class="max-w-[85%] self-start rounded-2xl rounded-bl-sm bg-muted px-3 py-2 text-foreground">{{ t('chat.greeting') }}</div>
        </div>

        <form data-chat-form class="flex items-center gap-2 border-t border-border bg-card p-3">
            <input type="text" data-chat-input autocomplete="off" placeholder="{{ t('chat.placeholder') }}" class="min-w-0 flex-1 rounded-xl border border-input bg-background px-3 py-2 text-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            <button type="submit" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-foreground transition-colors hover:bg-primary/90" aria-label="Send">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </button>
        </form>
    </div>
</div>

{{-- Floating contacts (WhatsApp + phone) --}}
<div class="fixed bottom-5 start-5 z-[80] flex flex-col gap-3">
    <a href="https://wa.me/918800182225" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500 text-white shadow-xl shadow-emerald-500/30 transition-all duration-200 hover:-translate-y-0.5">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
    </a>
</div>
