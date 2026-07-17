@extends('layouts.nutrival')
@section('title', 'Catat Makanan')
@section('content')

<h1 class="text-2xl font-bold mb-6">➕ Catat Makanan</h1>

{{-- Search --}}
<form method="GET" action="{{ route('diary.create') }}" class="mb-5 flex gap-2">
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari makanan… (mis. nasi, ayam)"
           class="flex-1 rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    <button class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-semibold">Cari</button>
</form>

<form method="POST" action="{{ route('diary.store') }}">
    @csrf
    <input type="hidden" name="log_date" value="{{ $date }}">

    {{-- Pilih makanan --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
        @forelse($foods as $food)
            <label class="cursor-pointer group">
                <input type="radio" name="food_id" value="{{ $food->id }}" class="peer sr-only" required
                       data-unit="{{ $food->serving_unit }}" data-size="{{ $food->serving_size }}">
                <div class="rounded-2xl bg-white border-2 border-stone-200 overflow-hidden transition
                            peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 hover:border-stone-300">
                    <x-food-img :food="$food" class="w-full h-28" />
                    <div class="p-3">
                        <p class="font-semibold text-sm leading-tight">{{ $food->name }}</p>
                        <p class="text-xs text-stone-500">{{ $food->servingLabel() }}</p>
                        <p class="text-xs font-bold text-emerald-700 mt-1">{{ number_format($food->calories) }} kkal</p>
                        @if($food->is_custom && $food->status !== 'approved')
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-100 text-amber-700">Pribadi</span>
                        @endif
                    </div>
                </div>
            </label>
        @empty
            <p class="col-span-full text-stone-400 text-center py-8">
                Tidak ada hasil untuk "{{ $q }}".
                <a href="{{ route('customfood.create') }}" class="text-emerald-600 underline">Tambah sebagai makanan custom →</a>
            </p>
        @endforelse
    </div>

    {{-- Detail konsumsi --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5 grid sm:grid-cols-3 gap-4">
        <div>
            <label class="text-sm font-medium">Jumlah <span id="unitLabel" class="text-stone-400"></span></label>
            <input type="number" name="amount" step="0.1" min="0.1" required value="{{ old('amount') }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="mis. 200">
        </div>
        <div>
            <label class="text-sm font-medium">Jam makan</label>
            <input type="time" name="log_time" required value="{{ old('log_time', now()->format('H:i')) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Catatan (opsional)</label>
            <input type="text" name="note" value="{{ old('note') }}" placeholder="mis. makan di kantin"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div class="sm:col-span-3 flex gap-3">
            <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700">Simpan Catatan</button>
            <a href="{{ route('diary.index', ['date' => $date]) }}" class="px-6 py-3 rounded-xl bg-stone-100 font-semibold hover:bg-stone-200">Batal</a>
        </div>
    </div>
</form>

<script>
// Saat pilih makanan → tampilkan satuan & prefill jumlah dengan porsi standar
document.querySelectorAll('input[name=food_id]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('unitLabel').textContent = '(' + radio.dataset.unit + ')';
        const amountInput = document.querySelector('input[name=amount]');
        if (!amountInput.value) amountInput.value = radio.dataset.size;
    });
});
</script>
@endsection
