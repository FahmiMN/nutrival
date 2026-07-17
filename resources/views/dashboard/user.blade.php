@extends('layouts.nutrival')
@section('title', 'Beranda')
@section('content')

<div class="flex items-start justify-between flex-wrap gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold">Halo, {{ $user->name }} 👋</h1>
        <p class="text-stone-500 text-sm">{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-xl px-4 py-2">
        <span class="text-xl">🔥</span>
        <div>
            <p class="font-bold text-amber-700 leading-none">{{ $streak }} hari</p>
            <p class="text-xs text-amber-600">streak pencatatan</p>
        </div>
    </div>
</div>

@php
    $target = $user->calorie_target;
    $pct = $target ? min(100, round($totals['calories'] / $target * 100)) : null;
@endphp

<div class="grid md:grid-cols-3 gap-4 mb-6">
    {{-- Ring kalori --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-5 flex items-center gap-5">
        <div class="relative w-28 h-28">
            <canvas id="calRing"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-xl font-extrabold text-emerald-600">{{ $pct !== null ? $pct.'%' : '—' }}</span>
            </div>
        </div>
        <div>
            <p class="text-sm text-stone-500">Kalori hari ini</p>
            <p class="text-2xl font-extrabold">{{ number_format($totals['calories']) }}</p>
            <p class="text-xs text-stone-400">
                @if($target) dari target {{ number_format($target) }} kkal
                @else <a href="{{ route('target.edit') }}" class="text-emerald-600 underline">Set target dulu →</a>
                @endif
            </p>
        </div>
    </div>

    {{-- Macro bars --}}
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-stone-200 p-5 space-y-3">
        @foreach([
            ['Protein', $totals['protein'], $user->protein_target, 'bg-emerald-500'],
            ['Karbohidrat', $totals['carbs'], $user->carb_target, 'bg-amber-500'],
            ['Lemak', $totals['fat'], $user->fat_target, 'bg-rose-400'],
        ] as [$label, $val, $tgt, $color])
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium">{{ $label }}</span>
                    <span class="text-stone-500">{{ round($val, 1) }}g {{ $tgt ? '/ '.$tgt.'g' : '' }}</span>
                </div>
                <div class="h-2.5 rounded-full bg-stone-100 overflow-hidden">
                    <div class="h-full {{ $color }} rounded-full" style="width: {{ $tgt ? min(100, $val / $tgt * 100) : 0 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Aksi cepat --}}
<div class="flex flex-wrap gap-3 mb-6">
    <a href="{{ route('diary.create') }}" class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition">+ Catat Makanan</a>
    <a href="{{ route('mealplan.index') }}" class="px-5 py-3 rounded-xl bg-white border border-stone-200 font-semibold hover:bg-stone-50 transition">🗓️ Meal Plan</a>
    <a href="{{ route('stats.index') }}" class="px-5 py-3 rounded-xl bg-white border border-stone-200 font-semibold hover:bg-stone-50 transition">📈 Statistik</a>
</div>

{{-- Log hari ini --}}
<div class="bg-white rounded-2xl shadow-sm border border-stone-200">
    <div class="px-5 py-4 border-b border-stone-100 flex justify-between items-center">
        <h2 class="font-bold">Makanan Hari Ini</h2>
        <a href="{{ route('diary.index') }}" class="text-sm text-emerald-600 hover:underline">Lihat diary →</a>
    </div>
    @forelse($logs as $log)
        <div class="px-5 py-3 flex items-center justify-between border-b border-stone-50 last:border-0">
            <div class="flex items-center gap-3">
                <span class="text-xl">{{ $log->food->category->icon ?? '🍽️' }}</span>
                <div>
                    <p class="font-medium">{{ $log->food->name }}</p>
                    <p class="text-xs text-stone-500">{{ substr($log->log_time, 0, 5) }} • {{ rtrim(rtrim(number_format($log->amount, 1), '0'), '.') }} {{ $log->food->serving_unit }}</p>
                </div>
            </div>
            <span class="font-semibold text-emerald-700">{{ number_format($log->calories()) }} kkal</span>
        </div>
    @empty
        <div class="px-5 py-10 text-center text-stone-400">
            <p class="text-3xl mb-2">🍽️</p>
            <p>Belum ada catatan hari ini.</p>
            <a href="{{ route('diary.create') }}" class="text-emerald-600 font-medium hover:underline">Catat makanan pertamamu →</a>
        </div>
    @endforelse
</div>

<script>
new Chart(document.getElementById('calRing'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [{{ $pct ?? 0 }}, {{ 100 - ($pct ?? 0) }}],
            backgroundColor: ['#059669', '#f5f5f4'],
            borderWidth: 0,
        }]
    },
    options: { cutout: '75%', plugins: { tooltip: { enabled: false } } }
});
</script>
@endsection
