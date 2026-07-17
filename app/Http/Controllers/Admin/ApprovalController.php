<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $foods = Food::with(['category', 'creator'])
            ->where('is_custom', true)
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.approvals.index', compact('foods', 'status'));
    }

    /** Approve: makanan masuk katalog publik. Admin boleh koreksi nutrisi dulu. */
    public function approve(Request $request, Food $food)
    {
        // Admin bisa sekaligus koreksi data (edit & approve)
        $data = $request->validate([
            'calories'   => 'nullable|numeric|min:0',
            'protein'    => 'nullable|numeric|min:0',
            'carbs'      => 'nullable|numeric|min:0',
            'fat'        => 'nullable|numeric|min:0',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $food->update(array_filter($data, fn ($v) => $v !== null) + ['status' => 'approved']);

        return back()->with('success', "'{$food->name}' disetujui & masuk katalog publik.");
    }

    public function reject(Request $request, Food $food)
    {
        $data = $request->validate(['admin_note' => 'required|string|max:500']);

        $food->update(['status' => 'rejected', 'admin_note' => $data['admin_note']]);

        return back()->with('success', "'{$food->name}' ditolak. Makanan tetap bisa dipakai pemiliknya secara pribadi.");
    }
}
