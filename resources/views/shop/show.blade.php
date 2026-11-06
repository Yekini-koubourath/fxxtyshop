@extends('layouts.shop')

@section('title', $product->name)

@section('content')
    <nav class="mb-6 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-orange-600">Accueil</a> /
        <a href="{{ route('shop.index') }}" class="hover:text-orange-600">Boutique</a> /
        <span class="text-slate-800">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-8 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100 md:grid-cols-2 md:p-8">
        <div class="overflow-hidden rounded-2xl bg-slate-100">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full max-h-[480px] w-full object-cover">
        </div>

        <div class="flex flex-col">
            <p class="text-sm uppercase tracking-wide text-slate-400">
                {{ $product->category->name ?? '' }}@if ($product->brand) · {{ $product->brand }}@endif
            </p>
            <h1 class="mt-1 text-3xl font-extrabold">{{ $product->name }}</h1>
            <p class="mt-4 text-3xl font-extrabold text-orange-600">@fcfa($product->price)</p>

            <div class="mt-3">
                @if ($product->stock > 3)
                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">En stock</span>
                @elseif ($product->stock > 0)
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-700">Plus que {{ $product->stock }} en stock</span>
                @else
                    <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">Rupture de stock</span>
                @endif
            </div>

            @if ($product->description)
                <p class="mt-6 whitespace-pre-line leading-relaxed text-slate-600">{{ $product->description }}</p>
            @endif

            <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 flex flex-wrap items-center gap-3">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="{{ max($product->stock, 1) }}"
                       class="w-24 rounded-lg border border-slate-300 px-3 py-3 text-center focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                <button type="submit" @if ($product->stock < 1) disabled @endif
                        class="flex-1 rounded-xl bg-orange-500 px-6 py-3 font-semibold text-white shadow transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-40 sm:flex-none">
                    Ajouter au panier
                </button>
            </form>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="mt-12">
            <h2 class="mb-5 text-2xl font-bold">Produits similaires</h2>
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-6">
                @foreach ($related as $relatedProduct)
                    @include('shop._card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
    @endif
@endsection