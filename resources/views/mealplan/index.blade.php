@extends('layouts.nutrival')
@section('title', 'Meal Plan')
@section('content')

<div class="flex items-center justify-between flex-wrap gap-3 mb-6">
    <h1 class="text-2xl font-bold">🗓️ Meal Plan Mingguan</h1>
    <div class="flex gap-2">
        <a href="{{ route('mealplan.index', ['start' => $start->copy()->subDays(7)->toDateString()]) }}"
           class="px-3 py-2 rounded-lg bg-white border border-stone-200 hover:bg-stone-50">← Minggu lalu</a>
        <a href="{{ route('mealplan.index') }}" class="px-3 py-2 rounded-lg bg-white border border-stone-200 hover:bg-stone-50">Hari ini</a>
        <a href="{{ route('mealplan.index', ['start' => $start->copy()->addDays(7)->toDateString()]) }}"
           class="px-3 py-2 rounded-lg bg-white border border-stone-200 hover:bg-stone-50">Minggu depan →</a>
    </div>
</div>

{{-- Form tambah rencana --}}
<form method="POST" action="{{ route('mealplan.store') }}" class="bg-white rounded-2xl border border-stone-200 p-4 mb-6 grid sm:grid-cols-5 gap-3 items-end">
    @csrf
    <div class="sm:col-span-2">
        <label class="text-xs font-medium text-stone-500">Makanan</label>
        <select name="food_id" required class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
            <option value="">— pilih makanan —</option>
            @foreach($foods as $f)
                <option value="{{ $f->id }}">{{ $f->name }} (per {{ rtrim(rtrim(number_format($f->serving_size,1),'0'),'.') }} {{ $f->serving_unit }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-xs font-medium text-stone-500">Tanggal</label>
        <input type="date" name="plan_date" required value="{{ $start->toDateString() }}"
               class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <div>
        <label class="text-xs font-medium text-stone-500">Jumlah</label>
        <input type="number" name="amount" step="0.1" min="0.1" required placeholder="100"
               class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <button class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">+ Rencanakan</button>
</form>

{{-- Grid 7 hari --}}
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach($days as $day)
        @php
            $dayPlans = $plans[$day->toDateString()] ?? collect();
            $dayCal = $dayPlans->sum(fn ($p) => $p->calories());
            $isToday = $day->isToday();
        @endphp
        <div class="rounded-2xl border {{ $isToday ? 'border-emerald-400 ring-2 ring-emerald-100' : 'border-stone-200' }} bg-white overflow-hidden">
            <div class="px-4 py-2.5 {{ $isToday ? 'bg-emerald-50' : 'bg-stone-50' }} flex justify-between items-center">
                <p class="text-sm font-bold {{ $isToday ? 'text-emerald-700' : '' }}">{{ $day->translatedFormat('D, d M') }} {{ $isToday ? '• Hari ini' : '' }}</p>
                <span class="text-xs text-stone-500">{{ number_format($dayCal) }} kkal</span>
            </div>
            <div class="p-3 space-y-2 min-h-16">
                @forelse($dayPlans as $plan)
                    <div class="flex items-center justify-between gap-2 text-sm {{ $plan->is_completed ? 'opacity-50' : '' }}">
                        <div class="flex items-center gap-2 min-w-0">
                            <form method="POST" action="{{ route('mealplan.toggle', $plan) }}">
                                @csrf @method('PATCH')
                                <button title="{{ $plan->is_completed ? 'Batalkan' : 'Tandai selesai (auto-catat ke diary)' }}"
                                        class="w-5 h-5 rounded-md border-2 {{ $plan->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-stone-300' }} flex items-center justify-center text-xs">
                                    {{ $plan->is_completed ? '✓' : '' }}
                                </button>
                            </form>
                            <span class="truncate {{ $plan->is_completed ? 'line-through' : '' }}">{{ $plan->food->name }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <span class="text-xs text-stone-400">{{ number_format($plan->calories()) }}</span>
                            <form method="POST" action="{{ route('mealplan.destroy', $plan) }}" onsubmit="return confirm('Hapus rencana ini?')">
                                @csrf @method('DELETE')
                                <button class="text-stone-300 hover:text-red-500">✕</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-stone-300 text-center py-3">Belum ada rencana</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
@endsection
