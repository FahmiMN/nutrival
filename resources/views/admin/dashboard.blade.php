@extends('layouts.nutrival')
@section('title', 'Dashboard Admin')
@section('content')

<h1 class="text-2xl font-bold mb-6">📊 Dashboard Admin</h1>

<div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
    @foreach([
        ['👥', 'Pengguna', $totalUsers],
        ['🍛', 'Makanan', $totalFoods],
        ['🗂️', 'Kategori', $totalCategories],
        ['⏳', 'Menunggu Approval', $pendingCount],
        ['📔', 'Total Log Makan', $totalLogs],
    ] as [$icon, $label, $val])
        <div class="bg-white rounded-2xl border border-stone-200 p-4">
            <p class="text-xs text-stone-500">{{ $icon }} {{ $label }}</p>
            <p class="text-2xl font-extrabold">{{ number_format($val) }}</p>
        </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-2xl border border-stone-200">
        <div class="px-5 py-4 border-b border-stone-100 flex justify-between">
            <h2 class="font-bold">⏳ Menunggu Approval</h2>
            <a href="{{ route('admin.approvals.index') }}" class="text-sm text-emerald-600 hover:underline">Kelola →</a>
        </div>
        @forelse($pendingFoods as $food)
            <div class="px-5 py-3 border-b border-stone-50 last:border-0 flex justify-between items-center">
                <div>
                    <p class="font-medium text-sm">{{ $food->name }}</p>
                    <p class="text-xs text-stone-500">oleh {{ $food->creator->name ?? '—' }} • {{ $food->created_at->diffForHumans() }}</p>
                </div>
                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-full">pending</span>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-stone-400 text-sm">Tidak ada yang menunggu. 🎉</p>
        @endforelse
    </div>

    <div class="bg-white rounded-2xl border border-stone-200">
        <div class="px-5 py-4 border-b border-stone-100 flex justify-between">
            <h2 class="font-bold">🆕 Pengguna Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-emerald-600 hover:underline">Kelola →</a>
        </div>
        @forelse($recentUsers as $u)
            <div class="px-5 py-3 border-b border-stone-50 last:border-0">
                <p class="font-medium text-sm">{{ $u->name }}</p>
                <p class="text-xs text-stone-500">{{ $u->email }} • daftar {{ $u->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-stone-400 text-sm">Belum ada pengguna.</p>
        @endforelse
    </div>
</div>
@endsection
