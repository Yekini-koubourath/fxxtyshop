<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productsCount'   => Product::count(),
            'categoriesCount' => Category::count(),
            'ordersCount'     => Order::count(),
            'pendingCount'    => Order::where('status', 'en_attente')->count(),
            'revenue'         => Order::where('status', '!=', 'annulee')->sum('total'),
            'latestOrders'    => Order::latest()->take(6)->get(),
            'lowStock'        => Product::where('stock', '<=', 3)->orderBy('stock')->take(6)->get(),
        ]);
    }
}