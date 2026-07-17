# Nutrival

Aplikasi web berbahasa Indonesia untuk mencatat makanan harian, merencanakan meal prep mingguan, dan memantau asupan gizi. Dibangun sebagai proyek Ujian Akhir Semester mata kuliah Pemrograman Web 2, Universitas Islam Kalimantan Muhammad Arsyad Al Banjari.

## Fitur

**Untuk Pengguna**

- Food Diary harian dengan CRUD lengkap. Kalori dan makro terhitung otomatis dari porsi yang dimasukkan.
- Meal Plan mingguan. Rencana yang ditandai selesai tersalin otomatis ke Food Diary.
- Katalog 60 makanan Indonesia dan internasional dengan data gizi dari TKPI (Kemenkes RI) dan USDA FoodData Central.
- Custom Food. User bisa menambah makanan yang tidak ada di katalog, langsung bisa dipakai sambil menunggu review admin untuk masuk katalog publik.
- Kalkulator BMR dan TDEE memakai rumus Mifflin-St Jeor. Sistem memberi rekomendasi target kalori sesuai goal (turun, jaga, atau naik berat badan).
- Statistik dengan Chart.js. Grafik kalori 7 dan 30 hari, komposisi makro, streak pencatatan berturut-turut, dan tren berat badan.
- Pencatatan berat badan berkala dengan visualisasi tren.

**Untuk Admin**

- CRUD kategori dan makanan master.
- Alur approval makanan custom dari user. Admin bisa menyetujui langsung, mengoreksi nilai gizi dulu baru menyetujui, atau menolak dengan alasan.
- Manajemen pengguna: aktivasi, nonaktifkan, hapus akun.
- Dashboard ringkasan sistem.

## Tech Stack

- **Framework:** Laravel 12 (PHP 8.3)
- **Frontend:** Blade Templating dan Tailwind CSS via Vite
- **Autentikasi:** Laravel Breeze berbasis session
- **Database:** SQLite (kompatibel dengan MySQL 8)
- **ORM:** Eloquent
- **Visualisasi Data:** Chart.js 4
- **Server Development:** Laragon

## Instalasi Lokal

Prasyarat: PHP 8.3, Composer, Node.js 18+, Laragon atau XAMPP.

```bash
# Clone repository
git clone https://github.com/USERNAME/nutrival.git
cd nutrival

# Install dependency
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database (SQLite)
php artisan migrate:fresh --seed
php artisan storage:link

# Build asset frontend
npm run build

# Jalankan server
php artisan serve
```

Aplikasi bisa diakses di `http://127.0.0.1:8000`.

## Akun Demo

**Admin**

- Email: `admin@nutrival.test`
- Password: dicantumkan terpisah di dokumen PRD

**User**

Silakan register akun baru di halaman `/register`. Atau pakai akun demo:

- Email: `user@nutrival.test`
- Password: `password`

## Struktur Direktori

```
app/
  Http/Controllers/
    Admin/                    Controller area admin
    User/                     Controller area user
  Http/Middleware/
    IsAdmin.php               Middleware role admin
  Models/                     Eloquent model (User, Food, FoodLog, dll)

database/
  migrations/                 Skema tabel
  seeders/                    Data awal (60 makanan + akun demo)

resources/views/
  layouts/nutrival.blade.php  Layout utama dengan sidebar
  dashboard/                  Dashboard user dan admin
  diary/                      Food Diary
  mealplan/                   Meal Plan mingguan
  customfood/                 Makanan custom user
  stats/                      Halaman statistik
  admin/                      Semua view area admin

routes/
  web.php                     Route utama
  auth.php                    Route autentikasi (dari Breeze)
```

## Data Gizi

Nilai gizi mengacu pada sumber ilmiah publik:

- **TKPI (Tabel Komposisi Pangan Indonesia)** dari Kementerian Kesehatan RI, untuk makanan lokal.
- **USDA FoodData Central**, untuk makanan internasional dan bahan pangan umum.

Data disimpan sebagai porsi standar (misal per 100 gram atau per 1 potong). Nilai gizi log dihitung proporsional dari porsi yang tercatat, sehingga koreksi data master otomatis merambat ke semua log historis.

## Lisensi

Proyek akademik untuk keperluan pendidikan. Tidak untuk penggunaan komersial.
