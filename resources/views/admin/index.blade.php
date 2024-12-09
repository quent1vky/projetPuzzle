<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    <!-- Message de réussite -->
    @if (session()->has('message'))
        <div class="mt-3 mb-4 text-sm text-green-600">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tableau des commandes -->
    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 px-4 py-2 text-left">ID Commande</th>
                    <th class="border border-gray-400 px-4 py-2 text-left">ID Client</th>
                    <th class="border border-gray-400 px-4 py-2 text-left">Type de Paiement</th>
                    <th class="border border-gray-400 px-4 py-2 text-left">Date de Commande</th>
                    <th class="border border-gray-400 px-4 py-2 text-right">Prix (€)</th>
                    <th class="border border-gray-400 px-4 py-2 text-left">Statut</th>
                    <th class="border border-gray-400 px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $o)
                    <tr class="{{ $loop->odd ? 'bg-gray-100' : '' }}">
                        <td class="border border-gray-400 px-4 py-2">{{ $o->id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $o->user_id }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $o->methode_paiement }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $o->date_commande }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-right">{{ number_format($o->total_prix, 2) }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            @switch($o->statut_commande)
                                @case(0)
                                    En attente
                                    @break
                                @case(1)
                                    Validée
                                    @break
                                @case(2)
                                    Expédiée
                                    @break
                                @default
                                    Inconnu
                            @endswitch
                        </td>
                        <td class="border border-gray-400 px-4 py-2 text-center">
                            <a href="{{ route('admin.edit', ['id' => $o->id]) }}"
                               class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                {{ __('Modifier') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
