<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('foods')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'icon' => 'nullable|string|max:10',
        ]);
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->foods()->exists()) {
            return back()->with('error', 'Tidak bisa menghapus: masih ada makanan dalam kategori ini.');
        }
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
