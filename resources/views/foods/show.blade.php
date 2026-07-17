@extends('layouts.nutrival')
@section('title', $food->name)
@section('content')

<a href="{{ route('foods.index') }}" class="text-sm text-emerald-600 hover:underline">← Kembali ke katalog</a>

<div class="mt-4 bg-white rounded-2xl border border-stone-200 overflow-hidden max-w-2xl">
    <x-food-img :food="$food" class="w-full h-56" />
    <div class="p-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold">{{ $food->name }}</h1>
                <p class="text-sm text-stone-500">{{ $food->category->icon }} {{ $food->category->name }} • porsi standar: {{ $food->servingLabel() }}</p>
            </div>
            <a href="{{ route('diary.create', ['q' => $food->name]) }}"
               class="shrink-0 px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">+ Catat</a>
        </div>

        @if($food->description)
            <p class="mt-3 text-sm text-stone-600">{{ $food->description }}</p>
        @endif

        <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach([
                ['Kalori', number_format($food->calories), 'kkal', 'bg-emerald-50 text-emerald-700'],
                ['Protein', $food->protein, 'g', 'bg-sky-50 text-sky-700'],
                ['Karbohidrat', $food->carbs, 'g', 'bg-amber-50 text-amber-700'],
                ['Lemak', $food->fat, 'g', 'bg-rose-50 text-rose-700'],
            ] as [$label, $val, $unit, $color])
                <div class="rounded-xl p-3 {{ $color }}">
                    <p class="text-xs opacity-70">{{ $label }}</p>
                    <p class="text-lg font-extrabold">{{ $val }} <span class="text-xs font-normal">{{ $unit }}</span></p>
                </div>
            @endforeach
        </div>

        @if($food->fiber || $food->sugar || $food->sodium || $food->cholesterol || $food->saturated_fat)
            <div class="mt-4 text-sm text-stone-600 space-y-1">
                <p class="font-semibold text-stone-700">Nutrisi tambahan (per porsi standar):</p>
                <ul class="grid grid-cols-2 gap-x-4">
                    @if($food->fiber)<li>Serat: {{ $food->fiber }} g</li>@endif
                    @if($food->sugar)<li>Gula: {{ $food->sugar }} g</li>@endif
                    @if($food->sodium)<li>Natrium: {{ $food->sodium }} mg</li>@endif
                    @if($food->cholesterol)<li>Kolesterol: {{ $food->cholesterol }} mg</li>@endif
                    @if($food->saturated_fat)<li>Lemak jenuh: {{ $food->saturated_fat }} g</li>@endif
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
