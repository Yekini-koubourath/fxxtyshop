<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            'image_data'  => 'nullable|string',
        ];
    }

    // Enregistre l'image reçue sous forme de texte (data URL) dans public/uploads/products
    private function saveImageData(?string $dataUrl): ?string
    {
        if (! $dataUrl) {
            return null;
        }

        if (! preg_match('#^data:image/(jpeg|png|webp);base64,#', $dataUrl, $m)) {
            throw ValidationException::withMessages(['image_data' => 'Format d\'image invalide (JPG, PNG ou WebP).']);
        }

        $binary = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);

        if ($binary === false || strlen($binary) > 5 * 1024 * 1024 || @getimagesizefromstring($binary) === false) {
            throw ValidationException::withMessages(['image_data' => 'Image invalide ou trop lourde.']);
        }

        $dir = public_path('uploads/products');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $extension = $m[1] === 'jpeg' ? 'jpg' : $m[1];
        $name = uniqid('p_').'.'.$extension;
        file_put_contents($dir.'/'.$name, $binary);

        return 'uploads/products/'.$name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
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
        $data = $request->validate($this->rules());
        $data['is_active'] = $request->boolean('is_active');

        $path = $this->saveImageData($data['image_data'] ?? null);
        unset($data['image_data']);

        if ($path) {
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
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

        $path = $this->saveImageData($data['image_data'] ?? null);
        unset($data['image_data']);

        if ($path) {
            $this->deleteImage($product->image);
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImage($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
}