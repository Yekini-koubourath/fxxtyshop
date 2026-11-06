@extends('layouts.admin')

@section('title', $category->exists ? 'Modifier la catégorie' : 'Nouvelle catégorie')

@section('content')
    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="mx-auto max-w-lg space-y-4 rounded-2xl bg-white p-6 shadow-sm">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <x-field name="name" label="Nom de la catégorie" :value="$category->name" required />

        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-orange-500 px-6 py-2 font-semibold text-white hover:bg-orange-600">Enregistrer</button>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-300 px-6 py-2 text-slate-600 hover:bg-slate-50">Annuler</a>
        </div>
    </form>
@endsection