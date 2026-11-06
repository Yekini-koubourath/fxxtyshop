@extends('layouts.shop')

@section('title', 'Mon panier')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Mon panier</h1>

    @if ($lines->isEmpty())
        <div class="rounded-3xl bg-white p-12 text-center shadow-sm ring-1 ring-slate-100">
            <p class="text-5xl">🛒</p>
            <p class="mt-4 text-lg text-slate-600">Votre panier est vide.</p>
            <a href="{{ route('shop.index') }}" class="mt-6 inline-block rounded-xl bg-orange-500 px-6 py-3 font-semibold text-white hover:bg-orange-600">Découvrir la boutique</a>
        </div>
    @else
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-2">
                @foreach ($lines as $line)
                    <div class="flex flex-col gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100 sm:flex-row sm:items-center">
                        <img src="{{ $line->product->image_url }}" alt="{{ $line->product->name }}" class="h-24 w-24 shrink-0 rounded-xl bg-slate-100 object-cover">

                        <div class="min-w-0 flex-1">
                            <a href="{{ route('shop.show', $line->product) }}" class="font-semibold hover:text-orange-600">{{ $line->product->name }}</a>
                            <p class="text-sm text-slate-500">@fcfa($line->product->price) / unité</p>
                            <p class="mt-1 font-bold text-orange-600">@fcfa($line->subtotal)</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('cart.update', $line->product) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $line->qty }}" min="1" max="{{ $line->product->stock }}"
                                       class="w-20 rounded-lg border border-slate-300 px-2 py-2 text-center focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                <button type="submit" class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium hover:bg-slate-200">OK</button>
                            </form>

                            <form method="POST" action="{{ route('cart.remove', $line->product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">Retirer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="h-fit rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 lg:sticky lg:top-28">
                <h2 class="text-lg font-bold">Récapitulatif</h2>
                <div class="mt-4 flex justify-between text-sm text-slate-600">
                    <span>Articles</span><span>{{ $lines->sum('qty') }}</span>
                </div>
                <div class="mt-2 flex justify-between border-t pt-4 text-lg font-extrabold">
                    <span>Total</span><span class="text-orange-600">@fcfa($total)</span>
                </div>
                <a href="{{ route('checkout.create') }}" class="mt-6 block rounded-xl bg-orange-500 py-3 text-center font-semibold text-white transition hover:bg-orange-600">Passer la commande</a>
                <a href="{{ route('shop.index') }}" class="mt-3 block text-center text-sm text-slate-500 hover:text-orange-600">← Continuer mes achats</a>
            </aside>
        </div>
    @endif
@endsection