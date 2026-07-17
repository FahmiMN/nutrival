<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function edit(Request $request)
    {
        return view('target.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'birth_date'     => 'nullable|date|before:today',
            'gender'         => 'nullable|in:male,female',
            'height_cm'      => 'nullable|numeric|min:80|max:250',
            'weight_kg'      => 'nullable|numeric|min:20|max:400',
            'activity_level' => 'nullable|in:sedentary,light,moderate,active,very_active',
            'goal'           => 'nullable|in:lose,maintain,gain',
            'calorie_target' => 'nullable|integer|min:800|max:8000',
            'protein_target' => 'nullable|integer|min:0|max:500',
            'carb_target'    => 'nullable|integer|min:0|max:1000',
            'fat_target'     => 'nullable|integer|min:0|max:300',
        ]);

        $user = $request->user();
        $user->update($data);

        // Jika user klik "Gunakan Rekomendasi", isi target otomatis dari TDEE
        if ($request->boolean('use_recommendation') && $user->fresh()->recommendedCalories()) {
            $cal = $user->fresh()->recommendedCalories();
            $user->update([
                'calorie_target' => $cal,
                'protein_target' => round($cal * 0.25 / 4), // 25% kalori dari protein
                'carb_target'    => round($cal * 0.50 / 4), // 50% dari karbo
                'fat_target'     => round($cal * 0.25 / 9), // 25% dari lemak
            ]);
        }

        return back()->with('success', 'Data & target berhasil disimpan.');
    }
}
