<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@nutrival.test'],
            [
                'name'     => 'Admin Nutrival',
                'password' => Hash::make('ValranBro123'),
                'role'     => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@nutrival.test'],
            [
                'name'           => 'User Demo',
                'password'       => Hash::make('password'),
                'role'           => 'user',
                'birth_date'     => '2003-05-10',
                'gender'         => 'male',
                'height_cm'      => 170,
                'weight_kg'      => 65,
                'activity_level' => 'light',
                'goal'           => 'maintain',
                'calorie_target' => 2200,
                'protein_target' => 138,
                'carb_target'    => 275,
                'fat_target'     => 61,
            ]
        );
    }
}
