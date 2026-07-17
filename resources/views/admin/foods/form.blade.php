@extends('layouts.nutrival')
@section('title', $food ? 'Edit Makanan' : 'Tambah Makanan')
@section('content')

<h1 class="text-2xl font-bold mb-6">{{ $food ? '✏️ Edit Makanan' : '➕ Tambah Makanan (Master)' }}</h1>

<form method="POST"
      action="{{ $food ? route('admin.foods.update', $food) : route('admin.foods.store') }}"
      enctype="multipart/form-data"
      class="bg-white rounded-2xl border border-stone-200 p-6 max-w-2xl space-y-5">
    @csrf
    @if($food) @method('PUT') @endif

    <div class="grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="text-sm font-medium">Nama makanan *</label>
            <input type="text" name="name" required value="{{ old('name', $food->name ?? '') }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Kategori *</label>
            <select name="category_id" required class="mt-1 w-full rounded-xl border-stone-300">
                <option value="">— pilih —</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $food->category_id ?? '') == $c->id)>{{ $c->icon }} {{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-medium">Foto (opsional, maks 2MB)</label>
            <input type="file" name="image" accept="image/*"
                   class="mt-1 w-full text-sm file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700">
            @if($food?->image_path)<p class="text-xs text-stone-400 mt-1">Sudah ada foto — upload untuk mengganti.</p>@endif
        </div>
        <div class="sm:col-span-2">
            <label class="text-sm font-medium">Deskripsi (opsional)</label>
            <textarea name="description" rows="2" class="mt-1 w-full rounded-xl border-stone-300">{{ old('description', $food->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4 grid sm:grid-cols-3 gap-4">
        <div>
            <label class="text-sm">Ukuran porsi *</label>
            <input type="number" name="serving_size" step="0.1" min="0.1" required value="{{ old('serving_size', $food->serving_size ?? 100) }}"
                   class="mt-1 w-full rounded-xl border-stone-300">
        </div>
        <div>
            <label class="text-sm">Satuan *</label>
            <select name="serving_unit" required class="mt-1 w-full rounded-xl border-stone-300">
                @foreach(['gram','ml','potong','buah','mangkuk','piring','sendok','gelas','tusuk','butir','lembar'] as $unit)
                    <option value="{{ $unit }}" @selected(old('serving_unit', $food->serving_unit ?? 'gram') === $unit)>{{ $unit }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm">Deskripsi porsi</label>
            <input type="text" name="serving_text" value="{{ old('serving_text', $food->serving_text ?? '') }}" placeholder="1 mangkuk sedang"
                   class="mt-1 w-full rounded-xl border-stone-300">
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach([['calories','Kalori *'],['protein','Protein (g) *'],['carbs','Karbo (g) *'],['fat','Lemak (g) *']] as [$field, $label])
            <div>
                <label class="text-sm">{{ $label }}</label>
                <input type="number" name="{{ $field }}" step="0.1" min="0" required value="{{ old($field, $food->$field ?? '') }}"
                       class="mt-1 w-full rounded-xl border-stone-300">
            </div>
        @endforeach
    </div>

    <div class="border-t border-stone-100 pt-4 grid grid-cols-2 sm:grid-cols-5 gap-4">
        @foreach([['fiber','Serat (g)'],['sugar','Gula (g)'],['sodium','Natrium (mg)'],['cholesterol','Kolesterol (mg)'],['saturated_fat','Lemak jenuh (g)']] as [$field, $label])
            <div>
                <label class="text-xs">{{ $label }}</label>
                <input type="number" name="{{ $field }}" step="0.1" min="0" value="{{ old($field, $food->$field ?? '') }}"
                       class="mt-1 w-full rounded-xl border-stone-300 text-sm">
            </div>
        @endforeach
    </div>

    <div class="flex gap-3 pt-2">
        <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan</button>
        <a href="{{ route('admin.foods.index') }}" class="px-6 py-3 rounded-xl bg-stone-100 font-semibold hover:bg-stone-200">Batal</a>
    </div>
</form>
@endsection
