@php
    $map = [
        'en_attente' => ['En attente', 'bg-amber-100 text-amber-700'],
        'confirmee'  => ['Confirmée', 'bg-blue-100 text-blue-700'],
        'livree'     => ['Livrée', 'bg-green-100 text-green-700'],
        'annulee'    => ['Annulée', 'bg-red-100 text-red-700'],
    ];
    [$badgeLabel, $badgeClass] = $map[$status] ?? [$status, 'bg-slate-100 text-slate-700'];
@endphp
<span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeClass }}">{{ $badgeLabel }}</span>