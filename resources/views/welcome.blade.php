<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nutrival — Catat Makan, Capai Target Sehatmu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body{font-family:'Poppins',sans-serif}</style>
</head>
<body class="bg-stone-50 text-slate-800 antialiased">

<nav class="max-w-5xl mx-auto flex items-center justify-between px-6 py-5">
    <span class="text-xl font-extrabold text-emerald-600">🥗 Nutri<span class="text-slate-800">val</span></span>
    <div class="flex gap-3 text-sm">
        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl font-semibold hover:bg-stone-100">Masuk</a>
        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Daftar Gratis</a>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-6">
    <section class="py-16 md:py-24 text-center">
        <p class="inline-block text-xs font-semibold bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full mb-4">Food Diary • Meal Prep • Statistik Gizi</p>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">
            Catat makan,<br><span class="text-emerald-600">capai target sehatmu.</span>
        </h1>
        <p class="mt-4 text-stone-500 max-w-xl mx-auto">
            Nutrival membantumu mencatat makanan harian, merencanakan meal prep mingguan,
            dan memantau kalori, protein, karbo, dan lemak lengkap dengan data makanan Indonesia.
        </p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700">Mulai Sekarang →</a>
            <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-white border border-stone-200 font-bold hover:bg-stone-100">Masuk</a>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-4 pb-20">
        @foreach([
            ['📔', 'Food Diary Harian', 'Catat apa yang kamu makan kalori & macro terhitung otomatis dari database makanan Indonesia & internasional.'],
            ['🗓️', 'Meal Prep Mingguan', 'Rencanakan menu 7 hari ke depan. Tandai selesai, otomatis tercatat ke diary.'],
            ['📈', 'Statistik & Target', 'Grafik mingguan, streak, tren berat badan, plus kalkulator BMR/TDEE untuk rekomendasi target kalorimu.'],
        ] as [$icon, $title, $desc])
            <div class="bg-white rounded-2xl border border-stone-200 p-6">
                <p class="text-3xl">{{ $icon }}</p>
                <p class="font-bold mt-3">{{ $title }}</p>
                <p class="text-sm text-stone-500 mt-1">{{ $desc }}</p>
            </div>
        @endforeach
    </section>
</main>

<footer class="border-t border-stone-200 py-6 text-center text-xs text-stone-400">
    Nutrival • Data gizi mengacu pada TKPI Kemenkes RI & USDA FoodData Central
</footer>
</body>
</html>
