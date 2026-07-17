@extends('layouts.nutrival')
@section('title', $food ? 'Edit Makanan' : 'Tambah Makanan')
@section('content')

<h1 class="text-2xl font-bold mb-2">{{ $food ? '✏️ Edit Makanan Custom' : '🧑‍🍳 Tambah Makanan Custom' }}</h1>
<p class="text-sm text-stone-500 mb-6">Makanan langsung bisa kamu pakai. Admin akan mereview untuk memasukkannya ke katalog publik.</p>

<form method="POST"
      action="{{ $food ? route('customfood.update', $food) : route('customfood.store') }}"
      enctype="multipart/form-data"
      class="bg-white rounded-2xl border border-stone-200 p-6 max-w-2xl space-y-5">
    @csrf
    @if($food) @method('PUT') @endif

    <div class="grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="text-sm font-medium">Nama makanan *</label>
            <input type="text" name="name" required value="{{ old('name', $food->name ?? '') }}"
                   placeholder="mis. Nasi Kuning Banjar"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm font-medium">Kategori *</label>
            <select name="category_id" required class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
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
        </div>
        <div class="sm:col-span-2">
            <label class="text-sm font-medium">Deskripsi (opsional)</label>
            <textarea name="description" rows="2" placeholder="mis. Nasi kuning khas Banjar dengan lauk ayam habang"
                      class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $food->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4">
        <p class="font-semibold text-sm mb-3">Porsi standar *</p>
        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="text-sm">Ukuran</label>
                <input type="number" name="serving_size" step="0.1" min="0.1" required
                       value="{{ old('serving_size', $food->serving_size ?? 100) }}"
                       class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="text-sm">Satuan</label>
                <select name="serving_unit" required class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                    @foreach(['gram','ml','potong','buah','mangkuk','piring','sendok','gelas','tusuk','butir','lembar'] as $unit)
                        <option value="{{ $unit }}" @selected(old('serving_unit', $food->serving_unit ?? 'gram') === $unit)>{{ $unit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm">Deskripsi porsi (opsional)</label>
                <input type="text" name="serving_text" value="{{ old('serving_text', $food->serving_text ?? '') }}"
                       placeholder="mis. 1 mangkuk sedang"
                       class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4">
        <p class="font-semibold text-sm mb-3">Nutrisi per porsi standar *</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach([['calories','Kalori (kkal)'],['protein','Protein (g)'],['carbs','Karbo (g)'],['fat','Lemak (g)']] as [$field, $label])
                <div>
                    <label class="text-sm">{{ $label }}</label>
                    <input type="number" name="{{ $field }}" step="0.1" min="0" required
                           value="{{ old($field, $food->$field ?? '') }}"
                           class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            @endforeach
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4">
        <p class="font-semibold text-sm mb-3">Nutrisi tambahan (opsional)</p>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            @foreach([['fiber','Serat (g)'],['sugar','Gula (g)'],['sodium','Natrium (mg)'],['cholesterol','Kolesterol (mg)'],['saturated_fat','Lemak jenuh (g)']] as [$field, $label])
                <div>
                    <label class="text-xs">{{ $label }}</label>
                    <input type="number" name="{{ $field }}" step="0.1" min="0"
                           value="{{ old($field, $food->$field ?? '') }}"
                           class="mt-1 w-full rounded-xl border-stone-300 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700">
            {{ $food ? 'Simpan Perubahan' : 'Tambah Makanan' }}
        </button>
        <a href="{{ route('customfood.index') }}" class="px-6 py-3 rounded-xl bg-stone-100 font-semibold hover:bg-stone-200">Batal</a>
    </div>
</form>
@endsection
