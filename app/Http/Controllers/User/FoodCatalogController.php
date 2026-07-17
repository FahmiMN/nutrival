<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodCatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $foods = Food::with('category')
            ->visibleTo($request->user())
            ->when($q, fn ($query) => $query->where('name', 'like', "%$q%"))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('foods.index', [
            'foods'      => $foods,
            'categories' => Category::orderBy('name')->get(),
            'q'          => $q,
            'categoryId' => $categoryId,
        ]);
    }

    public function show(Request $request, Food $food)
    {
        // User hanya boleh lihat makanan approved atau miliknya sendiri
        if ($food->status !== 'approved' && $food->created_by !== $request->user()->id) {
            abort(404);
        }
        return view('foods.show', ['food' => $food->load('category')]);
    }
}
