@extends('layouts.nutrival')
@section('title', 'Edit Catatan')
@section('content')

<h1 class="text-2xl font-bold mb-6">✏️ Edit Catatan</h1>

<div class="bg-white rounded-2xl border border-stone-200 p-5 max-w-lg">
    <div class="flex items-center gap-3 mb-5 pb-5 border-b border-stone-100">
        <span class="text-3xl">{{ $log->food->category->icon ?? '🍽️' }}</span>
        <div>
            <p class="font-bold">{{ $log->food->name }}</p>
            <p class="text-xs text-stone-500">{{ $log->food->servingLabel() }} = {{ number_format($log->food->calories) }} kkal</p>
        </div>
    </div>

    <form method="POST" action="{{ route('diary.update', $log) }}" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="text-sm font-medium">Tanggal</label>
            <input type="date" name="log_date" required value="{{ old('log_date', $log->log_date->toDateString()) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Jam</label>
            <input type="time" name="log_time" required value="{{ old('log_time', substr($log->log_time, 0, 5)) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Jumlah ({{ $log->food->serving_unit }})</label>
            <input type="number" name="amount" step="0.1" min="0.1" required value="{{ old('amount', $log->amount) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Catatan</label>
            <input type="text" name="note" value="{{ old('note', $log->note) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div class="flex gap-3 pt-2">
            <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan</button>
            <a href="{{ route('diary.index', ['date' => $log->log_date->toDateString()]) }}" class="px-6 py-3 rounded-xl bg-stone-100 font-semibold hover:bg-stone-200">Batal</a>
        </div>
    </form>
</div>
@endsection
