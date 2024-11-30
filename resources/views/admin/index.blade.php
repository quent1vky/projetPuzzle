<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des commandes') }}
        </h2>
    </x-slot>


    <ul>
        @foreach ($orders as $o)
            <li>
                ID Commande: {{ $o->id }}<br>
                ID client: {{ $o->user_id }}<br>
                Type de Paiement: {{ $o->total_prix }}€<br>
                Date de Commande: {{ $o->date_commande }}<br>
                Prix: {{ $o->total_prix }}€<br>
                Statut de Commande:{{ $o->statut_commande }}<br>
            </li>
            <br>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    <a href="{{ route('admin.edit', ['id' => $o->id]) }}">{{__('Valider les commandes')}}</a>
                </button>
            </div>
        @endforeach
    </ul>

</x-app-layout>
