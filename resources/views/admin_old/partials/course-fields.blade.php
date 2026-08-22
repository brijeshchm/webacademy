@php
    /** @var \App\Models\Course|null $c */
    $val = fn ($v) => $c ? $v : '';
    $inputCls = 'w-full rounded-md bg-white/60 border border-white/60 h-8 text-sm px-2';
@endphp
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
    <div><label class="text-xs font-semibold mb-1 block">Title <span class="text-primary">*</span></label><input type="text" name="title" value="{{ $c?->title }}" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Slug <span class="text-primary">*</span></label><input type="text" name="slug" value="{{ $c?->slug }}" placeholder="e.g. aws-cloud-practitioner" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Category Slug <span class="text-primary">*</span></label><input type="text" name="categorySlug" value="{{ $c?->category_slug }}" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Category Name <span class="text-primary">*</span></label><input type="text" name="categoryName" value="{{ $c?->category_name }}" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Level <span class="text-primary">*</span></label><input type="text" name="level" value="{{ $c?->level }}" placeholder="Beginner / Intermediate / Advanced" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Mode <span class="text-primary">*</span></label><input type="text" name="mode" value="{{ $c?->mode }}" placeholder="Online / In-person / Hybrid" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Duration (hours) <span class="text-primary">*</span></label><input type="number" name="durationHours" value="{{ $c?->duration_hours }}" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Price ($) <span class="text-primary">*</span></label><input type="number" name="price" value="{{ $c?->price }}" required class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Rating</label><input type="number" step="0.1" name="rating" value="{{ $c?->rating }}" placeholder="e.g. 4.8" class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Review Count</label><input type="number" name="reviewCount" value="{{ $c?->total_rating }}" class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Enrolled</label><input type="number" name="enrolled" value="{{ $c?->enrolled }}" class="{{ $inputCls }}"></div>
    <div><label class="text-xs font-semibold mb-1 block">Image URL</label><input type="text" name="imageUrl" value="{{ $c?->image_url }}" placeholder="https://…" class="{{ $inputCls }}"></div>
    <div class="flex items-center gap-2 mt-1">
        <input type="checkbox" name="featured" value="1" @checked($c?->featured) class="w-4 h-4 accent-primary">
        <label class="text-xs font-semibold">Featured</label>
    </div>
    <div class="sm:col-span-2 lg:col-span-3">
        <label class="text-xs font-semibold mb-1 block">Skills <span class="font-normal text-muted-foreground">(comma-separated)</span></label>
        <input type="text" name="skills" value="{{ $c ? implode(', ', $c->skills ?? []) : '' }}" placeholder="e.g. AWS, Cloud, DevOps" class="{{ $inputCls }}">
    </div>
    <div class="sm:col-span-2 lg:col-span-3">
        <label class="text-xs font-semibold mb-1 block">Summary <span class="text-primary">*</span></label>
        <textarea name="summary" rows="2" required class="w-full rounded-md bg-white/60 border border-white/60 text-sm resize-none px-2 py-1">{{ $c?->summary }}</textarea>
    </div>
    <div class="sm:col-span-2 lg:col-span-3">
        <label class="text-xs font-semibold mb-1 block">Description <span class="text-primary">*</span></label>
        <textarea name="description" rows="4" required class="w-full rounded-md bg-white/60 border border-white/60 text-sm resize-none px-2 py-1">{{ $c?->description }}</textarea>
    </div>
</div>
