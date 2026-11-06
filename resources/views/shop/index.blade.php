@extends('layouts.shop')

@section('title', 'Boutique')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Boutique</h1>

    <form method="GET" action="{{ route('shop.index') }}" class="mb-8 grid gap-3 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100 sm:grid-cols-2 lg:grid-cols-5">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher…"
               class="rounded-lg border border-slate-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200 lg:col-span-2">

        <select name="category" class="rounded-lg border border-slate-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="sort" class="rounded-lg border border-slate-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <option value="">Plus récents</option>
            <option value="price_asc" @selected(request('sort') === 'price_asc')>Prix croissant</option>
            <option value="price_desc" @selected(request('sort') === 'price_desc')>Prix décroissant</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-orange-500 px-4 py-2 font-semibold text-white hover:bg-orange-600">Filtrer</button>
            <a href="{{ route('shop.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-slate-600 hover:bg-slate-50">Reset</a>
        </div>
    </form>

    @if ($products->isEmpty())
        <div class="rounded-2xl bg-white p-12 text-center shadow-sm">
            <p class="text-4xl">🔍</p>
            <p class="mt-3 text-slate-500">Aucun produit ne correspond à votre recherche.</p>
        </div>
    @else
        <p class="mb-4 text-sm text-slate-500">{{ $products->total() }} produit(s) trouvé(s)</p>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">
            @foreach ($products as $product)
                @include('shop._card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
@endsection