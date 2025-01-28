<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    <ul>
        <li>
            <form action="{{ route('admin.update') }}" method="post">
                @csrf
                @method('PUT') <!-- Using the PUT method for updating -->

                <p><strong>ID:</strong> {{ $orders->id }}</p>
                <p><strong>Type de Paiement:</strong> {{ $orders->type_paiement }}</p>
                <input type="hidden" name="type_paiement" value="{{ $orders->type_paiement }}">

                <p><strong>Date de Commande:</strong> {{ $orders->date_commande }}</p>
                <input type="hidden" name="date_commande" value="{{ $orders->date_commande }}">

                <input type="hidden" name="articles" value="{{ $orders->articles }}">

                <p><strong>Prix:</strong> {{ $orders->total_prix }}€</p>
                <input type="hidden" name="total_prix" value="{{ $orders->total_prix }}">

                <input type="hidden" name="methode_paiement" value="{{ $orders->methode_paiement }}">

                <x-input-label for="statut_commande_{{ $orders->id }}" :value="__('Statut Commande')" />
                <select id="statut_commande_{{ $orders->id }}" name="statut_commande" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="en_attente" {{ $orders->statut_commande == 'en_attente' ? 'selected' : '' }}>
                        {{ __('En attente') }}
                    </option>
                    <option value="en_cours" {{ $orders->statut_commande == 'en_cours' ? 'selected' : '' }}>
                        {{ __('En cours') }}
                    </option>
                    <option value="livrée" {{ $orders->statut_commande == 'livrée' ? 'selected' : '' }}>
                        {{ __('Livrée') }}
                    </option>
                    <option value="annulée" {{ $orders->statut_commande == 'annulée' ? 'selected' : '' }}>
                        {{ __('Annulée') }}
                    </option>
                </select>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mt-2">
                    {{ __('Valider les modifications') }}
                </button>
            </form>
        </li>
    </ul>
</x-app-layout>
