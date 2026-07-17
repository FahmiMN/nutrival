<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class CustomFoodController extends Controller
{
    public function index(Request $request)
    {
        $foods = Food::with('category')
            ->where('created_by', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customfood.index', compact('foods'));
    }

    public function create()
    {
        return view('customfood.form', [
            'food'       => null,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateFood($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('images/foods', 'public');
        }

        $data['is_custom'] = true;
        $data['status'] = 'pending'; // langsung bisa dipakai sendiri, menunggu approval utk publik
        $data['created_by'] = $request->user()->id;

        Food::create($data);

        return redirect()->route('customfood.index')
            ->with('success', 'Makanan berhasil ditambahkan! Bisa langsung kamu pakai. Menunggu review admin untuk masuk katalog publik.');
    }

    public function edit(Request $request, Food $food)
    {
        abort_unless($food->created_by === $request->user()->id, 403);
        return view('customfood.form', [
            'food'       => $food,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Food $food)
    {
        abort_unless($food->created_by === $request->user()->id, 403);

        $data = $this->validateFood($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('images/foods', 'public');
        }

        // Edit membuat status kembali pending (perlu review ulang)
        if ($food->status === 'approved') {
            $data['status'] = 'pending';
        }

        $food->update($data);

        return redirect()->route('customfood.index')->with('success', 'Makanan diperbarui.');
    }

    public function destroy(Request $request, Food $food)
    {
        abort_unless($food->created_by === $request->user()->id, 403);
        $food->delete();
        return redirect()->route('customfood.index')->with('success', 'Makanan dihapus.');
    }

    private function validateFood(Request $request): array
    {
        return $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string|max:1000',
            'image'         => 'nullable|image|max:2048',
            'serving_size'  => 'required|numeric|min:0.1',
            'serving_unit'  => 'required|string|max:30',
            'serving_text'  => 'nullable|string|max:100',
            'calories'      => 'required|numeric|min:0',
            'protein'       => 'required|numeric|min:0',
            'carbs'         => 'required|numeric|min:0',
            'fat'           => 'required|numeric|min:0',
            'fiber'         => 'nullable|numeric|min:0',
            'sugar'         => 'nullable|numeric|min:0',
            'sodium'        => 'nullable|numeric|min:0',
            'cholesterol'   => 'nullable|numeric|min:0',
            'saturated_fat' => 'nullable|numeric|min:0',
        ]);
    }
}
