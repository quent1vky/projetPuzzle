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
                    @method('PUT') <!-- Utilisation de la méthode PUT pour une mise à jour -->

                    ID: {{ $o->id }}<br>
                    Type de Paiement: {{ $o->type_paiement }}<br>
                    <input type="hidden" name="type_paiement" value="{{ $o->type_paiement }}">

                    Date de Commande: {{ $o->date_commande }}<br>
                    <input type="hidden" name="date_commande" value="{{ $o->date_commande }}">

                    <input type="hidden" name="articles" value="{{ $o->articles }}">

                    Prix: {{ $o->total_prix }}€<br>
                    <input type="hidden" name="total_prix" value="{{ $o->total_prix }}">

                    <input type="hidden" name="methode_paiement" value="{{ $o->methode_paiement }}">

                    <x-input-label for="statut_commande_{{ $o->id }}" :value="__('Statut Commande')" />
                    <x-text-input id="statut_commande_{{ $o->id }}" class="block mt-1 w-full" type="text" name="statut_commande" value="{{ $o->statut_commande }}"/><br>

                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mt-2">
                        {{ __('Valider les modifications') }}
                    </button>
                </form>
            </li>
    </ul>

</x-app-layout>
