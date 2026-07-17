<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nutrival') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body{font-family:'Poppins',sans-serif}</style>
</head>
<body class="bg-stone-50 text-slate-800 antialiased min-h-screen">
    <div class="min-h-screen flex flex-col">
        {{-- Header --}}
        <nav class="max-w-5xl w-full mx-auto flex items-center justify-between px-6 py-5">
            <a href="{{ url('/') }}" class="text-xl font-extrabold text-emerald-600 hover:opacity-80 transition">
                🥗 Nutri<span class="text-slate-800">val</span>
            </a>
            <a href="{{ url('/') }}" class="text-sm text-stone-500 hover:text-emerald-600 transition">← Kembali ke Beranda</a>
        </nav>

        {{-- Main Content --}}
        <main class="flex-1 flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-md">
                {{-- Logo / Icon Card --}}
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg shadow-emerald-200 text-3xl mb-4">
                        🥗
                    </div>
                    <p class="text-sm text-stone-500">Catat makan, capai target sehatmu.</p>
                </div>

                {{-- Form Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6 md:p-8">
                    {{ $slot }}
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="text-center text-xs text-stone-400 py-4 px-4">
            Nutrival — Proyek UAS Pemrograman Web 2
        </footer>
    </div>
</body>
</html>