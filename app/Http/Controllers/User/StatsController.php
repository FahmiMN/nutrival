<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FoodLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // ---- 7 hari terakhir ----
        $weekly = $this->dailyTotals($user->id, 7);
        // ---- 30 hari terakhir ----
        $monthly = $this->dailyTotals($user->id, 30);

        // ---- Macro hari ini ----
        $todayLogs = FoodLog::with('food')
            ->where('user_id', $user->id)
            ->whereDate('log_date', now()->toDateString())
            ->get();

        $todayMacros = [
            'protein' => round($todayLogs->sum(fn ($l) => $l->protein()), 1),
            'carbs'   => round($todayLogs->sum(fn ($l) => $l->carbs()), 1),
            'fat'     => round($todayLogs->sum(fn ($l) => $l->fat()), 1),
        ];

        // ---- Berat badan (12 entri terakhir) ----
        $weights = $user->weightLogs()->orderBy('log_date')->get()->take(-12)->values();

        return view('stats.index', [
            'user'        => $user,
            'weekly'      => $weekly,
            'monthly'     => $monthly,
            'todayMacros' => $todayMacros,
            'weights'     => $weights,
            'streak'      => $user->streak(),
            'bmr'         => $user->bmr(),
            'tdee'        => $user->tdee(),
            'recommended' => $user->recommendedCalories(),
        ]);
    }

    /** Total kalori per hari untuk N hari terakhir (termasuk hari kosong = 0) */
    private function dailyTotals(int $userId, int $days): array
    {
        $start = now()->subDays($days - 1)->toDateString();

        $logs = FoodLog::with('food')
            ->where('user_id', $userId)
            ->whereDate('log_date', '>=', $start)
            ->get()
            ->groupBy(fn ($l) => $l->log_date->toDateString());

        $labels = [];
        $values = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->translatedFormat($days > 7 ? 'd/m' : 'D');
            $values[] = isset($logs[$date])
                ? round($logs[$date]->sum(fn ($l) => $l->calories()))
                : 0;
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
