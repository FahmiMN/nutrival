@extends('layouts.nutrival')
@section('title', 'Target & Profil Gizi')
@section('content')

<h1 class="text-2xl font-bold mb-2">🎯 Target & Profil Gizi</h1>
<p class="text-sm text-stone-500 mb-6">Data tubuh dipakai untuk menghitung BMR & TDEE, lalu memberi rekomendasi target kalori sesuai goal-mu.</p>

@if($user->bmr())
    <div class="mb-6 grid grid-cols-3 gap-3 max-w-2xl">
        <div class="rounded-2xl bg-white border border-stone-200 p-4">
            <p class="text-xs text-stone-500">BMR</p>
            <p class="text-xl font-extrabold">{{ number_format($user->bmr()) }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-stone-200 p-4">
            <p class="text-xs text-stone-500">TDEE</p>
            <p class="text-xl font-extrabold">{{ $user->tdee() ? number_format($user->tdee()) : '—' }}</p>
        </div>
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4">
            <p class="text-xs text-emerald-600">Rekomendasi</p>
            <p class="text-xl font-extrabold text-emerald-700">{{ $user->recommendedCalories() ? number_format($user->recommendedCalories()) : '—' }}</p>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('target.update') }}" class="bg-white rounded-2xl border border-stone-200 p-6 max-w-2xl space-y-5">
    @csrf @method('PUT')

    <p class="font-semibold text-sm">Data Tubuh</p>
    <div class="grid sm:grid-cols-3 gap-4">
        <div>
            <label class="text-sm">Tanggal lahir</label>
            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->toDateString()) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm">Jenis kelamin</label>
            <select name="gender" class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">— pilih —</option>
                <option value="male" @selected(old('gender', $user->gender) === 'male')>Laki-laki</option>
                <option value="female" @selected(old('gender', $user->gender) === 'female')>Perempuan</option>
            </select>
        </div>
        <div>
            <label class="text-sm">Tinggi (cm)</label>
            <input type="number" name="height_cm" step="0.1" value="{{ old('height_cm', $user->height_cm) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm">Berat (kg)</label>
            <input type="number" name="weight_kg" step="0.1" value="{{ old('weight_kg', $user->weight_kg) }}"
                   class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="text-sm">Tingkat aktivitas</label>
            <select name="activity_level" class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">— pilih —</option>
                @foreach([
                    'sedentary' => 'Jarang olahraga (kerja duduk)',
                    'light' => 'Ringan (olahraga 1-3×/minggu)',
                    'moderate' => 'Sedang (3-5×/minggu)',
                    'active' => 'Aktif (6-7×/minggu)',
                    'very_active' => 'Sangat aktif (atlet/fisik berat)',
                ] as $val => $label)
                    <option value="{{ $val }}" @selected(old('activity_level', $user->activity_level) === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm">Goal</label>
            <select name="goal" class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">— pilih —</option>
                <option value="lose" @selected(old('goal', $user->goal) === 'lose')>Turun berat badan</option>
                <option value="maintain" @selected(old('goal', $user->goal) === 'maintain')>Jaga berat badan</option>
                <option value="gain" @selected(old('goal', $user->goal) === 'gain')>Naik berat badan</option>
            </select>
        </div>
    </div>

    <div class="border-t border-stone-100 pt-4">
        <div class="flex items-center justify-between mb-3">
            <p class="font-semibold text-sm">Target Harian</p>
            <label class="flex items-center gap-2 text-sm text-emerald-700">
                <input type="checkbox" name="use_recommendation" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                Gunakan rekomendasi otomatis (dari TDEE & goal)
            </label>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach([
                ['calorie_target', 'Kalori (kkal)'],
                ['protein_target', 'Protein (g)'],
                ['carb_target', 'Karbo (g)'],
                ['fat_target', 'Lemak (g)'],
            ] as [$field, $label])
                <div>
                    <label class="text-sm">{{ $label }}</label>
                    <input type="number" name="{{ $field }}" value="{{ old($field, $user->$field) }}"
                           class="mt-1 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            @endforeach
        </div>
    </div>

    <button class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700">Simpan</button>
</form>
@endsection
