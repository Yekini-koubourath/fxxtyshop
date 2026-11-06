@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600">+ Nouvelle catégorie</a>
    </div>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full min-w-[480px] text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr><th class="px-4 py-3">Nom</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Produits</th><th class="px-4 py-3 text-right">Actions</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3">{{ $category->products_count }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-blue-600 hover:underline">Modifier</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Supprimer cette catégorie ? Ses produits seront aussi supprimés.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-10 text-center text-slate-400">Aucune catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection