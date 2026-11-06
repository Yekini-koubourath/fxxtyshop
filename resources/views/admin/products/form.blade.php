@extends('layouts.admin')

@section('title', $product->exists ? 'Modifier le produit' : 'Nouveau produit')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
          class="mx-auto max-w-2xl space-y-4 rounded-2xl bg-white p-6 shadow-sm">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

      <div>
    <label for="category_id" class="mb-1 block text-sm font-medium text-slate-700">Catégorie</label>

    @if ($categories->isEmpty())
        <p class="rounded-lg bg-amber-50 px-3 py-2 text-sm text-amber-800">
            Aucune catégorie n'existe encore.
            <a href="{{ route('admin.categories.create') }}" class="font-semibold underline">Créer une catégorie</a>
        </p>
    @else
        <select id="category_id" name="category_id" required
                class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <option value="">— Choisir une catégorie —</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    @endif

    @error('category_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        <x-field name="name" label="Nom du produit" :value="$product->name" required />
        <x-field name="brand" label="Marque" :value="$product->brand" />

        <div class="grid gap-4 sm:grid-cols-2">
            <x-field name="price" label="Prix (FCFA)" type="number" min="0" :value="$product->price" required />
            <x-field name="stock" label="Stock" type="number" min="0" :value="$product->stock ?? 0" required />
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
            <textarea id="description" name="description" rows="5"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
<div>
    <label for="image-picker" class="mb-1 block text-sm font-medium text-slate-700">Image du produit</label>

    @php
        $previewSrc = old('image_data') ?: ($product->exists && $product->image ? $product->image_url : '');
    @endphp

    <img id="image-preview" alt=""
         class="mb-2 h-24 w-24 rounded-lg object-cover {{ $previewSrc ? '' : 'hidden' }}"
         @if ($previewSrc) src="{{ $previewSrc }}" @endif>

    <input type="hidden" name="image_data" id="image_data" value="{{ old('image_data') }}">

    <input id="image-picker" type="file" accept="image/*"
           class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-white hover:file:bg-slate-700">

    <p class="mt-1 text-xs text-slate-400">JPG, PNG ou WebP. L'image est réduite automatiquement avant l'envoi.</p>

    @error('image_data')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-orange-500 focus:ring-orange-300"
                   @checked(old('is_active', $product->exists ? $product->is_active : true))>
            Visible dans la boutique
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-orange-500 px-6 py-2 font-semibold text-white hover:bg-orange-600">Enregistrer</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-6 py-2 text-slate-600 hover:bg-slate-50">Annuler</a>
        </div>
    </form>
    <script>
(function () {
    var input = document.getElementById('image-picker');
    var hidden = document.getElementById('image_data');
    var preview = document.getElementById('image-preview');
    if (!input) return;

    input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;

        var url = URL.createObjectURL(file);
        var img = new Image();

        img.onerror = function () {
            URL.revokeObjectURL(url);
            alert("Cette image n'a pas pu être lue. Essayez un fichier JPG ou PNG.");
        };

        img.onload = function () {
            var max = 1200;
            var ratio = Math.min(1, max / Math.max(img.width, img.height));
            var canvas = document.createElement('canvas');
            canvas.width = Math.round(img.width * ratio);
            canvas.height = Math.round(img.height * ratio);

            var ctx = canvas.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            hidden.value = canvas.toDataURL('image/jpeg', 0.82);
            preview.src = hidden.value;
            preview.classList.remove('hidden');
            URL.revokeObjectURL(url);
        };

        img.src = url;
    });
})();
</script>
@endsection