<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nutrival, Catat Makan, Capai Target Sehatmu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .wavy-underline {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 20'%3E%3Cpath d='M0,10 Q15,0 30,10 T60,10 T90,10 T120,10' stroke='%2310b981' stroke-width='4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: repeat-x;
            background-position: bottom left;
            background-size: 120px 20px;
            padding-bottom: 18px;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-stone-50 text-slate-800 antialiased">

<nav class="max-w-6xl mx-auto flex items-center justify-between px-6 py-6">
    <div class="text-2xl font-extrabold text-emerald-600 flex items-center gap-2">
        <span class="text-3xl">🥗</span>
        <span>Nutri<span class="text-slate-800">val</span></span>
    </div>
    <div class="flex items-center gap-3 text-sm">
        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl font-semibold text-slate-700 hover:bg-stone-100 transition">Masuk</a>
        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">Daftar Gratis</a>
    </div>
</nav>

{{-- ========== HERO SECTION ========== --}}
<section class="max-w-6xl mx-auto px-6 py-8 md:py-12 grid lg:grid-cols-2 gap-12 items-center">
    <div>
        <div class="inline-flex items-center gap-2 bg-emerald-100/70 border border-emerald-200 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-8">
            🔥 <span>#1 Pelacak Makanan Khas Indonesia</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-extrabold leading-[1.1] text-slate-900 tracking-tight">
            Catat makan,<br>
            capai target<br>
            <span class="wavy-underline">sehatmu.</span>
        </h1>
        <p class="mt-8 text-base md:text-lg text-slate-500 max-w-lg leading-relaxed">
            Nutrival membantu Anda memantau kalori, protein, karbohidrat, dan lemak secara akurat dengan basis data makanan lokal Indonesia yang lengkap, mulai dari nasi goreng hingga penyetan.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('register') }}" class="px-6 py-4 rounded-2xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">
                Mulai Sekarang, Gratis
            </a>
            <a href="#kalkulator" class="px-6 py-4 rounded-2xl bg-white border border-stone-200 text-slate-800 font-bold hover:bg-stone-50 transition">
                Hitung Kalori Instan
            </a>
        </div>
    </div>

    {{-- ========== WIDGET PREVIEW DASHBOARD ========== --}}
    <div class="relative">
        <div class="absolute -inset-4 bg-gradient-to-br from-emerald-100 to-amber-50 rounded-[3rem] blur-3xl opacity-50"></div>
        <div class="relative bg-white rounded-[2rem] shadow-2xl shadow-emerald-100/40 border border-stone-200/70 p-5 md:p-6 max-w-md ml-auto transform rotate-1 hover:rotate-0 transition-transform duration-500">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <p class="text-xs text-stone-400 font-medium mb-0.5">Ringkasan Hari Ini</p>
                    <p class="text-lg font-extrabold text-slate-900">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F') }}</p>
                </div>
                <div class="flex items-center gap-1.5 bg-amber-50 border border-amber-200 rounded-full px-2.5 py-1">
                    <span class="text-sm">🔥</span>
                    <span class="text-xs font-bold text-amber-700">Streak 5 Hari</span>
                </div>
            </div>

            <div class="flex items-center gap-5 mb-4">
                <div class="relative w-24 h-24 shrink-0">
                    <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                        <circle cx="50" cy="50" r="42" stroke="#e7e5e4" stroke-width="9" fill="none"/>
                        <circle cx="50" cy="50" r="42" stroke="#059669" stroke-width="9" fill="none"
                                stroke-dasharray="264" stroke-dashoffset="76.6" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">1,420</span>
                        <span class="text-[9px] text-stone-400 mt-1 tracking-widest font-semibold">KCAL SISA</span>
                    </div>
                </div>

                <div class="flex-1 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-stone-500 font-medium">Makanan</span>
                        <span class="font-extrabold text-slate-900">580 kcal</span>
                    </div>
                    <div class="h-2 rounded-full bg-stone-100 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: 29%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-stone-500 font-medium">Target batas</span>
                        <span class="font-extrabold text-slate-900">2,000 kcal</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2">
                @foreach([
                    ['label' => 'KARBO', 'val' => '75g', 'tgt' => '250g'],
                    ['label' => 'PROTEIN', 'val' => '45g', 'tgt' => '120g'],
                    ['label' => 'LEMAK', 'val' => '18g', 'tgt' => '65g'],
                ] as $m)
                    <div class="rounded-2xl border border-stone-200 px-2 py-2.5 text-center">
                        <p class="text-[10px] font-bold text-stone-400 tracking-widest mb-1">{{ $m['label'] }}</p>
                        <p class="text-xs font-extrabold text-emerald-600">
                            {{ $m['val'] }} <span class="text-stone-400 font-medium">/ {{ $m['tgt'] }}</span>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ========== KALKULATOR BMI SECTION ========== --}}
<section id="kalkulator" class="max-w-4xl mx-auto px-6 py-20">
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Hitung Kebutuhan Kalorimu</h2>
        <p class="mt-3 text-slate-500 max-w-xl mx-auto">
            Coba kalkulator instan ini untuk mengetahui estimasi status berat badan Anda sebelum mendaftar.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-sm p-6 md:p-8">
        <div class="grid md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="text-xs font-bold text-stone-500 tracking-widest">BERAT BADAN (KG)</label>
                <input type="number" id="bmi-bb" step="0.1" min="20" max="300" placeholder="Contoh: 65"
                       class="mt-1.5 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500 text-lg">
            </div>
            <div>
                <label class="text-xs font-bold text-stone-500 tracking-widest">TINGGI BADAN (CM)</label>
                <input type="number" id="bmi-tb" step="0.1" min="80" max="250" placeholder="Contoh: 170"
                       class="mt-1.5 w-full rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500 text-lg">
            </div>
            <button onclick="hitungBMI()"
                    class="px-6 py-3.5 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition">
                Hitung Sekarang →
            </button>
        </div>

        <div id="hasil-bmi" class="hidden mt-6 pt-6 border-t border-stone-100">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div>
                    <p class="text-xs font-bold text-stone-500 tracking-widest">INDEKS MASSA TUBUH (IMT)</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span id="bmi-value" class="text-5xl font-extrabold text-slate-900">0</span>
                        <span id="bmi-status" class="text-lg font-bold">Normal</span>
                    </div>
                    <p id="bmi-ideal" class="text-sm text-stone-500 mt-2"></p>
                </div>
                <div class="text-center md:text-right">
                    <a href="{{ route('register') }}"
                       class="inline-block px-6 py-3.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition">
                        Daftar Gratis untuk Analisis Lengkap →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========== 3 FITUR UTAMA ========== --}}
<section class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Semua yang Anda butuhkan</h2>
        <p class="mt-3 text-slate-500">Fitur lengkap untuk pola makan yang terarah.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-5">
        @foreach([
            ['icon' => '📔', 'title' => 'Food Diary Harian', 'desc' => 'Catat apa yang Anda makan. Kalori dan makro terhitung otomatis dari database makanan Indonesia dan internasional.'],
            ['icon' => '🗓️', 'title' => 'Meal Prep Mingguan', 'desc' => 'Rencanakan menu tujuh hari ke depan. Tandai selesai, otomatis tercatat ke diary.'],
            ['icon' => '📈', 'title' => 'Statistik & Target', 'desc' => 'Grafik mingguan, streak, tren berat badan, plus kalkulator BMR/TDEE untuk rekomendasi target kalori Anda.'],
        ] as $f)
            <div class="bg-white rounded-2xl border border-stone-200 p-6 hover:shadow-lg hover:border-emerald-300 transition">
                <div class="text-4xl mb-3">{{ $f['icon'] }}</div>
                <p class="font-bold text-lg text-slate-900">{{ $f['title'] }}</p>
                <p class="text-sm text-stone-500 mt-2 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ========== CTA BOTTOM ========== --}}
<section class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-3xl p-8 md:p-12 text-center text-white shadow-xl shadow-emerald-200">
        <h2 class="text-3xl md:text-4xl font-extrabold">Siap mulai perjalanan sehat Anda?</h2>
        <p class="mt-3 text-emerald-100">Gratis untuk selalu. Tidak perlu kartu kredit.</p>
        <a href="{{ route('register') }}"
           class="inline-block mt-6 px-8 py-4 rounded-2xl bg-white text-emerald-700 font-bold hover:bg-stone-100 transition">
            Buat Akun Sekarang →
        </a>
    </div>
</section>

<footer class="border-t border-stone-200 py-6 text-center text-xs text-stone-400 mt-10">
    Nutrival, Proyek UAS Pemrograman Web 2. Data gizi mengacu pada TKPI Kemenkes RI dan USDA FoodData Central.
</footer>

<script>
function hitungBMI() {
    const bb = parseFloat(document.getElementById('bmi-bb').value);
    const tbCm = parseFloat(document.getElementById('bmi-tb').value);

    if (!bb || !tbCm) {
        alert('Mohon isi berat dan tinggi badan.');
        return;
    }

    const tb = tbCm / 100;
    const bmi = bb / (tb * tb);

    let status = '';
    let statusColor = '';
    if (bmi < 18.5) { status = 'Kurus'; statusColor = 'text-sky-600'; }
    else if (bmi < 25) { status = 'Normal ✓'; statusColor = 'text-emerald-600'; }
    else if (bmi < 30) { status = 'Berlebih'; statusColor = 'text-amber-600'; }
    else { status = 'Obesitas'; statusColor = 'text-rose-600'; }

    const idealMin = (18.5 * tb * tb).toFixed(1);
    const idealMax = (24.9 * tb * tb).toFixed(1);

    document.getElementById('bmi-value').textContent = bmi.toFixed(1);
    const statusEl = document.getElementById('bmi-status');
    statusEl.textContent = status;
    statusEl.className = 'text-lg font-bold ' + statusColor;
    document.getElementById('bmi-ideal').textContent =
        `Berat ideal Anda dalam rentang ${idealMin} kg sampai ${idealMax} kg.`;

    const hasil = document.getElementById('hasil-bmi');
    hasil.classList.remove('hidden');
    hasil.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>

</body>
</html>