<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use App\Models\FoodLog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'      => User::where('role', 'user')->count(),
            'totalFoods'      => Food::where('status', 'approved')->count(),
            'totalCategories' => Category::count(),
            'pendingCount'    => Food::where('status', 'pending')->count(),
            'totalLogs'       => FoodLog::count(),
            'recentUsers'     => User::where('role', 'user')->latest()->take(5)->get(),
            'pendingFoods'    => Food::with('creator')->where('status', 'pending')->latest()->take(5)->get(),
        ]);
    }
}
