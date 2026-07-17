<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// Redirect setelah login: admin → panel admin, user → dashboard user
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

/* ==================== AREA USER ==================== */
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [User\DashboardController::class, 'index'])->name('user.dashboard');

    // Katalog makanan (read-only untuk user)
    Route::get('/foods', [User\FoodCatalogController::class, 'index'])->name('foods.index');
    Route::get('/foods/{food}', [User\FoodCatalogController::class, 'show'])->name('foods.show');

    // Food Diary (CRUD log makan harian)
    Route::get('/diary', [User\DiaryController::class, 'index'])->name('diary.index');
    Route::get('/diary/add', [User\DiaryController::class, 'create'])->name('diary.create');
    Route::post('/diary', [User\DiaryController::class, 'store'])->name('diary.store');
    Route::get('/diary/{foodLog}/edit', [User\DiaryController::class, 'edit'])->name('diary.edit');
    Route::put('/diary/{foodLog}', [User\DiaryController::class, 'update'])->name('diary.update');
    Route::delete('/diary/{foodLog}', [User\DiaryController::class, 'destroy'])->name('diary.destroy');

    // Custom Food (CRUD + submit approval)
    Route::get('/custom-foods', [User\CustomFoodController::class, 'index'])->name('customfood.index');
    Route::get('/custom-foods/create', [User\CustomFoodController::class, 'create'])->name('customfood.create');
    Route::post('/custom-foods', [User\CustomFoodController::class, 'store'])->name('customfood.store');
    Route::get('/custom-foods/{food}/edit', [User\CustomFoodController::class, 'edit'])->name('customfood.edit');
    Route::put('/custom-foods/{food}', [User\CustomFoodController::class, 'update'])->name('customfood.update');
    Route::delete('/custom-foods/{food}', [User\CustomFoodController::class, 'destroy'])->name('customfood.destroy');

    // Meal Plan mingguan
    Route::get('/meal-plan', [User\MealPlanController::class, 'index'])->name('mealplan.index');
    Route::post('/meal-plan', [User\MealPlanController::class, 'store'])->name('mealplan.store');
    Route::patch('/meal-plan/{mealPlan}/toggle', [User\MealPlanController::class, 'toggle'])->name('mealplan.toggle');
    Route::delete('/meal-plan/{mealPlan}', [User\MealPlanController::class, 'destroy'])->name('mealplan.destroy');

    // Statistik
    Route::get('/stats', [User\StatsController::class, 'index'])->name('stats.index');

    // Berat badan
    Route::get('/weight', [User\WeightController::class, 'index'])->name('weight.index');
    Route::post('/weight', [User\WeightController::class, 'store'])->name('weight.store');
    Route::delete('/weight/{weightLog}', [User\WeightController::class, 'destroy'])->name('weight.destroy');

    // Target & data tubuh (BMR/TDEE)
    Route::get('/target', [User\TargetController::class, 'edit'])->name('target.edit');
    Route::put('/target', [User\TargetController::class, 'update'])->name('target.update');

    // Profil bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ==================== AREA ADMIN ==================== */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', Admin\CategoryController::class)->except(['show']);
    Route::resource('foods', Admin\FoodController::class)->except(['show']);

    // Manajemen user
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle', [Admin\UserController::class, 'toggle'])->name('users.toggle');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Approval custom food
    Route::get('/approvals', [Admin\ApprovalController::class, 'index'])->name('approvals.index');
    Route::patch('/approvals/{food}/approve', [Admin\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::patch('/approvals/{food}/reject', [Admin\ApprovalController::class, 'reject'])->name('approvals.reject');
});

require __DIR__.'/auth.php';