<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\MealPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    /** Tampilan 7 hari mulai dari tanggal start (default: hari ini) */
    public function index(Request $request)
    {
        $user = $request->user();
        $start = Carbon::parse($request->query('start', now()->toDateString()));
        $days = collect(range(0, 6))->map(fn ($i) => $start->copy()->addDays($i));

        $plans = MealPlan::with('food')
            ->where('user_id', $user->id)
            ->whereBetween('plan_date', [$start->toDateString(), $start->copy()->addDays(6)->toDateString()])
            ->orderBy('plan_date')
            ->get()
            ->groupBy(fn ($p) => $p->plan_date->toDateString());

        $foods = Food::visibleTo($user)->orderBy('name')->get(['id', 'name', 'serving_size', 'serving_unit']);

        return view('mealplan.index', compact('days', 'plans', 'foods', 'start'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'food_id'   => 'required|exists:foods,id',
            'plan_date' => 'required|date',
            'amount'    => 'required|numeric|min:0.1|max:10000',
            'note'      => 'nullable|string|max:255',
        ]);

        Food::visibleTo($request->user())->findOrFail($data['food_id']);
        $request->user()->mealPlans()->create($data);

        return back()->with('success', 'Rencana makan ditambahkan.');
    }

    /** Tandai selesai — otomatis catat ke food diary */
    public function toggle(Request $request, MealPlan $mealPlan)
    {
        abort_unless($mealPlan->user_id === $request->user()->id, 403);

        $mealPlan->update(['is_completed' => !$mealPlan->is_completed]);

        if ($mealPlan->is_completed) {
            $request->user()->foodLogs()->create([
                'food_id'  => $mealPlan->food_id,
                'log_date' => $mealPlan->plan_date->toDateString(),
                'log_time' => now()->format('H:i'),
                'amount'   => $mealPlan->amount,
                'note'     => 'Dari meal plan',
            ]);
        }

        return back()->with('success', $mealPlan->is_completed
            ? 'Selesai! Otomatis tercatat di diary.'
            : 'Status dibatalkan.');
    }

    public function destroy(Request $request, MealPlan $mealPlan)
    {
        abort_unless($mealPlan->user_id === $request->user()->id, 403);
        $mealPlan->delete();
        return back()->with('success', 'Rencana dihapus.');
    }
}
