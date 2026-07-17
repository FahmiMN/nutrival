@extends('layouts.nutrival')
@section('title', 'Katalog Makanan')
@section('content')

<div class="flex items-center justify-between flex-wrap gap-3 mb-6">
    <h1 class="text-2xl font-bold">🍛 Katalog Makanan</h1>
    <a href="{{ route('customfood.create') }}" class="px-4 py-2.5 rounded-xl bg-white border border-emerald-300 text-emerald-700 font-semibold hover:bg-emerald-50">+ Ajukan Makanan Baru</a>
</div>

<form method="GET" action="{{ route('foods.index') }}" class="flex flex-wrap gap-2 mb-6">
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari makanan…"
           class="flex-1 min-w-48 rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    <select name="category" onchange="this.form.submit()"
            class="rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        <option value="">Semua Kategori</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected($categoryId == $c->id)>{{ $c->icon }} {{ $c->name }}</option>
        @endforeach
    </select>
    <button class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-semibold">Cari</button>
</form>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($foods as $food)
        <a href="{{ route('foods.show', $food) }}" class="group rounded-2xl bg-white border border-stone-200 overflow-hidden hover:shadow-lg hover:border-emerald-300 transition">
            <x-food-img :food="$food" class="w-full h-36" />
            <div class="p-4">
                <div class="flex items-start justify-between gap-2">
                    <p class="font-semibold leading-tight group-hover:text-emerald-700">{{ $food->name }}</p>
                    @if($food->is_custom && $food->status !== 'approved')
                        <span class="text-[10px] shrink-0 px-1.5 py-0.5 rounded bg-amber-100 text-amber-700">Pribadi</span>
                    @endif
                </div>
                <p class="text-xs text-stone-500 mt-0.5">{{ $food->category->icon }} {{ $food->category->name }} • {{ $food->servingLabel() }}</p>
                <div class="flex gap-3 mt-2 text-xs text-stone-500">
                    <span class="font-bold text-emerald-700">{{ number_format($food->calories) }} kkal</span>
                    <span>P {{ $food->protein }}g</span>
                    <span>K {{ $food->carbs }}g</span>
                    <span>L {{ $food->fat }}g</span>
                </div>
            </div>
        </a>
    @empty
        <p class="col-span-full text-center text-stone-400 py-12">Tidak ada makanan ditemukan.</p>
    @endforelse
</div>

<div class="mt-6">{{ $foods->links() }}</div>
@endsection
