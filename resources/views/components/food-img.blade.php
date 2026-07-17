@props(['food', 'class' => 'w-full h-40'])
{{-- Foto asli jika file ada; fallback gradient + emoji kategori jika tidak --}}
<div class="{{ $class }} relative overflow-hidden bg-gradient-to-br from-emerald-100 to-amber-100">
    <div class="absolute inset-0 flex items-center justify-center text-4xl opacity-60">
        {{ $food->category->icon ?? '🍽️' }}
    </div>
    @if($food->image_path)
        <img src="{{ str_starts_with($food->image_path, 'images/') ? asset($food->image_path) : asset('storage/' . $food->image_path) }}"
             alt="{{ $food->name }}"
             class="absolute inset-0 w-full h-full object-cover"
             onerror="this.remove()">
    @endif
</div>
