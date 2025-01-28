<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.update') }}" method="post">
                @csrf
                @method('PUT') <!-- Using the PUT method for updating -->

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Détails
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Informations
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- ID -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>ID:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->id }}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </td>
                        </tr>
                        <!-- Type de Paiement -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Type de Paiement:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->type_paiement }}
                                <input type="hidden" name="type_paiement" value="{{ $order->type_paiement }}">
                            </td>
                        </tr>
                        <!-- Date de Commande -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Date de Commande:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->date_commande }}
                                <input type="hidden" name="date_commande" value="{{ $order->date_commande }}">
                            </td>
                        </tr>
                        <!-- Prix -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Prix:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->total_prix }}€
                                <input type="hidden" name="total_prix" value="{{ $order->total_prix }}">
                            </td>
                        </tr>
                        <!-- Statut Commande -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <strong>Statut Commande:</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <x-input-label for="statut_commande_{{ $order->id }}" :value="__('Statut Commande')" />
                                <select id="statut_commande_{{ $order->id }}" name="statut_commande" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="en_attente" {{ $order->statut_commande == 'en_attente' ? 'selected' : '' }}>
                                        {{ __('En attente') }}
                                    </option>
                                    <option value="validé" {{ $order->statut_commande == 'validé' ? 'selected' : '' }}>
                                        {{ __('Validé') }}
                                    </option>
                                    <option value="annulée" {{ $order->statut_commande == 'annulée' ? 'selected' : '' }}>
                                        {{ __('Annulée') }}
                                    </option>
                                </select>
                            </td>
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-end mt-10 mb-8 ml-8 mr-8">
                    <button type="submit" class="bg-green-500 hover:bg-green-400 text-white font-semibold py-2 px-6 rounded-lg shadow">
                        {{ __('Confirmer les modifications') }}
                    </button>
                </div>


            </form>
        </div>
    </div>
</x-app-layout>
