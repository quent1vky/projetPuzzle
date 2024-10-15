<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter votre adresse') }}
        </h2>
    </x-slot>


    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('adresse.store') }}" method="post">
            @csrf

            <!-- Adresse -->
            <div>
                <x-input-label for="deliv_adresse" :value="__('adresse')" />
                <x-text-input id="deliv_adresse" class="block mt-1 w-full" type="text" name="deliv_adresse" required/>
            </div>

            <br>

            <!-- Ville -->
            <div>
                <x-input-label for="ville" :value="__('Town')" /> <!-- Assurez-vous que l'ID est unique -->
                <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville" required/> <!-- Changer le name ici -->
            </div>

            <br>

            <!-- Code postal -->
            <div>
                <x-input-label for="code_postal" :value="__('code postal')" /> <!-- Assurez-vous que l'ID est unique -->
                <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal" required/> <!-- Changer le name ici -->
            </div>

            <br>

            <!-- Adresse de facturation -->
            <div>
                <x-input-label for="adresse_facturation" :value="__('Adresse facturation')" /> <!-- Assurez-vous que l'ID est unique -->
                <x-text-input id="adresse_facturation" class="block mt-1 w-full" type="text" name="adresse_facturation" required/> <!-- Changer le name ici -->
            </div>



            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    {{ __('Add an adresse') }}
                </button>
            </div>
        </form>


    </x-puzzles-card>
</x-app-layout>

