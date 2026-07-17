@extends('layouts.nutrival')
@section('title', 'Makanan Saya')
@section('content')

<div class="flex items-center justify-between flex-wrap gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold">➕ Makanan Saya</h1>
        <p class="text-sm text-stone-500">Makanan custom yang kamu tambahkan. Langsung bisa dipakai — status "Disetujui" berarti sudah masuk katalog publik.</p>
    </div>
    <a href="{{ route('customfood.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700">+ Tambah</a>
</div>

<div class="bg-white rounded-2xl border border-stone-200 divide-y divide-stone-50">
    @forelse($foods as $food)
        <div class="px-5 py-4 flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $food->category->icon ?? '🍽️' }}</span>
                <div>
                    <p class="font-semibold">{{ $food->name }}</p>
                    <p class="text-xs text-stone-500">{{ $food->servingLabel() }} • {{ number_format($food->calories) }} kkal</p>
                    @if($food->status === 'rejected' && $food->admin_note)
                        <p class="text-xs text-red-500 mt-0.5">Catatan admin: {{ $food->admin_note }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($food->status === 'approved')
                    <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium">✔ Disetujui</span>
                @elseif($food->status === 'pending')
                    <span class="text-xs px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">⏳ Menunggu review</span>
                @else
                    <span class="text-xs px-2.5 py-1 rounded-full bg-red-100 text-red-600 font-medium">✖ Ditolak (tetap bisa dipakai pribadi)</span>
                @endif
                <a href="{{ route('customfood.edit', $food) }}" class="text-sm px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200">Edit</a>
                <form method="POST" action="{{ route('customfood.destroy', $food) }}" onsubmit="return confirm('Hapus makanan ini? Log diary yang memakai makanan ini juga akan terhapus.')">
                    @csrf @method('DELETE')
                    <button class="text-sm px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="px-5 py-12 text-center text-stone-400">
            <p class="text-3xl mb-2">🧑‍🍳</p>
            <p>Belum ada makanan custom. Makanan rumahan yang tidak ada di katalog? Tambahkan di sini.</p>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $foods->links() }}</div>
@endsection
