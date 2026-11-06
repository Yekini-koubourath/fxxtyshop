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
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name']);

        Category::create([
            'name' => $request->name,
            'slug' => $this->uniqueSlug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$category->id]);

        $category->update([
            'name' => $request->name,
            'slug' => $this->uniqueSlug($request->name, $category->id),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'categorie';
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}