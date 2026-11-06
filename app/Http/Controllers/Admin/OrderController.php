<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::withCount('items')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée.');
    }
}