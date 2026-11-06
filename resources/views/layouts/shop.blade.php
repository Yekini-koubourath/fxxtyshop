<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fxxtyschop') – Téléphones &amp; Ordinateurs</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-50 text-slate-800 antialiased">

    {{-- ============ NAVBAR ============ --}}
    <header class="sticky top-0 z-50 bg-slate-900 text-white shadow-lg">
        <div class="bg-orange-500 py-1 text-center text-xs font-medium text-white">
            Livraison rapide · Produits garantis · Paiement à la livraison
        </div>

        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ route('home') }}" class="shrink-0">
                <img src="{{ asset('images/logo.svg') }}" alt="Fxxtyschop" class="h-10 w-auto">
            </a>

            <form action="{{ route('shop.index') }}" method="GET" class="hidden max-w-md flex-1 md:block">
                <div class="flex overflow-hidden rounded-lg bg-white">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un téléphone, un PC…"
                           class="w-full border-0 px-4 py-2 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0">
                    <button type="submit" class="bg-orange-500 px-4 text-sm font-semibold hover:bg-orange-600">OK</button>
                </div>
            </form>

            <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-orange-400' : 'hover:text-orange-400' }}">Accueil</a>
                <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'text-orange-400' : 'hover:text-orange-400' }}">Boutique</a>

              @auth
    @if (auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-white/10 px-3 py-1.5 text-orange-300 hover:bg-white/20">Admin</a>
    @endif
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="hover:text-orange-400">Déconnexion</button>
    </form>
@endauth
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('cart.index') }}" class="relative rounded-lg p-2 hover:bg-white/10" aria-label="Panier">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                    @php $cartCount = \App\Support\Cart::count(); @endphp
                    @if ($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-orange-500 px-1 text-xs font-bold">{{ $cartCount }}</span>
                    @endif
                </a>

                <button type="button" class="rounded-lg p-2 hover:bg-white/10 md:hidden" aria-label="Menu"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <div id="mobile-menu" class="hidden border-t border-white/10 px-4 pb-4 md:hidden">
            <form action="{{ route('shop.index') }}" method="GET" class="my-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher…"
                       class="w-full rounded-lg border-0 px-4 py-2 text-sm text-slate-800 focus:outline-none">
            </form>
            <div class="flex flex-col gap-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Accueil</a>
                <a href="{{ route('shop.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Boutique</a>
                <a href="{{ route('cart.index') }}" class="rounded-lg px-3 py-2 hover:bg-white/10">Panier</a>
@auth
    @if (auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-orange-300 hover:bg-white/10">Administration</a>
    @endif
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full rounded-lg px-3 py-2 text-left hover:bg-white/10">Déconnexion</button>
    </form>
@endauth
            </div>
        </div>
    </header>

    {{-- ============ CONTENU (flex-1 pousse le footer en bas) ============ --}}
    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8">
        @include('partials.alerts')
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="mt-auto bg-slate-900 text-slate-400">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <img src="{{ asset('images/logo.svg') }}" alt="Fxxtyschop" class="mb-3 h-10 w-auto">
                <p class="text-sm">Votre boutique de confiance pour les téléphones, ordinateurs et accessoires. Qualité garantie, prix imbattables.</p>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-orange-400">Accueil</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-orange-400">Boutique</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-orange-400">Mon panier</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Catégories</h3>
                <ul class="space-y-2 text-sm">
                    @foreach (\App\Models\Category::orderBy('name')->take(5)->get() as $footerCat)
                        <li><a href="{{ route('shop.index', ['category' => $footerCat->slug]) }}" class="hover:text-orange-400">{{ $footerCat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-white">Contact</h3>
                <ul class="space-y-2 text-sm">
                    <li>📞 +229 00 00 00 00</li>
                    <li>✉️ contact@fxxtyschop.com</li>
                    <li>🕘 Lun – Sam : 8h – 19h</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs">
            © {{ date('Y') }} Fxxtyschop – Tous droits réservés.
        </div>
    </footer>
</body>
</html>