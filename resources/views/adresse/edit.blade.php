<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update address delivery') }}
        </h2>
    </x-slot>


    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif


        <form action="{{ route('adresse.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Si l'utilisateur est connecté on utilise les donnée stocké en bdd -->
            @if (auth()->check())

                <!-- Adresse -->
                <div>
                    <x-input-label for="deliv_adresse" :value="__('Adresse')" />
                    <x-text-input id="deliv_adresse" class="block mt-1 w-full" type="text" name="deliv_adresse" value="{{ $adresse->deliv_adresse }}"/>
                </div>

                <br>

                <!-- Ville -->
                <div>
                    <x-input-label for="ville" :value="__('Ville')" />
                    <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville" value="{{ $adresse->ville }}"/>
                </div>

                <br>

                <!-- Code postal -->
                <div>
                    <x-input-label for="code_postal" :value="__('Code postal')" />
                    <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal" value="{{ $adresse->code_postal }}"/>
                </div>

                <br>


                <!-- Adresse facturation -->
                <div>
                    <x-input-label for="adresse_facturation" :value="__('Adresse de facturation')" />
                    <x-text-input id="adresse_facturation" class="block mt-1 w-full" type="text" name="adresse_facturation" value="{{ session('adresse')['adresse_facturation'] }}"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        {{ __('Update address') }}
                    </button>
                </div>

            <!-- Pour un utilisateur non connecté on utilise les variables de la session -->
            @else
                <!-- Adresse -->
                <div>
                    <x-input-label for="deliv_adresse" :value="__('Adresse')" />
                    <x-text-input id="deliv_adresse" class="block mt-1 w-full" type="text" name="deliv_adresse" value="{{ session('adresse')['deliv_adresse'] }}"/>
                </div>

                <br>

                <!-- Ville -->
                <div>
                    <x-input-label for="ville" :value="__('Ville')" />
                    <x-text-input id="ville" class="block mt-1 w-full" type="text" name="ville" value="{{ session('adresse')['ville'] }}"/>
                </div>

                <br>

                <!-- Code postal -->
                <div>
                    <x-input-label for="code_postal" :value="__('Code postal')" />
                    <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal" value="{{ session('adresse')['code_postal'] }}"/>
                </div>

                <br>


                <!-- Adresse facturation -->
                <div>
                    <x-input-label for="adresse_facturation" :value="__('Adresse de facturation')" />
                    <x-text-input id="adresse_facturation" class="block mt-1 w-full" type="text" name="adresse_facturation" value="{{ session('adresse')['adresse_facturation'] }}"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        {{ __('Update address') }}
                    </button>
                </div>

            @endif


        </form>


    </x-puzzles-card>
</x-app-layout>
