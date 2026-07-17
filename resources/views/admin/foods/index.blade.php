@extends('layouts.nutrival')
@section('title', 'Kelola Makanan')
@section('content')

<div class="flex items-center justify-between flex-wrap gap-3 mb-6">
    <h1 class="text-2xl font-bold">🍛 Kelola Makanan</h1>
    <a href="{{ route('admin.foods.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">+ Tambah Makanan</a>
</div>

<form method="GET" action="{{ route('admin.foods.index') }}" class="flex flex-wrap gap-2 mb-5">
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari makanan…"
           class="flex-1 min-w-48 rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    <select name="category" onchange="this.form.submit()" class="rounded-xl border-stone-300">
        <option value="">Semua Kategori</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected($categoryId == $c->id)>{{ $c->icon }} {{ $c->name }}</option>
        @endforeach
    </select>
    <button class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-semibold">Cari</button>
</form>

<div class="bg-white rounded-2xl border border-stone-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-stone-50 text-left text-stone-500">
            <tr>
                <th class="px-4 py-3">Makanan</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Porsi</th>
                <th class="px-4 py-3 text-right">Kalori</th>
                <th class="px-4 py-3 text-right">P/K/L</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-50">
            @forelse($foods as $food)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $food->name }}
                        @if($food->is_custom)<span class="text-[10px] px-1.5 py-0.5 rounded bg-sky-100 text-sky-700 ml-1">custom</span>@endif
                    </td>
                    <td class="px-4 py-3">{{ $food->category->icon }} {{ $food->category->name }}</td>
                    <td class="px-4 py-3 text-stone-500">{{ $food->servingLabel() }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-emerald-700">{{ number_format($food->calories) }}</td>
                    <td class="px-4 py-3 text-right text-stone-500">{{ $food->protein }}/{{ $food->carbs }}/{{ $food->fat }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $food->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($food->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600') }}">
                            {{ $food->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('admin.foods.edit', $food) }}" class="px-2.5 py-1 rounded-lg bg-stone-100 hover:bg-stone-200 text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.foods.destroy', $food) }}" onsubmit="return confirm('Hapus {{ $food->name }}? Semua log yang memakai makanan ini ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button class="px-2.5 py-1 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-stone-400">Tidak ada makanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $foods->links() }}</div>
@endsection
