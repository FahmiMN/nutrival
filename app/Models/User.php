<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active',
        'birth_date', 'gender', 'height_cm', 'weight_kg',
        'activity_level', 'goal',
        'calorie_target', 'protein_target', 'carb_target', 'fat_target',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // ================= Relasi =================
    public function foodLogs()
    {
        return $this->hasMany(FoodLog::class);
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }

    public function weightLogs()
    {
        return $this->hasMany(WeightLog::class);
    }

    public function customFoods()
    {
        return $this->hasMany(Food::class, 'created_by');
    }

    // ================= Helper =================
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function age(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * BMR — rumus Mifflin-St Jeor.
     * Pria:   (10 × BB) + (6.25 × TB) − (5 × umur) + 5
     * Wanita: (10 × BB) + (6.25 × TB) − (5 × umur) − 161
     */
    public function bmr(): ?float
    {
        if (!$this->weight_kg || !$this->height_cm || !$this->age() || !$this->gender) {
            return null;
        }
        $base = (10 * $this->weight_kg) + (6.25 * $this->height_cm) - (5 * $this->age());
        return round($this->gender === 'male' ? $base + 5 : $base - 161);
    }

    /**
     * TDEE = BMR × faktor aktivitas.
     */
    public function tdee(): ?float
    {
        $bmr = $this->bmr();
        if (!$bmr || !$this->activity_level) return null;

        $factors = [
            'sedentary'   => 1.2,
            'light'       => 1.375,
            'moderate'    => 1.55,
            'active'      => 1.725,
            'very_active' => 1.9,
        ];
        return round($bmr * $factors[$this->activity_level]);
    }

    /**
     * Rekomendasi kalori harian berdasarkan goal.
     * lose = defisit 500, gain = surplus 300, maintain = TDEE.
     */
    public function recommendedCalories(): ?int
    {
        $tdee = $this->tdee();
        if (!$tdee) return null;

        return (int) match ($this->goal) {
            'lose'  => max(1200, $tdee - 500),
            'gain'  => $tdee + 300,
            default => $tdee,
        };
    }

    /**
     * Streak: jumlah hari berturut-turut (sampai hari ini/kemarin) user mencatat makanan.
     */
    public function streak(): int
    {
        $dates = $this->foodLogs()
            ->selectRaw('DISTINCT log_date')
            ->orderByDesc('log_date')
            ->pluck('log_date')
            ->map(fn ($d) => \Carbon\Carbon::parse($d)->toDateString())
            ->toArray();

        if (empty($dates)) return 0;

        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // Streak valid jika log terakhir hari ini atau kemarin
        if ($dates[0] !== $today && $dates[0] !== $yesterday) return 0;

        $streak = 1;
        for ($i = 0; $i < count($dates) - 1; $i++) {
            $expected = \Carbon\Carbon::parse($dates[$i])->subDay()->toDateString();
            if ($dates[$i + 1] === $expected) {
                $streak++;
            } else {
                break;
            }
        }
        return $streak;
    }
}
