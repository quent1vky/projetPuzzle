<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    <!-- Tableau des commandes -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('ID Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('ID Client') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Type de Paiement') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Date de Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Prix') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Statut de Commande') }}</th>
                    <th class="px-4 py-2 text-left border border-gray-300">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $o)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->id }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->user_id }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->type_paiement }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->date_commande }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->total_prix }}€</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $o->statut_commande }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="{{ route('admin.edit', ['id' => $o->id]) }}" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                {{ __('Valider') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
