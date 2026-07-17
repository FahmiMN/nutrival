<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $foods = Food::with('category')
            ->when($q, fn ($query) => $query->where('name', 'like', "%$q%"))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.foods.index', [
            'foods'      => $foods,
            'categories' => Category::orderBy('name')->get(),
            'q'          => $q,
            'categoryId' => $categoryId,
        ]);
    }

    public function create()
    {
        return view('admin.foods.form', [
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

        $data['status'] = 'approved';
        $data['is_custom'] = false;

        Food::create($data);
        return redirect()->route('admin.foods.index')->with('success', 'Makanan ditambahkan.');
    }

    public function edit(Food $food)
    {
        return view('admin.foods.form', [
            'food'       => $food,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Food $food)
    {
        $data = $this->validateFood($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('images/foods', 'public');
        }

        $food->update($data);
        return redirect()->route('admin.foods.index')->with('success', 'Makanan diperbarui.');
    }

    public function destroy(Food $food)
    {
        $food->delete();
        return back()->with('success', 'Makanan dihapus.');
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
