@extends('layouts.shop')

@section('title', 'Finaliser la commande')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Finaliser la commande</h1>

    <div class="grid gap-6 lg:grid-cols-3">
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 lg:col-span-2">
            @csrf
            <h2 class="text-lg font-bold">Vos informations</h2>
            <x-field name="customer_name" label="Nom complet" :value="auth()->check() ? auth()->user()->name : ''" required />
            <x-field name="phone" label="Téléphone" type="tel" placeholder="+229 ..." required />
            <x-field name="address" label="Adresse de livraison" placeholder="Quartier, rue, repère…" required />
            <button type="submit" class="w-full rounded-xl bg-orange-500 py-3 font-semibold text-white transition hover:bg-orange-600 sm:w-auto sm:px-10">Confirmer la commande</button>
            <p class="text-xs text-slate-400">Paiement à la livraison. Nous vous contacterons pour confirmer.</p>
        </form>

        <aside class="h-fit rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <h2 class="text-lg font-bold">Votre commande</h2>
            <ul class="mt-4 divide-y text-sm">
                @foreach ($lines as $line)
                    <li class="flex justify-between gap-3 py-2">
                        <span>{{ $line->product->name }} × {{ $line->qty }}</span>
                        <span class="whitespace-nowrap font-medium">@fcfa($line->subtotal)</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3 flex justify-between border-t pt-3 text-lg font-extrabold">
                <span>Total</span><span class="text-orange-600">@fcfa($total)</span>
            </div>
        </aside>
    </div>
@endsection