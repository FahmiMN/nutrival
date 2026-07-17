@extends('layouts.nutrival')
@section('title', 'Berat Badan')
@section('content')

<h1 class="text-2xl font-bold mb-6">⚖️ Catatan Berat Badan</h1>

<form method="POST" action="{{ route('weight.store') }}" class="bg-white rounded-2xl border border-stone-200 p-4 mb-6 grid sm:grid-cols-4 gap-3 items-end max-w-2xl">
    @csrf
    <div>
        <label class="text-xs font-medium text-stone-500">Tanggal</label>
        <input type="date" name="log_date" required value="{{ now()->toDateString() }}" max="{{ now()->toDateString() }}"
               class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <div>
        <label class="text-xs font-medium text-stone-500">Berat (kg)</label>
        <input type="number" name="weight_kg" step="0.1" min="20" max="400" required placeholder="65.5"
               class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <div>
        <label class="text-xs font-medium text-stone-500">Catatan (opsional)</label>
        <input type="text" name="note" class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <button class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Simpan</button>
</form>

<div class="bg-white rounded-2xl border border-stone-200 divide-y divide-stone-50 max-w-2xl">
    @forelse($logs as $log)
        <div class="px-5 py-3 flex items-center justify-between">
            <div>
                <p class="font-semibold">{{ $log->weight_kg }} kg</p>
                <p class="text-xs text-stone-500">{{ $log->log_date->translatedFormat('d F Y') }} @if($log->note) • {{ $log->note }} @endif</p>
            </div>
            <form method="POST" action="{{ route('weight.destroy', $log) }}" onsubmit="return confirm('Hapus catatan ini?')">
                @csrf @method('DELETE')
                <button class="text-sm px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
            </form>
        </div>
    @empty
        <p class="px-5 py-10 text-center text-stone-400">Belum ada catatan berat badan.</p>
    @endforelse
</div>

<div class="mt-4 max-w-2xl">{{ $logs->links() }}</div>
@endsection
