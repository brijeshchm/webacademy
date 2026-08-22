@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $activeTab = in_array($tab, ['whatsapp','proofs','videos','courses','reviews','security'], true) ? $tab : 'whatsapp';
    $tabs = [
        ['id' => 'whatsapp', 'label' => 'WhatsApp Chats'],
        ['id' => 'proofs',   'label' => 'Placement Proofs'],
        ['id' => 'videos',   'label' => 'Video Stories'],
        ['id' => 'courses',  'label' => 'Courses'],
        ['id' => 'reviews',  'label' => 'Reviews'],
        ['id' => 'security', 'label' => 'Security'],
    ];
    $reviewSources = ['google' => 'Google', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram', 'other' => 'Other'];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Panel | Corporate Academy</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
<div class="min-h-screen bg-gradient-to-br from-background to-background/80 text-foreground">
    <div class="border-b border-white/20 bg-white/60 backdrop-blur-xl sticky top-0 z-20">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="font-display font-bold text-xl">Admin Panel</h1>
                <p class="text-sm text-muted-foreground">Corporate Academy</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-md border border-input bg-white/60 px-3 py-1.5 text-sm font-semibold hover:bg-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                    Sign out
                </button>
            </form>
        </div>
        <div class="container mx-auto px-6 flex gap-1 pb-0 overflow-x-auto">
            @foreach ($tabs as $t)
                <a href="{{ route('admin.dashboard', ['tab' => $t['id']]) }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === $t['id'] ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground' }}">
                    {{ $t['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="container mx-auto px-6 py-10 max-w-5xl">
        @if (session('success'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">{{ session('error') }}</div>
        @endif

        {{-- ─────────────── WhatsApp Chats ─────────────── --}}
        @if ($activeTab === 'whatsapp')
            <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-8 shadow-lg mb-12">
                <h2 class="font-display font-bold text-lg mb-6">Upload WhatsApp Chat Screenshot</h2>
                <form method="POST" action="{{ route('admin.whatsapp.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start" data-image-form>
                    @csrf
                    <div>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-primary/30 rounded-2xl aspect-video cursor-pointer hover:border-primary/60 transition-colors bg-primary/5 overflow-hidden relative">
                            <img data-preview class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden" alt="preview">
                            <span data-placeholder class="text-sm text-muted-foreground">Click to select image (PNG, JPG, WebP)</span>
                            <input type="file" accept="image/*" class="hidden" data-image-input>
                        </label>
                        <input type="hidden" name="imageData" data-image-data>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold mb-1.5 block">Caption <span class="font-normal text-muted-foreground">(optional)</span></label>
                            <input type="text" name="caption" placeholder="Short description" class="w-full rounded-md bg-white/60 border border-white/60 px-3 py-2 text-sm">
                        </div>
                        <button type="submit" class="w-full rounded-md bg-primary hover:bg-primary/90 text-white font-semibold py-2 transition-colors">Upload</button>
                    </div>
                </form>
            </div>
            <h2 class="font-display font-bold text-lg mb-6">WhatsApp Chats <span class="text-muted-foreground font-normal text-sm">({{ $chats->count() }})</span></h2>
            @if ($chats->isEmpty())
                <div class="text-center text-muted-foreground py-16 bg-white/40 rounded-3xl border border-white/60">No WhatsApp screenshots yet.</div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($chats as $chat)
                    <div class="bg-white/60 backdrop-blur-lg border border-white/80 rounded-2xl overflow-hidden shadow-md relative">
                        <div class="bg-[#075E54] px-3 py-1.5 flex items-center gap-2">
                            <span class="text-white text-xs font-semibold">WhatsApp</span>
                        </div>
                        <div class="aspect-[9/16] overflow-hidden bg-[#ECE5DD]">
                            <img loading="lazy" src="{{ $chat->image_data }}" alt="{{ $chat->caption ?: 'whatsapp' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-3">
                            <form method="POST" action="{{ route('admin.whatsapp.update', $chat->id) }}" class="flex items-center gap-1">
                                @csrf
                                <input type="text" name="caption" value="{{ $chat->caption }}" placeholder="Add caption…" class="flex-1 h-7 text-xs px-2 rounded bg-white/80 border border-white/60">
                                <button type="submit" class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 shrink-0 text-xs">✓</button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('admin.whatsapp.destroy', $chat->id) }}" class="absolute top-10 right-2" onsubmit="return confirm('Delete this screenshot?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-7 h-7 rounded-full bg-red-500/90 text-white flex items-center justify-center hover:bg-red-600 shadow-lg text-xs">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ─────────────── Placement Proofs ─────────────── --}}
        @if ($activeTab === 'proofs')
            <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-8 shadow-lg mb-12">
                <h2 class="font-display font-bold text-lg mb-6">Upload Placement Screenshot</h2>
                <form method="POST" action="{{ route('admin.proofs.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start" data-image-form>
                    @csrf
                    <div>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-primary/30 rounded-2xl aspect-video cursor-pointer hover:border-primary/60 transition-colors bg-primary/5 overflow-hidden relative">
                            <img data-preview class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden" alt="preview">
                            <span data-placeholder class="text-sm text-muted-foreground">Click to select image (PNG, JPG, WebP)</span>
                            <input type="file" accept="image/*" class="hidden" data-image-input>
                        </label>
                        <input type="hidden" name="imageData" data-image-data>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold mb-1.5 block">Date <span class="text-primary ml-1">*</span></label>
                            <input type="date" name="proofDate" required class="w-full rounded-md bg-white/60 border border-white/60 px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1.5 block">Caption <span class="font-normal text-muted-foreground">(optional)</span></label>
                            <input type="text" name="caption" placeholder="Short description" class="w-full rounded-md bg-white/60 border border-white/60 px-3 py-2 text-sm">
                        </div>
                        <button type="submit" class="w-full rounded-md bg-primary hover:bg-primary/90 text-white font-semibold py-2 transition-colors">Upload</button>
                    </div>
                </form>
            </div>
            <h2 class="font-display font-bold text-lg mb-6">Uploaded Screenshots <span class="text-muted-foreground font-normal text-sm">({{ $proofs->count() }})</span></h2>
            @if ($proofs->isEmpty())
                <div class="text-center text-muted-foreground py-16 bg-white/40 rounded-3xl border border-white/60">No screenshots yet.</div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($proofs as $proof)
                    <div class="bg-white/60 backdrop-blur-lg border border-white/80 rounded-2xl overflow-hidden shadow-md relative">
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                            <img loading="lazy" src="{{ $proof->image_data }}" alt="{{ $proof->caption ?: 'proof' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <p class="text-primary text-xs font-semibold mb-1">{{ $proof->proof_date }}</p>
                            @if ($proof->caption)<p class="text-sm text-muted-foreground line-clamp-2">{{ $proof->caption }}</p>@endif
                        </div>
                        <form method="POST" action="{{ route('admin.proofs.destroy', $proof->id) }}" class="absolute top-3 right-3" onsubmit="return confirm('Delete this screenshot?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-red-500/90 text-white flex items-center justify-center hover:bg-red-600 shadow-lg text-xs">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ─────────────── Video Stories ─────────────── --}}
        @if ($activeTab === 'videos')
            <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-8 shadow-lg mb-12">
                <h2 class="font-display font-bold text-lg mb-6">Upload Video Story</h2>
                <form method="POST" action="{{ route('admin.videos.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start" data-video-form>
                    @csrf
                    <div>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-primary/30 rounded-2xl aspect-video cursor-pointer hover:border-primary/60 transition-colors bg-primary/5 overflow-hidden relative p-4 text-center">
                            <span data-video-name class="text-sm text-muted-foreground">Click to select video (MP4, MOV, WebM)</span>
                            <input type="file" accept="video/*" class="hidden" data-video-input>
                        </label>
                        <input type="hidden" name="videoData" data-video-data>
                        <input type="hidden" name="sortOrder" value="{{ $stories->count() }}">
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-semibold mb-1.5 block">Label <span class="text-primary ml-1">*</span></label>
                            <input type="text" name="label" placeholder="e.g. Data Science" required class="w-full rounded-md bg-white/60 border border-white/60 px-3 py-2 text-sm">
                        </div>
                        <p class="text-xs text-muted-foreground">Keep files under 30 MB for best performance.</p>
                        <button type="submit" class="w-full rounded-md bg-primary hover:bg-primary/90 text-white font-semibold py-2 transition-colors">Upload Video</button>
                    </div>
                </form>
            </div>
            <h2 class="font-display font-bold text-lg mb-2">Video Stories <span class="text-muted-foreground font-normal text-sm">({{ $stories->count() }})</span></h2>
            <p class="text-sm text-muted-foreground mb-6">When at least one video is uploaded here, the static default videos are replaced on the homepage.</p>
            @if ($stories->isEmpty())
                <div class="text-center text-muted-foreground py-16 bg-white/40 rounded-3xl border border-white/60">No custom videos yet.</div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($stories as $story)
                    <div class="bg-white/60 backdrop-blur-lg border border-white/80 rounded-2xl overflow-hidden shadow-md relative">
                        <div class="aspect-[9/16] bg-foreground/5 overflow-hidden">
                            <video src="{{ $story->video_data }}" muted playsinline preload="metadata" class="w-full h-full object-cover"></video>
                        </div>
                        <div class="p-3">
                            <p class="text-xs text-muted-foreground mb-0.5 font-semibold uppercase tracking-wider">Label</p>
                            <form method="POST" action="{{ route('admin.videos.update', $story->id) }}" class="flex items-center gap-1">
                                @csrf
                                <input type="text" name="label" value="{{ $story->label }}" placeholder="Click to set label…" class="flex-1 h-7 text-xs px-2 rounded bg-white/80 border border-white/60">
                                <button type="submit" class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center hover:bg-green-600 shrink-0 text-xs">✓</button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('admin.videos.destroy', $story->id) }}" class="absolute top-2 right-2" onsubmit="return confirm('Delete this video?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-red-500/90 text-white flex items-center justify-center hover:bg-red-600 shadow-lg text-xs">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ─────────────── Courses ─────────────── --}}
        @if ($activeTab === 'courses')
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display font-bold text-lg">Courses <span class="text-muted-foreground font-normal text-sm">({{ $courses->count() }})</span></h2>
                <button type="button" class="inline-flex items-center gap-2 rounded-md bg-primary hover:bg-primary/90 text-white px-3 py-1.5 text-sm font-semibold" onclick="document.getElementById('add-course').classList.toggle('hidden')">+ Add Course</button>
            </div>

            <div id="add-course" class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-8 shadow-lg mb-8 hidden">
                <h3 class="font-display font-bold text-base mb-5">New Course</h3>
                <form method="POST" action="{{ route('admin.courses.store') }}">
                    @csrf
                    @include('admin.partials.course-fields', ['c' => null])
                    <div class="flex gap-3 mt-5">
                        <button type="submit" class="rounded-md bg-primary hover:bg-primary/90 text-white px-4 py-2 text-sm font-semibold">Create Course</button>
                    </div>
                </form>
            </div>

            @if ($courses->isEmpty())
                <div class="text-center text-muted-foreground py-16 bg-white/40 rounded-3xl border border-white/60">No courses yet.</div>
            @endif
            <div class="space-y-3">
                @foreach ($courses as $course)
                    <div class="bg-white/60 backdrop-blur-lg border border-white/80 rounded-2xl px-5 py-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-sm">{{ $course->title }}</span>
                                    @if ($course->featured)<span class="text-[10px] font-bold uppercase tracking-wider bg-primary/10 text-primary px-2 py-0.5 rounded-full">Featured</span>@endif
                                    <span class="text-[10px] text-muted-foreground bg-white/60 border border-white/80 px-2 py-0.5 rounded-full">{{ $course->level }}</span>
                                </div>
                                <p class="text-xs text-muted-foreground mt-0.5 line-clamp-1">{{ $course->category_name }} · {{ $course->mode }} · {{ $course->duration_hours }}h · ${{ $course->price }}</p>
                                <p class="text-xs text-primary/60 mt-0.5 font-mono">{{ $course->slug }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center hover:bg-primary/20 text-xs" onclick="document.getElementById('edit-course-{{ $course->id }}').classList.toggle('hidden')">✎</button>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" onsubmit="return confirm('Delete this course?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-500/90 text-white flex items-center justify-center hover:bg-red-600 shadow text-xs">✕</button>
                                </form>
                            </div>
                        </div>
                        <div id="edit-course-{{ $course->id }}" class="hidden mt-4 pt-4 border-t border-white/60">
                            <h3 class="font-semibold text-sm mb-4">Editing: {{ $course->title }}</h3>
                            <form method="POST" action="{{ route('admin.courses.update', $course->id) }}">
                                @csrf
                                @include('admin.partials.course-fields', ['c' => $course])
                                <div class="flex gap-3 mt-5">
                                    <button type="submit" class="rounded-md bg-primary hover:bg-primary/90 text-white px-4 py-2 text-sm font-semibold">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ─────────────── Reviews ─────────────── --}}
        @if ($activeTab === 'reviews')
            <div class="mb-6">
                <h2 class="text-xl font-bold">Reviews</h2>
                <p class="text-sm text-muted-foreground mt-0.5">Toggle visibility to control which reviews appear on the site. Hidden reviews are not deleted.</p>
            </div>

            <div class="bg-white/60 backdrop-blur-xl border border-white/80 rounded-3xl p-8 shadow-lg mb-10">
                <h3 class="font-display font-bold text-base mb-5">Add Review</h3>
                <form method="POST" action="{{ route('admin.reviews.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @csrf
                    <div><label class="text-xs font-semibold mb-1 block">Name <span class="text-primary">*</span></label><input type="text" name="name" required class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2"></div>
                    <div><label class="text-xs font-semibold mb-1 block">Role <span class="text-primary">*</span></label><input type="text" name="role" required class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2"></div>
                    <div><label class="text-xs font-semibold mb-1 block">Company <span class="text-primary">*</span></label><input type="text" name="company" required class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2"></div>
                    <div><label class="text-xs font-semibold mb-1 block">Rating (0–5)</label><input type="number" name="rating" step="0.1" min="0" max="5" class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2"></div>
                    <div><label class="text-xs font-semibold mb-1 block">Avatar URL</label><input type="text" name="avatar_url" placeholder="https://…" class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2"></div>
                    <div><label class="text-xs font-semibold mb-1 block">Source</label>
                        <select name="source" class="w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2">
                            @foreach ($reviewSources as $val => $label)<option value="{{ $val }}">{{ $label }}</option>@endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2"><label class="text-xs font-semibold mb-1 block">Quote <span class="text-primary">*</span></label><textarea name="quote" rows="2" required class="w-full rounded-md bg-white/60 border border-white/60 text-sm resize-none px-2 py-1"></textarea></div>
                    <div class="sm:col-span-2 flex items-center gap-2">
                        <input type="checkbox" name="visible" value="1" checked id="review-visible" class="w-4 h-4 accent-primary">
                        <label for="review-visible" class="text-xs font-semibold">Visible on site</label>
                    </div>
                    <div class="sm:col-span-2"><button type="submit" class="rounded-md bg-primary hover:bg-primary/90 text-white px-4 py-2 text-sm font-semibold">Add Review</button></div>
                </form>
            </div>

            @php $grouped = collect($reviewSources)->map(fn($label, $src) => ['src' => $src, 'label' => $label, 'items' => $reviews->where('source', $src)])->filter(fn($g) => $g['items']->count() > 0); @endphp
            @foreach ($grouped as $g)
                <div class="mb-8">
                    <h3 class="font-semibold text-sm uppercase tracking-wider text-muted-foreground mb-3 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-primary/10 text-primary text-xs flex items-center justify-center">{{ $g['items']->count() }}</span>{{ $g['label'] }}
                    </h3>
                    <div class="space-y-3">
                        @foreach ($g['items'] as $rv)
                            <div class="flex items-start gap-4 p-4 rounded-xl border {{ $rv->visible ? 'bg-white border-gray-100' : 'bg-gray-50 border-dashed border-gray-200 opacity-60' }}">
                                @if ($rv->avatar_url)<img loading="lazy" src="{{ $rv->avatar_url }}" alt="{{ $rv->name }}" class="w-10 h-10 rounded-full object-cover shrink-0 mt-0.5">@endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="font-semibold text-sm">{{ $rv->name }}</span>
                                        <span class="text-xs text-muted-foreground">{{ $rv->role }}{{ $rv->company ? ' · '.$rv->company : '' }}</span>
                                    </div>
                                    <p class="text-xs text-yellow-500 mb-1">{{ str_repeat('★', (int) round($rv->rating)) }}{{ str_repeat('☆', max(0, 5 - (int) round($rv->rating))) }}</p>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $rv->quote }}</p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <form method="POST" action="{{ route('admin.reviews.toggle', $rv->id) }}">
                                        @csrf
                                        <input type="hidden" name="visible" value="{{ $rv->visible ? '0' : '1' }}">
                                        <button type="submit" title="{{ $rv->visible ? 'Hide from site' : 'Show on site' }}" class="w-8 h-8 rounded-lg flex items-center justify-center {{ $rv->visible ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }} text-xs">{{ $rv->visible ? '👁' : '🚫' }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $rv->id) }}" onsubmit="return confirm('Delete this review permanently?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center text-xs">✕</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

        {{-- ─────────────── Security ─────────────── --}}
        @if ($activeTab === 'security')
            <div class="max-w-md">
                <h2 class="text-lg font-bold mb-1">Change Admin Password</h2>
                <p class="text-sm text-muted-foreground mb-6">The new password takes effect immediately for all admin actions. Changing it signs out all sessions — you'll be asked to sign in again. If you forget it, use "Forgot password" on the sign-in screen.</p>
                <form method="POST" action="{{ route('admin.change-password') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Current password</label>
                        <input type="password" name="currentPassword" autocomplete="current-password" required class="w-full rounded-md border border-input bg-white px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">New password</label>
                        <input type="password" name="newPassword" placeholder="Min 8 characters" minlength="8" autocomplete="new-password" required class="w-full rounded-md border border-input bg-white px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Confirm new password</label>
                        <input type="password" name="confirmPassword" autocomplete="new-password" required class="w-full rounded-md border border-input bg-white px-3 py-2 text-sm">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-primary hover:bg-primary/90 text-white px-4 py-2 text-sm font-semibold">Update Password</button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
// Read a selected image file, downscale to <=1600px, and store as a JPEG data URL.
document.querySelectorAll('[data-image-form]').forEach(function (form) {
    var input = form.querySelector('[data-image-input]');
    var hidden = form.querySelector('[data-image-data]');
    var preview = form.querySelector('[data-preview]');
    var placeholder = form.querySelector('[data-placeholder]');
    if (!input) return;
    input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            var img = new Image();
            img.onload = function () {
                var MAX = 1600, w = img.width, h = img.height;
                if (w > MAX || h > MAX) {
                    if (w >= h) { h = Math.round(h * MAX / w); w = MAX; }
                    else { w = Math.round(w * MAX / h); h = MAX; }
                }
                var canvas = document.createElement('canvas');
                canvas.width = w; canvas.height = h;
                canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                var data = canvas.toDataURL('image/jpeg', 0.82);
                hidden.value = data;
                if (preview) { preview.src = data; preview.classList.remove('hidden'); }
                if (placeholder) placeholder.classList.add('hidden');
            };
            img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
    form.addEventListener('submit', function (e) {
        if (!hidden.value) { e.preventDefault(); alert('Please select an image.'); }
    });
});
// Read a selected video file as a raw data URL.
document.querySelectorAll('[data-video-form]').forEach(function (form) {
    var input = form.querySelector('[data-video-input]');
    var hidden = form.querySelector('[data-video-data]');
    var nameEl = form.querySelector('[data-video-name]');
    if (!input) return;
    input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            hidden.value = ev.target.result;
            if (nameEl) nameEl.textContent = file.name + ' — ready to upload';
        };
        reader.readAsDataURL(file);
    });
    form.addEventListener('submit', function (e) {
        if (!hidden.value) { e.preventDefault(); alert('Please select a video.'); }
    });
});
</script>
</body>
</html>
