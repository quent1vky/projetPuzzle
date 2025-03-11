<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter votre adresse') }}
        </h2>
    </x-slot>


    <x-puzzles-card>


        <form action="{{ route('adresse.store') }}" method="post">
            @csrf

            <!-- Adresse -->
            <div>
                <x-input-label for="deliv_adresse" :value="__('Adresse')" />
                <x-text-input id="deliv_adresse" class="block mt-1 w-full" type="text" name="deliv_adresse"/>
                <x-input-error :messages="$errors->get('deliv_adresse')" class="mt-2" />
            </div>

            <br>

            <!-- Ville -->
            <div>
                <x-input-label for="ville" :value="__('Ville')" />
                <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville"/>
                <x-input-error :messages="$errors->get('ville')" class="mt-2" />
            </div>

            <br>

            <!-- Code postal -->
            <div>
                <x-input-label for="code_postal" :value="__('Code postal')" />
                <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal"/>
                <x-input-error :messages="$errors->get('code_postal')" class="mt-2" />
            </div>

            <br>


            <!-- Adresse facturation -->
            <div>
                <x-input-label for="adresse_facturation" :value="__('Adresse de facturation')" />
                <x-text-input id="adresse_facturation" class="block mt-1 w-full" type="text" name="adresse_facturation"/>
                <x-input-error :messages="$errors->get('adresse_facturation')" class="mt-2" />
            </div>



            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    {{ __('Add an adresse') }}
                </button>
            </div>
        </form>


    </x-puzzles-card>
</x-app-layout>

