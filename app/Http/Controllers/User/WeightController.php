<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function index(Request $request)
    {
        $logs = $request->user()->weightLogs()->orderByDesc('log_date')->paginate(10);
        return view('weight.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'log_date'  => 'required|date',
            'weight_kg' => 'required|numeric|min:20|max:400',
            'note'      => 'nullable|string|max:255',
        ]);

        // Satu entri per tanggal — update jika sudah ada
        $request->user()->weightLogs()->updateOrCreate(
            ['log_date' => $data['log_date']],
            ['weight_kg' => $data['weight_kg'], 'note' => $data['note'] ?? null]
        );

        // Sinkronkan berat terkini di profil
        $request->user()->update(['weight_kg' => $data['weight_kg']]);

        return back()->with('success', 'Berat badan dicatat.');
    }

    public function destroy(Request $request, WeightLog $weightLog)
    {
        abort_unless($weightLog->user_id === $request->user()->id, 403);
        $weightLog->delete();
        return back()->with('success', 'Catatan dihapus.');
    }
}
