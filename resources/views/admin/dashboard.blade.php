@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ([['📦', 'Produits', $productsCount], ['🏷️', 'Catégories', $categoriesCount], ['🧾', 'Commandes', $ordersCount], ['⏳', 'En attente', $pendingCount]] as [$icon, $label, $value])
            <div class="rounded-2xl bg-white p-5 shadow-sm">
                <div class="text-2xl">{{ $icon }}</div>
                <p class="mt-2 text-sm text-slate-500">{{ $label }}</p>
                <p class="text-3xl font-extrabold">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-4 rounded-2xl bg-gradient-to-r from-slate-900 to-orange-600 p-6 text-white shadow-sm">
        <p class="text-sm text-orange-100">Chiffre d'affaires (hors commandes annulées)</p>
        <p class="mt-1 text-3xl font-extrabold">@fcfa($revenue)</p>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="font-bold">Dernières commandes</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-600 hover:underline">Tout voir</a>
            </div>
            @forelse ($latestOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between gap-3 border-t py-3 text-sm hover:bg-slate-50">
                    <span class="min-w-0 truncate">#{{ $order->id }} · {{ $order->customer_name }}</span>
                    <span class="flex shrink-0 items-center gap-2">
                        <span class="font-semibold">@fcfa($order->total)</span>
                        @include('partials.status-badge', ['status' => $order->status])
                    </span>
                </a>
            @empty
                <p class="py-6 text-center text-sm text-slate-400">Aucune commande pour l'instant.</p>
            @endforelse
        </section>

        <section class="rounded-2xl bg-white p-5 shadow-sm">
            <h2 class="mb-3 font-bold">Stock faible</h2>
            @forelse ($lowStock as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="flex items-center justify-between border-t py-3 text-sm hover:bg-slate-50">
                    <span class="truncate">{{ $product->name }}</span>
                    <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">{{ $product->stock }} restant(s)</span>
                </a>
            @empty
                <p class="py-6 text-center text-sm text-slate-400">Tous les stocks sont suffisants.</p>
            @endforelse
        </section>
    </div>
@endsection