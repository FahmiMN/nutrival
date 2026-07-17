<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodLog;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    /** Halaman diary per tanggal (default: hari ini) */
    public function index(Request $request)
    {
        $user = $request->user();
        $date = $request->query('date', now()->toDateString());

        $logs = FoodLog::with('food.category')
            ->where('user_id', $user->id)
            ->whereDate('log_date', $date)
            ->orderBy('log_time')
            ->get();

        $totals = [
            'calories' => $logs->sum(fn ($l) => $l->calories()),
            'protein'  => $logs->sum(fn ($l) => $l->protein()),
            'carbs'    => $logs->sum(fn ($l) => $l->carbs()),
            'fat'      => $logs->sum(fn ($l) => $l->fat()),
        ];

        return view('diary.index', compact('logs', 'totals', 'date', 'user'));
    }

    /** Form tambah log: pilih makanan (dengan search) */
    public function create(Request $request)
    {
        $q = $request->query('q');
        $date = $request->query('date', now()->toDateString());

        $foods = Food::with('category')
            ->visibleTo($request->user())
            ->when($q, fn ($query) => $query->where('name', 'like', "%$q%"))
            ->orderBy('name')
            ->limit(30)
            ->get();

        return view('diary.create', compact('foods', 'q', 'date'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'food_id'  => 'required|exists:foods,id',
            'log_date' => 'required|date',
            'log_time' => 'required',
            'amount'   => 'required|numeric|min:0.1|max:10000',
            'note'     => 'nullable|string|max:255',
        ]);

        // Pastikan makanan boleh dipakai user ini
        $food = Food::visibleTo($request->user())->findOrFail($data['food_id']);

        $request->user()->foodLogs()->create($data);

        return redirect()->route('diary.index', ['date' => $data['log_date']])
            ->with('success', "{$food->name} berhasil dicatat!");
    }

    public function edit(Request $request, FoodLog $foodLog)
    {
        abort_unless($foodLog->user_id === $request->user()->id, 403);
        return view('diary.edit', ['log' => $foodLog->load('food')]);
    }

    public function update(Request $request, FoodLog $foodLog)
    {
        abort_unless($foodLog->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'log_date' => 'required|date',
            'log_time' => 'required',
            'amount'   => 'required|numeric|min:0.1|max:10000',
            'note'     => 'nullable|string|max:255',
        ]);

        $foodLog->update($data);

        return redirect()->route('diary.index', ['date' => $data['log_date']])
            ->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy(Request $request, FoodLog $foodLog)
    {
        abort_unless($foodLog->user_id === $request->user()->id, 403);
        $date = $foodLog->log_date->toDateString();
        $foodLog->delete();

        return redirect()->route('diary.index', ['date' => $date])
            ->with('success', 'Catatan dihapus.');
    }
}
