<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $data = Cart::lines();

        if ($data['lines']->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        return view('checkout.create', [
            'lines' => $data['lines'],
            'total' => $data['total'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:30',
            'address'       => 'required|string|max:255',
        ]);

        $cart = Cart::raw();

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $order = DB::transaction(function () use ($data, $cart) {
            $products = Product::whereIn('id', array_keys($cart))
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->lockForUpdate()
                ->get();

            $lines = [];
            $total = 0;

            foreach ($products as $product) {
                $qty = min((int) $cart[$product->id], (int) $product->stock);
                if ($qty < 1) {
                    continue;
                }
                $lines[] = [$product, $qty];
                $total += $product->price * $qty;
            }

            if (empty($lines)) {
                return null;
            }

            $order = Order::create([
                'user_id'       => auth()->id(),
                'customer_name' => $data['customer_name'],
                'phone'         => $data['phone'],
                'address'       => $data['address'],
                'total'         => $total,
                'status'        => 'en_attente',
            ]);

            foreach ($lines as [$product, $qty]) {
                $order->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $qty,
                    'price'        => $product->price,
                ]);
                $product->decrement('stock', $qty);
            }

            return $order;
        });

        if (! $order) {
            return redirect()->route('cart.index')->with('error', 'Les produits de votre panier ne sont plus disponibles.');
        }

        session()->forget('cart');
        session(['last_order_id' => $order->id]);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        if (session('last_order_id') !== $order->id) {
            return redirect()->route('home');
        }

        $order->load('items');

        return view('checkout.success', compact('order'));
    }
}