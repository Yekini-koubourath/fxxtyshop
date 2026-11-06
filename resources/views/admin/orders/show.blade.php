@extends('layouts.admin')

@section('title', 'Commande #'.$order->id)

@section('content')
    <a href="{{ route('admin.orders.index') }}" class="mb-4 inline-block text-sm text-slate-500 hover:text-orange-600">← Retour aux commandes</a>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="space-y-1 rounded-2xl bg-white p-6 text-sm shadow-sm">
            <h2 class="mb-2 font-bold">Client</h2>
            <p><span class="text-slate-500">Nom :</span> {{ $order->customer_name }}</p>
            <p><span class="text-slate-500">Téléphone :</span> {{ $order->phone }}</p>
            <p><span class="text-slate-500">Adresse :</span> {{ $order->address }}</p>
            <p><span class="text-slate-500">Date :</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p class="pt-2">@include('partials.status-badge', ['status' => $order->status])</p>

            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-2 border-t pt-4">
                @csrf
                @method('PATCH')
                <label for="status" class="block text-sm font-medium">Changer le statut</label>
                <select id="status" name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                    @foreach (\App\Models\Order::STATUSES as $key => $label)
                        <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full rounded-lg bg-orange-500 py-2 font-semibold text-white hover:bg-orange-600">Mettre à jour</button>
            </form>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="mb-3 font-bold">Articles</h2>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[400px] text-left text-sm">
                    <thead class="text-xs uppercase text-slate-500">
                        <tr><th class="py-2">Produit</th><th class="py-2">Prix</th><th class="py-2">Qté</th><th class="py-2 text-right">Sous-total</th></tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="py-3">{{ $item->product_name }}</td>
                                <td class="whitespace-nowrap py-3">@fcfa($item->price)</td>
                                <td class="py-3">{{ $item->quantity }}</td>
                                <td class="whitespace-nowrap py-3 text-right font-medium">@fcfa($item->price * $item->quantity)</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-4 border-t pt-4 text-right text-lg font-extrabold">Total : <span class="text-orange-600">@fcfa($order->total)</span></p>
        </section>
    </div>
@endsection