<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $data = Cart::lines();

        return view('cart.index', [
            'lines' => $data['lines'],
            'total' => $data['total'],
        ]);
    }

    public function add(Request $request, Product $product)
    {
        if (! $product->is_active || $product->stock < 1) {
            return back()->with('error', 'Ce produit est indisponible.');
        }

        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + $qty, $product->stock);
        session(['cart' => $cart]);

        return back()->with('success', '« '.$product->name.' » a été ajouté au panier.');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = max(1, min((int) $request->input('quantity', 1), max($product->stock, 1)));
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}