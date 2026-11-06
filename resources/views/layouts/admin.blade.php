<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') – Fxxtyschop</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="flex min-h-screen">

        {{-- Fond sombre (mobile) --}}
        <div id="admin-overlay" class="fixed inset-0 z-30 hidden bg-black/50 md:hidden"
             onclick="document.getElementById('admin-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>

        {{-- ============ SIDEBAR ============ --}}
        <aside id="admin-sidebar"
               class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full transform flex-col bg-slate-900 text-slate-300 transition-transform duration-200 md:sticky md:top-0 md:h-screen md:translate-x-0">
            <div class="border-b border-white/10 p-4">
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo.svg') }}" alt="Fxxtyschop" class="h-10 w-auto"></a>
                <p class="mt-1 text-xs uppercase tracking-widest text-slate-500">Administration</p>
            </div>

            @php
                $links = [
                    ['admin.dashboard', 'admin.dashboard', '📊', 'Tableau de bord'],
                    ['admin.products.index', 'admin.products.*', '📦', 'Produits'],
                    ['admin.categories.index', 'admin.categories.*', '🏷️', 'Catégories'],
                    ['admin.orders.index', 'admin.orders.*', '🧾', 'Commandes'],
                ];
            @endphp

            <nav class="flex-1 space-y-1 overflow-y-auto p-3 text-sm font-medium">
                @foreach ($links as [$route, $pattern, $icon, $label])
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs($pattern) ? 'bg-orange-500 text-white' : 'hover:bg-white/10 hover:text-white' }}">
                        <span>{{ $icon }}</span><span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="space-y-1 border-t border-white/10 p-3 text-sm">
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white">🌐 Voir le site</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-lg px-3 py-2 text-left hover:bg-white/10 hover:text-white">🚪 Déconnexion</button>
                </form>
            </div>
        </aside>

        {{-- ============ CONTENU ============ --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 flex items-center justify-between bg-white px-4 py-3 shadow-sm md:px-8">
                <button type="button" class="rounded-lg p-2 hover:bg-slate-100 md:hidden" aria-label="Menu"
                        onclick="document.getElementById('admin-sidebar').classList.remove('-translate-x-full'); document.getElementById('admin-overlay').classList.remove('hidden');">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-bold">@yield('title', 'Administration')</h1>
                <span class="hidden text-sm text-slate-500 sm:block">{{ auth()->user()->name }}</span>
            </header>

            <main class="flex-1 p-4 md:p-8">
                @include('partials.alerts')
                @yield('content')
            </main>

            <footer class="px-4 py-4 text-center text-xs text-slate-400 md:px-8">
                © {{ date('Y') }} Fxxtyschop – Espace administrateur
            </footer>
        </div>
    </div>
</body>
</html>