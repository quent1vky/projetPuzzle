<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <ul>
        <li>
            <form action="{{ route('admin.update', $o->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="type_paiement" value="{{ $o->type_paiement }}">
                <input type="hidden" name="date_commande" value="{{ $o->date_commande }}">
                <input type="hidden" name="total_prix" value="{{ $o->total_prix }}">
                <input type="hidden" name="methode_paiement" value="{{ $o->methode_paiement }}">

                <!-- Détails de la commande dans un tableau -->
                <h3 class="text-lg font-bold mb-4">Articles de la commande</h3>
                <table class="table-auto border-collapse border border-gray-400 w-full mb-4">
                    <thead>
                        <tr>
                            <th class="border border-gray-400 px-4 py-2">Nom</th>
                            <th class="border border-gray-400 px-4 py-2">Quantité</th>
                            <th class="border border-gray-400 px-4 py-2">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $a)
                            <tr>
                                <td class="border border-gray-400 px-4 py-2">{{ $a['nom'] }}</td>
                                <td class="border border-gray-400 px-4 py-2 text-center">{{ $a['quantity'] }}</td>
                                <td class="border border-gray-400 px-4 py-2 text-right">{{ number_format($a['prix'], 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Modifier le statut de la commande -->
                <x-input-label for="statut_commande" value="{{ __('Statut Commande') }}" />
                <select id="statut_commande" name="statut_commande" class="block mt-1 w-full">
                    <option value="0" {{ $o->statut_commande == '0' ? 'selected' : '' }}>En attente</option>
                    <option value="1" {{ $o->statut_commande == '1' ? 'selected' : '' }}>Validée</option>
                    <option value="2" {{ $o->statut_commande == '2' ? 'selected' : '' }}>Expédiée</option>
                </select><br>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mt-2">
                    {{ __('Valider les modifications') }}
                </button>
            </form>
        </li>
    </ul>


</x-app-layout>


