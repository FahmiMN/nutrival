<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Nasi & Karbohidrat', 'icon' => '🍚'],
            ['name' => 'Lauk Pauk',          'icon' => '🍗'],
            ['name' => 'Sayuran',            'icon' => '🥦'],
            ['name' => 'Buah',               'icon' => '🍎'],
            ['name' => 'Camilan',            'icon' => '🍪'],
            ['name' => 'Minuman',            'icon' => '🥤'],
            ['name' => 'Sarapan',            'icon' => '🍳'],
            ['name' => 'Makanan Cepat Saji', 'icon' => '🍔'],
        ];

        foreach ($categories as $c) {
            Category::firstOrCreate(
                ['slug' => Str::slug($c['name'])],
                ['name' => $c['name'], 'icon' => $c['icon']]
            );
        }
    }
}
