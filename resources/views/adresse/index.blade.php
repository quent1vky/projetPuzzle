<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Adresse') }}
        </h2>
    </x-slot>


    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <!-- Message d'erreur global -->
        @if ($errors->any())
            <div class="mt-3 mb-4 text-sm text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (auth()->check())

        <x-input-label for="deliv_adresse" :value="__('Address :')" />
            <div>
                <p>{{ $adresse->deliv_adresse ?? 'Aucune adresse de livraison'}}</p>
            </div>

        <br>

        <!-- Code postal -->
        <x-input-label for="code_postal" :value="__('Code postal :')" />
        <div>
            <p>{{ $adresse->code_postal ?? 'Aucun code postal.' }}</p>
        </div>

        <br>

        <!-- Ville -->
        <x-input-label for="ville" :value="__('Ville :')" />
        <div>
            <p>{{ $adresse->ville ?? 'Aucune ville trouvée.' }}</p>
        </div>

        <br>

        <!-- Adresse facturation -->
        <x-input-label for="adresse_facturation" :value="__('Adresse de facturation :')" />
        <div>
            <p>{{ $adresse->adresse_facturation ?? 'Aucune adresse de facturation trouvée.' }}</p>
        </div>

        @else
            <!-- Utilisateur non connecté, on récupère l'adresse depuis la session -->
            @if(session()->has('adresse'))
                <x-input-label for="deliv_adresse" :value="__('Address :')" />
                <div>
                    <p>{{ session('adresse')['deliv_adresse'] ?? 'Aucune adresse de livraison' }}</p>
                </div>

                <br>

                <!-- Code postal -->
                <x-input-label for="code_postal" :value="__('Code postal :')" />
                <div>
                    <p>{{ session('adresse')['code_postal'] ?? 'Aucun code postal.' }}</p>
                </div>

                <br>

                <!-- Ville -->
                <x-input-label for="ville" :value="__('Ville :')" />
                <div>
                    <p>{{ session('adresse')['ville'] ?? 'Aucune ville trouvée.' }}</p>
                </div>

                <br>

                <!-- Adresse facturation -->
                <x-input-label for="adresse_facturation" :value="__('Adresse de facturation :')" />
                <div>
                    <p>{{ session('adresse')['adresse_facturation'] ?? 'Aucune adresse de facturation trouvée.' }}</p>
                </div>

                <br>
            @else
                <p>Aucune adresse enregistrée en session.</p>
            @endif
        @endif

        <br>



        @if (auth()->check())
            <div class="flex items-center justify-end mt-8">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mr-2">
                    <a href="{{ route('paiement.index') }}">{{__('Payment')}}</a>
                </button>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    <a href="{{ route('adresse.edit', Auth::user()->id) }}">{{__('Edit address')}}</a>
                </button>
            </div>
            @else
                @php
                    $userId = session('user_id', 1);  // Récupérer l'ID de l'utilisateur depuis la session
                @endphp
                <!-- Si l'utilisateur n'est pas connecté, vérifier si un ID est stocké en session -->
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mr-2">
                    <a href="{{ route('paiement.index', ['user_id' => $userId]) }}">{{ __('Payment') }}</a>
                </button>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    <a href="{{ route('adresse.edit', $userId) }}">{{ __('Edit address') }}</a>
                </button>
            @endif



    </x-puzzles-card>
</x-app-layout>
