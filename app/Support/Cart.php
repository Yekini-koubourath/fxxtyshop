<?php

namespace App\Support;

use App\Models\Product;

class Cart
{
    public static function raw(): array
    {
        return session('cart', []);
    }

    public static function count(): int
    {
        return (int) array_sum(self::raw());
    }

    /**
     * Retourne les lignes du panier et le total.
     */
    public static function lines(): array
    {
        $cart = self::raw();

        if (empty($cart)) {
            return ['lines' => collect(), 'total' => 0];
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->get();

        $lines = $products->map(function ($product) use ($cart) {
            $qty = max(1, min((int) $cart[$product->id], (int) $product->stock));

            return (object) [
                'product'  => $product,
                'qty'      => $qty,
                'subtotal' => $product->price * $qty,
            ];
        })->values();

        return ['lines' => $lines, 'total' => $lines->sum('subtotal')];
    }
}