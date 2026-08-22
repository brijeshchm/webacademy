@extends('layouts.app')

@push('seo')
    <title>{{ t('notFound.title') }} | Corporate Academy</title>
    <meta name="robots" content="noindex">
@endpush

@section('content')
    <div class="min-h-[80vh] w-full flex items-center justify-center bg-background relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl pointer-events-none ca-float"></div>
        <div class="w-full max-w-md mx-4 relative z-10">
            <div class="bg-white/60 backdrop-blur-xl border border-white/80 shadow-xl shadow-primary/5 rounded-3xl">
                <div class="pt-8 pb-8 px-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-red-100/50 backdrop-blur-md text-red-500 rounded-2xl flex items-center justify-center mb-6 border border-red-200/50 shadow-sm">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <h1 class="text-2xl font-display font-bold text-foreground mb-2">{{ t('notFound.title') }}</h1>
                    <p class="text-muted-foreground">{{ t('notFound.desc') }}</p>
                    <a href="/" class="mt-6 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold rounded-xl bg-primary hover:bg-primary/90 text-primary-foreground transition-colors">{{ t('nav.explorePrograms') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
