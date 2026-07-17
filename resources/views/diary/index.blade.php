@extends('layouts.nutrival')
@section('title', 'Food Diary')
@section('content')

<div class="flex items-center justify-between flex-wrap gap-3 mb-6">
    <h1 class="text-2xl font-bold">📔 Food Diary</h1>
    <a href="{{ route('diary.create', ['date' => $date]) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700">+ Catat Makanan</a>
</div>

{{-- Navigasi tanggal --}}
@php $d = \Carbon\Carbon::parse($date); @endphp
<div class="flex items-center gap-2 mb-6">
    <a href="{{ route('diary.index', ['date' => $d->copy()->subDay()->toDateString()]) }}" class="px-3 py-2 rounded-lg bg-white border border-stone-200 hover:bg-stone-50">←</a>
    <form method="GET" action="{{ route('diary.index') }}">
        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
               class="rounded-lg border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    </form>
    <a href="{{ route('diary.index', ['date' => $d->copy()->addDay()->toDateString()]) }}" class="px-3 py-2 rounded-lg bg-white border border-stone-200 hover:bg-stone-50">→</a>
    <span class="text-sm text-stone-500 ml-2">{{ $d->translatedFormat('l, d F Y') }}</span>
</div>

{{-- Ringkasan hari --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    @foreach([
        ['Kalori', number_format($totals['calories']), 'kkal', $user->calorie_target],
        ['Protein', round($totals['protein'], 1), 'g', $user->protein_target],
        ['Karbo', round($totals['carbs'], 1), 'g', $user->carb_target],
        ['Lemak', round($totals['fat'], 1), 'g', $user->fat_target],
    ] as [$label, $val, $unit, $tgt])
        <div class="bg-white rounded-2xl border border-stone-200 p-4">
            <p class="text-xs text-stone-500">{{ $label }}</p>
            <p class="text-xl font-extrabold">{{ $val }} <span class="text-sm font-normal text-stone-400">{{ $unit }}</span></p>
            @if($tgt)<p class="text-xs text-stone-400">target: {{ number_format($tgt) }} {{ $unit }}</p>@endif
        </div>
    @endforeach
</div>

{{-- Daftar log --}}
<div class="bg-white rounded-2xl shadow-sm border border-stone-200 divide-y divide-stone-50">
    @forelse($logs as $log)
        <div class="px-5 py-4 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $log->food->category->icon ?? '🍽️' }}</span>
                <div>
                    <p class="font-semibold">{{ $log->food->name }}</p>
                    <p class="text-xs text-stone-500">
                        ⏰ {{ substr($log->log_time, 0, 5) }} •
                        {{ rtrim(rtrim(number_format($log->amount, 1), '0'), '.') }} {{ $log->food->serving_unit }}
                        @if($log->note) • “{{ $log->note }}” @endif
                    </p>
                    <p class="text-xs text-stone-400">
                        P: {{ $log->protein() }}g · K: {{ $log->carbs() }}g · L: {{ $log->fat() }}g
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="font-bold text-emerald-700">{{ number_format($log->calories()) }} kkal</span>
                <a href="{{ route('diary.edit', $log) }}" class="text-sm px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200">Edit</a>
                <form method="POST" action="{{ route('diary.destroy', $log) }}" onsubmit="return confirm('Hapus catatan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-sm px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="px-5 py-12 text-center text-stone-400">
            <p class="text-3xl mb-2">🍽️</p>
            <p>Belum ada catatan untuk tanggal ini.</p>
        </div>
    @endforelse
</div>
@endsection
