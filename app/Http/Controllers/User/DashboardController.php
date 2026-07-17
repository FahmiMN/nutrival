<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FoodLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $logs = FoodLog::with('food')
            ->where('user_id', $user->id)
            ->whereDate('log_date', $today)
            ->orderBy('log_time')
            ->get();

        $totals = [
            'calories' => $logs->sum(fn ($l) => $l->calories()),
            'protein'  => $logs->sum(fn ($l) => $l->protein()),
            'carbs'    => $logs->sum(fn ($l) => $l->carbs()),
            'fat'      => $logs->sum(fn ($l) => $l->fat()),
        ];

        return view('dashboard.user', [
            'user'    => $user,
            'logs'    => $logs,
            'totals'  => $totals,
            'streak'  => $user->streak(),
        ]);
    }
}
