<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * 60 makanan: 36 Indonesia + 24 internasional.
 * Nilai gizi mengacu pada TKPI (Kemenkes RI) & USDA FoodData Central (nilai tipikal).
 * Format: [nama, kategori, size, unit, teks porsi, kal, protein, karbo, lemak, serat, gula, natrium]
 */
class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::pluck('id', 'slug');

        $foods = [
            // ===== NASI & KARBOHIDRAT (Indonesia) =====
            ['Nasi Putih', 'nasi-karbohidrat', 100, 'gram', '1 centong', 130, 2.7, 28.2, 0.3, 0.4, 0.1, 1],
            ['Nasi Goreng', 'nasi-karbohidrat', 200, 'gram', '1 piring', 500, 12, 62, 22, 2, 3, 900],
            ['Nasi Uduk', 'nasi-karbohidrat', 200, 'gram', '1 porsi', 360, 6, 52, 14, 1.5, 1, 400],
            ['Nasi Kuning', 'nasi-karbohidrat', 200, 'gram', '1 porsi', 340, 6, 55, 10, 1.5, 1, 380],
            ['Lontong', 'nasi-karbohidrat', 100, 'gram', '2 buah', 144, 3, 31, 0.3, 0.5, 0, 5],
            ['Mie Goreng', 'nasi-karbohidrat', 200, 'gram', '1 piring', 460, 10, 58, 20, 2.5, 4, 1050],
            ['Bihun Goreng', 'nasi-karbohidrat', 200, 'gram', '1 piring', 380, 7, 60, 12, 1.8, 3, 850],
            ['Kentang Rebus', 'nasi-karbohidrat', 100, 'gram', '1 buah sedang', 87, 1.9, 20.1, 0.1, 1.8, 0.9, 4],
            ['Singkong Rebus', 'nasi-karbohidrat', 100, 'gram', '1 potong', 154, 1, 36.8, 0.3, 1.8, 1.7, 14],
            ['Jagung Rebus', 'nasi-karbohidrat', 100, 'gram', '1 tongkol kecil', 96, 3.4, 20.6, 1.5, 2.4, 4.5, 15],

            // ===== LAUK PAUK (Indonesia) =====
            ['Ayam Goreng', 'lauk-pauk', 100, 'gram', '1 potong paha', 260, 24, 5, 16, 0.3, 0, 420],
            ['Ayam Bakar', 'lauk-pauk', 100, 'gram', '1 potong', 220, 25, 4, 11, 0.2, 2, 380],
            ['Rendang Sapi', 'lauk-pauk', 100, 'gram', '1 potong', 285, 22, 8, 18, 1.2, 2, 450],
            ['Telur Rebus', 'lauk-pauk', 50, 'gram', '1 butir', 78, 6.3, 0.6, 5.3, 0, 0.6, 62],
            ['Telur Dadar', 'lauk-pauk', 60, 'gram', '1 butir', 120, 7, 1, 9.5, 0, 0.5, 210],
            ['Ikan Goreng', 'lauk-pauk', 100, 'gram', '1 ekor sedang', 210, 22, 3, 12, 0.2, 0, 350],
            ['Ikan Bakar', 'lauk-pauk', 100, 'gram', '1 ekor sedang', 165, 24, 2, 6.5, 0.2, 1, 320],
            ['Tempe Goreng', 'lauk-pauk', 50, 'gram', '2 potong', 175, 9, 8, 12, 2.5, 0.5, 95],
            ['Tahu Goreng', 'lauk-pauk', 50, 'gram', '2 potong', 135, 7, 4, 10, 1, 0.3, 90],
            ['Sate Ayam', 'lauk-pauk', 100, 'gram', '5 tusuk + bumbu', 300, 22, 12, 18, 1.5, 6, 550],
            ['Bakso Sapi', 'lauk-pauk', 100, 'gram', '5 butir', 202, 11, 10, 13, 0.5, 1, 620],
            ['Udang Goreng', 'lauk-pauk', 100, 'gram', '6 ekor', 240, 21, 8, 14, 0.3, 0.5, 480],

            // ===== SAYURAN (Indonesia) =====
            ['Sayur Asem', 'sayuran', 200, 'gram', '1 mangkuk', 80, 2.5, 14, 2, 3.5, 5, 480],
            ['Sayur Lodeh', 'sayuran', 200, 'gram', '1 mangkuk', 160, 4, 12, 11, 3.8, 4, 520],
            ['Capcay', 'sayuran', 200, 'gram', '1 porsi', 120, 6, 12, 5.5, 3.6, 5, 600],
            ['Gado-Gado', 'sayuran', 250, 'gram', '1 porsi', 380, 14, 30, 23, 6.5, 8, 700],
            ['Tumis Kangkung', 'sayuran', 150, 'gram', '1 porsi', 98, 3.5, 7, 6.5, 2.8, 2, 450],
            ['Pecel Sayur', 'sayuran', 200, 'gram', '1 porsi', 270, 10, 22, 16, 5.5, 7, 480],
            ['Urap Sayur', 'sayuran', 150, 'gram', '1 porsi', 160, 5, 12, 10, 4.2, 3, 300],

            // ===== SARAPAN & SUP (Indonesia) =====
            ['Bubur Ayam', 'sarapan', 350, 'gram', '1 mangkuk', 372, 15, 46, 14, 1.5, 2, 950],
            ['Soto Ayam', 'sarapan', 300, 'gram', '1 mangkuk (tanpa nasi)', 210, 18, 12, 10, 1.8, 2, 850],
            ['Lontong Sayur', 'sarapan', 350, 'gram', '1 porsi', 400, 10, 48, 19, 3.5, 4, 780],
            ['Nasi Pecel', 'sarapan', 300, 'gram', '1 porsi', 480, 15, 62, 19, 6, 8, 620],

            // ===== CAMILAN (Indonesia) =====
            ['Pisang Goreng', 'camilan', 60, 'gram', '1 buah', 140, 1.2, 22, 5.5, 1.3, 9, 45],
            ['Risoles', 'camilan', 50, 'gram', '1 buah', 134, 3.5, 14, 7, 0.6, 1.5, 180],
            ['Martabak Manis', 'camilan', 100, 'gram', '1 potong', 350, 7, 46, 15, 0.8, 24, 220],
            ['Kerupuk', 'camilan', 20, 'gram', '3 keping', 106, 0.6, 12, 6.2, 0.2, 0, 140],

            // ===== INTERNASIONAL =====
            ['Roti Tawar Putih', 'sarapan', 25, 'gram', '1 lembar', 66, 2.3, 12.3, 0.8, 0.6, 1.4, 120],
            ['Roti Gandum', 'sarapan', 25, 'gram', '1 lembar', 61, 3, 10.5, 1, 1.7, 1.1, 110],
            ['Oatmeal', 'sarapan', 40, 'gram', '4 sdm (kering)', 152, 5.3, 27, 2.6, 4, 0.4, 1],
            ['Pancake', 'sarapan', 80, 'gram', '2 lembar', 180, 4.5, 28, 5.5, 0.9, 8, 320],
            ['Sereal Cornflakes', 'sarapan', 30, 'gram', '1 mangkuk kecil', 113, 2, 25, 0.3, 0.9, 2.7, 200],
            ['Spaghetti Bolognese', 'nasi-karbohidrat', 300, 'gram', '1 porsi', 470, 20, 58, 17, 4, 8, 720],
            ['Pizza Keju', 'makanan-cepat-saji', 100, 'gram', '1 slice', 266, 11, 33, 10, 2.3, 3.6, 598],
            ['Burger Sapi', 'makanan-cepat-saji', 150, 'gram', '1 buah', 420, 20, 35, 22, 1.5, 7, 780],
            ['Kentang Goreng', 'makanan-cepat-saji', 100, 'gram', '1 porsi sedang', 312, 3.4, 41, 15, 3.8, 0.3, 210],
            ['Ayam Crispy (Fast Food)', 'makanan-cepat-saji', 100, 'gram', '1 potong', 290, 19, 14, 18, 0.8, 0, 640],
            ['Hot Dog', 'makanan-cepat-saji', 100, 'gram', '1 buah', 290, 10, 24, 17, 1, 4, 810],
            ['Salad Sayur + Dressing', 'sayuran', 150, 'gram', '1 mangkuk', 120, 2.5, 8, 9, 2.8, 4, 280],
            ['Sushi Roll', 'nasi-karbohidrat', 150, 'gram', '6 potong', 220, 8, 40, 3, 1.5, 6, 480],
            ['Steak Sapi', 'lauk-pauk', 150, 'gram', '1 potong sedang', 405, 37, 0, 28, 0, 0, 90],
            ['Dada Ayam Panggang', 'lauk-pauk', 100, 'gram', '1 potong', 165, 31, 0, 3.6, 0, 0, 74],
            ['Salmon Panggang', 'lauk-pauk', 100, 'gram', '1 fillet', 206, 22, 0, 12, 0, 0, 61],

            // ===== BUAH =====
            ['Pisang', 'buah', 100, 'gram', '1 buah sedang', 89, 1.1, 22.8, 0.3, 2.6, 12.2, 1],
            ['Apel', 'buah', 100, 'gram', '1 buah kecil', 52, 0.3, 13.8, 0.2, 2.4, 10.4, 1],
            ['Pepaya', 'buah', 100, 'gram', '1 potong', 43, 0.5, 10.8, 0.3, 1.7, 7.8, 8],
            ['Semangka', 'buah', 100, 'gram', '1 potong', 30, 0.6, 7.6, 0.2, 0.4, 6.2, 1],
            ['Alpukat', 'buah', 100, 'gram', '1/2 buah', 160, 2, 8.5, 14.7, 6.7, 0.7, 7],
            ['Jeruk', 'buah', 100, 'gram', '1 buah', 47, 0.9, 11.8, 0.1, 2.4, 9.4, 0],

            // ===== MINUMAN =====
            ['Teh Manis', 'minuman', 250, 'ml', '1 gelas', 90, 0, 23, 0, 0, 23, 5],
            ['Es Teh Tawar', 'minuman', 250, 'ml', '1 gelas', 2, 0, 0.5, 0, 0, 0, 3],
            ['Kopi Hitam Tanpa Gula', 'minuman', 200, 'ml', '1 cangkir', 4, 0.3, 0, 0, 0, 0, 5],
            ['Kopi Susu Gula Aren', 'minuman', 250, 'ml', '1 gelas', 180, 3, 28, 6, 0, 24, 60],
            ['Jus Jeruk', 'minuman', 250, 'ml', '1 gelas', 112, 1.7, 26, 0.5, 0.5, 21, 2],
            ['Susu Full Cream', 'minuman', 250, 'ml', '1 gelas', 150, 8, 12, 8, 0, 12, 105],
            ['Es Boba (Milk Tea)', 'minuman', 350, 'ml', '1 gelas', 340, 4, 62, 9, 0.5, 45, 120],
            ['Air Kelapa', 'minuman', 250, 'ml', '1 gelas', 48, 1.8, 9.3, 0.5, 2.8, 6.5, 263],
        ];

        foreach ($foods as $f) {
            Food::firstOrCreate(
                ['name' => $f[0]],
                [
                    'category_id'  => $cat[$f[1]],
                    'image_path'   => 'images/foods/' . Str::slug($f[0]) . '.jpg',
                    'serving_size' => $f[2],
                    'serving_unit' => $f[3],
                    'serving_text' => $f[4],
                    'calories'     => $f[5],
                    'protein'      => $f[6],
                    'carbs'        => $f[7],
                    'fat'          => $f[8],
                    'fiber'        => $f[9],
                    'sugar'        => $f[10],
                    'sodium'       => $f[11],
                    'is_custom'    => false,
                    'status'       => 'approved',
                ]
            );
        }
    }
}
