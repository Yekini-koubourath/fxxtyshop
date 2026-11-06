<div class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-xl">
    <a href="{{ route('shop.show', $product) }}" class="relative block overflow-hidden bg-slate-100">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
             class="h-44 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-52">
        @if ($product->stock < 1)
            <span class="absolute left-2 top-2 rounded-full bg-red-600 px-2 py-0.5 text-xs font-semibold text-white">Rupture</span>
        @elseif ($product->stock <= 3)
            <span class="absolute left-2 top-2 rounded-full bg-amber-500 px-2 py-0.5 text-xs font-semibold text-white">Dernières pièces</span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-4">
        <p class="text-xs uppercase tracking-wide text-slate-400">
            {{ $product->category->name ?? '' }}@if ($product->brand) · {{ $product->brand }}@endif
        </p>
        <a href="{{ route('shop.show', $product) }}" class="mt-1 font-semibold text-slate-800 hover:text-orange-600">{{ $product->name }}</a>
        <p class="mt-2 text-lg font-extrabold text-orange-600">@fcfa($product->price)</p>

        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-auto pt-4">
            @csrf
            <button type="submit" @if ($product->stock < 1) disabled @endif
                    class="w-full rounded-lg bg-slate-900 py-2 text-sm font-semibold text-white transition hover:bg-orange-500 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:bg-slate-900">
                {{ $product->stock > 0 ? 'Ajouter au panier' : 'Indisponible' }}
            </button>
        </form>
    </div>
</div>