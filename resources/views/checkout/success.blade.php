@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')
    <div class="mx-auto max-w-xl rounded-3xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-100 sm:p-12">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl text-green-600">✓</div>
        <h1 class="mt-5 text-2xl font-extrabold">Merci pour votre commande !</h1>
        <p class="mt-2 text-slate-600">Commande <strong>#{{ $order->id }}</strong> enregistrée.</p>

        <ul class="mt-6 divide-y rounded-xl bg-slate-50 px-4 text-left text-sm">
            @foreach ($order->items as $item)
                <li class="flex justify-between gap-3 py-2">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span class="whitespace-nowrap">@fcfa($item->price * $item->quantity)</span>
                </li>
            @endforeach
            <li class="flex justify-between py-2 font-bold"><span>Total</span><span class="text-orange-600">@fcfa($order->total)</span></li>
        </ul>

        <p class="mt-5 text-sm text-slate-500">Nous vous contacterons au <strong>{{ $order->phone }}</strong> pour confirmer la livraison.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-block rounded-xl bg-orange-500 px-6 py-3 font-semibold text-white hover:bg-orange-600">Retour à l'accueil</a>
    </div>
@endsection