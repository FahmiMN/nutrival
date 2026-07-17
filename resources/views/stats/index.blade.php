@extends('layouts.nutrival')
@section('title', 'Statistik')
@section('content')

<h1 class="text-2xl font-bold mb-6">📈 Statistik</h1>

{{-- Kartu ringkasan --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-white rounded-2xl border border-stone-200 p-4">
        <p class="text-xs text-stone-500">🔥 Streak</p>
        <p class="text-2xl font-extrabold text-amber-600">{{ $streak }} <span class="text-sm font-normal">hari</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-stone-200 p-4">
        <p class="text-xs text-stone-500">BMR</p>
        <p class="text-2xl font-extrabold">{{ $bmr ? number_format($bmr) : '—' }} <span class="text-sm font-normal">kkal</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-stone-200 p-4">
        <p class="text-xs text-stone-500">TDEE</p>
        <p class="text-2xl font-extrabold">{{ $tdee ? number_format($tdee) : '—' }} <span class="text-sm font-normal">kkal</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-stone-200 p-4">
        <p class="text-xs text-stone-500">Rekomendasi harian</p>
        <p class="text-2xl font-extrabold text-emerald-600">{{ $recommended ? number_format($recommended) : '—' }} <span class="text-sm font-normal">kkal</span></p>
    </div>
</div>

@if(!$bmr)
    <div class="mb-6 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 px-4 py-3 text-sm">
        💡 Lengkapi data tubuh di <a href="{{ route('target.edit') }}" class="font-semibold underline">Target & Profil Gizi</a> untuk melihat BMR, TDEE, dan rekomendasi kalori.
    </div>
@endif

<div class="grid lg:grid-cols-2 gap-4 mb-4">
    {{-- Grafik mingguan --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <h2 class="font-bold mb-3">Kalori 7 Hari Terakhir</h2>
        <canvas id="weeklyChart" height="200"></canvas>
    </div>

    {{-- Macro hari ini --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <h2 class="font-bold mb-3">Komposisi Macro Hari Ini</h2>
        @if(array_sum($todayMacros) > 0)
            <div class="max-w-52 mx-auto"><canvas id="macroChart"></canvas></div>
        @else
            <p class="text-sm text-stone-400 text-center py-10">Belum ada catatan hari ini.</p>
        @endif
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-4">
    {{-- Grafik bulanan --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <h2 class="font-bold mb-3">Kalori 30 Hari Terakhir</h2>
        <canvas id="monthlyChart" height="200"></canvas>
    </div>

    {{-- Grafik berat badan --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <div class="flex justify-between items-center mb-3">
            <h2 class="font-bold">Tren Berat Badan</h2>
            <a href="{{ route('weight.index') }}" class="text-sm text-emerald-600 hover:underline">Catat →</a>
        </div>
        @if($weights->count())
            <canvas id="weightChart" height="200"></canvas>
        @else
            <p class="text-sm text-stone-400 text-center py-10">Belum ada catatan berat badan.</p>
        @endif
    </div>
</div>

<script>
const target = {{ $user->calorie_target ?? 'null' }};

new Chart(document.getElementById('weeklyChart'), {
    type: 'bar',
    data: {
        labels: @json($weekly['labels']),
        datasets: [{ label: 'Kalori', data: @json($weekly['values']), backgroundColor: '#059669', borderRadius: 8 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: @json($monthly['labels']),
        datasets: [{ label: 'Kalori', data: @json($monthly['values']), borderColor: '#059669', backgroundColor: 'rgba(5,150,105,.08)', fill: true, tension: .35, pointRadius: 2 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

@if(array_sum($todayMacros) > 0)
new Chart(document.getElementById('macroChart'), {
    type: 'doughnut',
    data: {
        labels: ['Protein (g)', 'Karbohidrat (g)', 'Lemak (g)'],
        datasets: [{ data: [{{ $todayMacros['protein'] }}, {{ $todayMacros['carbs'] }}, {{ $todayMacros['fat'] }}],
                     backgroundColor: ['#0ea5e9', '#f59e0b', '#fb7185'], borderWidth: 0 }]
    },
    options: { cutout: '60%' }
});
@endif

@if($weights->count())
new Chart(document.getElementById('weightChart'), {
    type: 'line',
    data: {
        labels: @json($weights->map(fn ($w) => $w->log_date->format('d/m'))),
        datasets: [{ label: 'Berat (kg)', data: @json($weights->pluck('weight_kg')), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.1)', fill: true, tension: .3 }]
    },
    options: { plugins: { legend: { display: false } } }
});
@endif
</script>
@endsection
