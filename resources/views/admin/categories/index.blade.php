@extends('layouts.nutrival')
@section('title', 'Kategori')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">🗂️ Kategori Makanan</h1>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">+ Tambah</a>
</div>

<div class="bg-white rounded-2xl border border-stone-200 divide-y divide-stone-50 max-w-2xl">
    @forelse($categories as $c)
        <div class="px-5 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $c->icon }}</span>
                <div>
                    <p class="font-semibold">{{ $c->name }}</p>
                    <p class="text-xs text-stone-500">{{ $c->foods_count }} makanan</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $c) }}" class="text-sm px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200">Edit</a>
                <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Hapus kategori {{ $c->name }}?')">
                    @csrf @method('DELETE')
                    <button class="text-sm px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="px-5 py-10 text-center text-stone-400">Belum ada kategori.</p>
    @endforelse
</div>
@endsection
