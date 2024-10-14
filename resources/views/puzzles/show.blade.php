<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $puzzle->nom }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg flex justify-between items-start">
        <!-- Section de gauche : description -->
        <div class="w-1/2">
            <h1 class="text-3xl font-bold text-gray-800">{{ $puzzle->nom }}</h1>
            <h2 class="text-xl text-gray-400">Sous-titre</h2> <!-- Tu peux remplacer par un champ réel -->

            <p class="text-gray-700 mt-4">{{ $puzzle->description }}</p>

            <div class="mt-4 text-lg font-bold text-gray-900">
                {{ $puzzle->prix }} €
            </div>

            <!-- Bouton d'ajout au panier -->
            <form method="POST" action="{{ route('basket.store', $puzzle) }}" class="pt-4">
                @csrf
                <input type="number" name="quantity" placeholder="Quantité ?" class="form-input mr-2 border rounded-lg shadow-sm focus:ring focus:ring-opacity-50" min="1" required>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">+ @lang('Add to basket')</button>
            </form>
        </div>

        <!-- Section de droite : image -->
        <div class="w-1/3">
            @if ($puzzle->path_image)
                <img src="{{ asset($puzzle->path_image) }}" alt="{{ $puzzle->nom }}" class="w-full max-w-xs rounded-lg shadow-sm">
            @else
                <div class="bg-gray-200 text-gray-500 h-full flex items-center justify-center rounded-lg">
                    <p>@lang('Aucune image disponible')</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
