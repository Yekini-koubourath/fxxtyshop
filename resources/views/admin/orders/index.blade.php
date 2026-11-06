@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
    <div class="mb-4 flex flex-wrap gap-2 text-sm">
        <a href="{{ route('admin.orders.index') }}" class="rounded-full px-4 py-1.5 {{ request('status') ? 'bg-white text-slate-600 hover:bg-slate-50' : 'bg-slate-900 text-white' }}">Toutes</a>
        @foreach (\App\Models\Order::STATUSES as $key => $label)
            <a href="{{ route('admin.orders.index', ['status' => $key]) }}"
               class="rounded-full px-4 py-1.5 {{ request('status') === $key ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full min-w-[680px] text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">#</th><th class="px-4 py-3">Client</th><th class="px-4 py-3">Téléphone</th>
                    <th class="px-4 py-3">Total</th><th class="px-4 py-3">Statut</th><th class="px-4 py-3">Date</th><th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3">{{ $order->phone }}</td>
                        <td class="whitespace-nowrap px-4 py-3">@fcfa($order->total)</td>
                        <td class="px-4 py-3">@include('partials.status-badge', ['status' => $order->status])</td>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-blue-600 hover:underline">Voir</a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Supprimer cette commande ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endsection