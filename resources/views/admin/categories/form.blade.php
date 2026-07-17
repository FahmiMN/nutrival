@extends('layouts.nutrival')
@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')

<h1 class="text-2xl font-bold mb-6">{{ $category ? '✏️ Edit Kategori' : '➕ Tambah Kategori' }}</h1>

<form method="POST"
      action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      class="bg-white rounded-2xl border border-stone-200 p-6 max-w-md space-y-4">
    @csrf
    @if($category) @method('PUT') @endif

    <div>
        <label class="text-sm font-medium">Nama kategori *</label>
        <input type="text" name="name" required value="{{ old('name', $category->name ?? '') }}"
               placeholder="mis. Nasi & Karbohidrat"
               class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <div>
        <label class="text-sm font-medium">Icon (emoji, opsional)</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" placeholder="🍚" maxlength="10"
               class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    </div>
    <div class="flex gap-3 pt-2">
        <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 rounded-xl bg-stone-100 font-semibold hover:bg-stone-200">Batal</a>
    </div>
</form>
@endsection
