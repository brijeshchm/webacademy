@extends('layouts.app')

@push('seo')
    <title>{{ t($titleKey) }} | Corporate Academy</title>
@endpush

@section('content')
    <section class="container mx-auto px-4 py-16 md:py-24">
        <h1 class="text-3xl md:text-4xl font-display font-bold text-foreground">{{ t($titleKey) }}</h1>
        <p class="mt-4 text-muted-foreground">This page is under construction.</p>
    </section>
@endsection
