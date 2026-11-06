<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $latest = Product::with('category')->active()->latest()->take(8)->get();
        $categories = Category::withCount(['products' => fn ($q) => $q->where('is_active', true)])->get();

        return view('shop.home', compact('latest', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%'.$term.'%')
                  ->orWhere('brand', 'like', '%'.$term.'%');
            });
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load('category');
        $related = Product::with('category')->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}