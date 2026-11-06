@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit…"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200 sm:w-64">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">OK</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-orange-500 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-orange-600">+ Nouveau produit</a>
    </div>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Image</th><th class="px-4 py-3">Nom</th><th class="px-4 py-3">Catégorie</th>
                    <th class="px-4 py-3">Prix</th><th class="px-4 py-3">Stock</th><th class="px-4 py-3">Statut</th><th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-4 py-3"><img src="{{ $product->image_url }}" alt="" class="h-12 w-12 rounded-lg bg-slate-100 object-cover"></td>
                        <td class="px-4 py-3 font-medium">{{ $product->name }}<div class="text-xs text-slate-400">{{ $product->brand }}</div></td>
                        <td class="px-4 py-3">{{ $product->category->name ?? '—' }}</td>
                        <td class="whitespace-nowrap px-4 py-3">@fcfa($product->price)</td>
                        <td class="px-4 py-3">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            @if ($product->is_active)
                                <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">Visible</span>
                            @else
                                <span class="rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-600">Masqué</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-blue-600 hover:underline">Modifier</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection