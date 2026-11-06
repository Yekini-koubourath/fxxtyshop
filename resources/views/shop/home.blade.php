@extends('layouts.shop')

@section('title', 'Accueil')

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-orange-600 px-6 py-12 text-white shadow-xl sm:px-12 sm:py-16">
        <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-orange-500/30 blur-3xl"></div>
        <div class="relative max-w-2xl">
            <span class="inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-orange-300">Nouveautés disponibles</span>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight sm:text-5xl">Les meilleurs téléphones et ordinateurs, au meilleur prix.</h1>
            <p class="mt-4 text-slate-300 sm:text-lg">Découvrez notre sélection de produits neufs et garantis, livrés rapidement chez vous.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('shop.index') }}" class="rounded-xl bg-orange-500 px-6 py-3 font-semibold shadow-lg transition hover:bg-orange-600">Voir la boutique</a>
                <a href="{{ route('shop.index', ['sort' => 'price_asc']) }}" class="rounded-xl bg-white/10 px-6 py-3 font-semibold transition hover:bg-white/20">Petits prix</a>
            </div>
        </div>
    </section>

    {{-- AVANTAGES --}}
    <section class="mt-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ([['🚚', 'Livraison rapide', 'Chez vous en un temps record'], ['🛡️', 'Garantie', 'Produits testés et garantis'], ['💳', 'Paiement sûr', 'Payez à la livraison'], ['💬', 'Support', 'Une équipe à votre écoute']] as [$icon, $title, $text])
            <div class="rounded-2xl bg-white p-4 text-center shadow-sm ring-1 ring-slate-100">
                <div class="text-3xl">{{ $icon }}</div>
                <p class="mt-2 text-sm font-bold">{{ $title }}</p>
                <p class="text-xs text-slate-500">{{ $text }}</p>
            </div>
        @endforeach
    </section>

    {{-- CATEGORIES --}}
    @if ($categories->isNotEmpty())
        <section class="mt-12">
            <h2 class="mb-5 text-2xl font-bold">Nos catégories</h2>
            @php $icons = ['telephones' => '📱', 'ordinateurs' => '💻', 'accessoires' => '🎧']; @endphp
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="group rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="text-4xl transition group-hover:scale-110">{{ $icons[$category->slug] ?? '📦' }}</div>
                        <p class="mt-3 font-semibold">{{ $category->name }}</p>
                        <p class="text-xs text-slate-400">{{ $category->products_count }} produit(s)</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- NOUVEAUTES --}}
    <section class="mt-12">
        <div class="mb-5 flex items-end justify-between">
            <h2 class="text-2xl font-bold">Dernières nouveautés</h2>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-orange-600 hover:underline">Tout voir →</a>
        </div>

        @if ($latest->isEmpty())
            <p class="rounded-2xl bg-white p-8 text-center text-slate-500">Aucun produit pour le moment.</p>
        @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 lg:gap-6">
                @foreach ($latest as $product)
                    @include('shop._card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </section>
@endsection