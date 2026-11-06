<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
          'image'       => 'nullable|image|max:5120',
        ];
    }

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product'    => new Product(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

public function store(Request $request)
{
    dd([
        'methode' => $request->method(),
        'image_recue' => $request->hasFile('image'),
        'fichier_existe' => $request->file('image') !== null,
        'image_valide' => $request->file('image')?->isValid(),
        'erreur_upload' => $request->file('image')?->getError(),
        'message_erreur' => $request->file('image')?->getErrorMessage(),
        'nom_image' => $request->file('image')?->getClientOriginalName(),
    ]);
}

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules());
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
}