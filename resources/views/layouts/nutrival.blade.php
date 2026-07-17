<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nutrival') — Nutrival</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body{font-family:'Poppins',sans-serif}</style>
</head>
<body class="bg-stone-50 text-slate-800 antialiased">
<div class="flex min-h-screen">

    {{-- ============ SIDEBAR ============ --}}
    <aside class="hidden md:flex w-64 flex-col fixed inset-y-0 bg-white border-r border-stone-200">
        <div class="px-6 py-5 flex items-center gap-2">
            <span class="text-2xl">🥗</span>
            <span class="text-xl font-extrabold text-emerald-600">Nutri<span class="text-slate-800">val</span></span>
        </div>

        <nav class="flex-1 px-3 space-y-1 text-sm">
            @if(auth()->user()->isAdmin())
                <p class="px-3 pt-2 pb-1 text-xs font-semibold uppercase text-stone-400">Admin</p>
                <x-nav-item route="admin.dashboard" icon="📊">Dashboard</x-nav-item>
                <x-nav-item route="admin.foods.index" icon="🍛">Makanan</x-nav-item>
                <x-nav-item route="admin.categories.index" icon="🗂️">Kategori</x-nav-item>
                <x-nav-item route="admin.approvals.index" icon="✅">Approval</x-nav-item>
                <x-nav-item route="admin.users.index" icon="👥">Pengguna</x-nav-item>
            @else
                <x-nav-item route="user.dashboard" icon="🏠">Beranda</x-nav-item>
                <x-nav-item route="diary.index" icon="📔">Food Diary</x-nav-item>
                <x-nav-item route="mealplan.index" icon="🗓️">Meal Plan</x-nav-item>
                <x-nav-item route="foods.index" icon="🍛">Katalog Makanan</x-nav-item>
                <x-nav-item route="customfood.index" icon="➕">Makanan Saya</x-nav-item>
                <x-nav-item route="stats.index" icon="📈">Statistik</x-nav-item>
                <x-nav-item route="weight.index" icon="⚖️">Berat Badan</x-nav-item>
                <x-nav-item route="target.edit" icon="🎯">Target & Profil Gizi</x-nav-item>
            @endif
        </nav>

        <div class="p-4 border-t border-stone-200">
            <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-stone-500 truncate">{{ auth()->user()->email }}</p>
            <div class="mt-2 flex gap-3 text-xs">
                <a href="{{ route('profile.edit') }}" class="text-emerald-600 hover:underline">Akun</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:underline">Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ============ KONTEN ============ --}}
    <div class="flex-1 md:ml-64">
        {{-- Top bar mobile --}}
        <div class="md:hidden flex items-center justify-between bg-white border-b border-stone-200 px-4 py-3">
            <span class="font-extrabold text-emerald-600">🥗 Nutrival</span>
            <details class="relative">
                <summary class="cursor-pointer list-none px-3 py-1 rounded-lg bg-stone-100 text-sm">Menu</summary>
                <nav class="absolute right-0 mt-2 w-56 bg-white shadow-xl rounded-xl border border-stone-200 p-2 z-50 text-sm space-y-1">
                    @if(auth()->user()->isAdmin())
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('admin.foods.index') }}">🍛 Makanan</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('admin.categories.index') }}">🗂️ Kategori</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('admin.approvals.index') }}">✅ Approval</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('admin.users.index') }}">👥 Pengguna</a>
                    @else
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('user.dashboard') }}">🏠 Beranda</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('diary.index') }}">📔 Food Diary</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('mealplan.index') }}">🗓️ Meal Plan</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('foods.index') }}">🍛 Katalog</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('customfood.index') }}">➕ Makanan Saya</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('stats.index') }}">📈 Statistik</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('weight.index') }}">⚖️ Berat Badan</a>
                        <a class="block px-3 py-2 rounded-lg hover:bg-stone-50" href="{{ route('target.edit') }}">🎯 Target</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-stone-100 pt-1">
                        @csrf
                        <button class="w-full text-left px-3 py-2 rounded-lg text-red-500 hover:bg-red-50">Keluar</button>
                    </form>
                </nav>
            </details>
        </div>

        <main class="p-4 md:p-8 max-w-6xl">
            {{-- Flash message --}}
            @if(session('success'))
                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
