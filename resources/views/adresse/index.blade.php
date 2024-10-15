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

            <!-- Adresse de livraison -->
            <x-input-label for="deliv_adresse" :value="__('Address :')" />
            <div>
                @if(Auth::user()->delivery_addresses)
                    {{ Auth::user()->delivery_addresses->first()->deliv_adresse }}
                @else
                    <span>{{ __('No delivery address found') }}</span>
                @endif
            </div>

            <br>

            <!-- Code postal -->
            <x-input-label for="code_postal" :value="__('Postal Code :')" />
            <div>
                @if(Auth::user()->delivery_addresses)
                    {{ Auth::user()->delivery_addresses->first()->code_postal }}
                @else
                    <span>{{ __('No postal code found') }}</span>
                @endif
            </div>

            <br>

            <!-- Ville -->
            <x-input-label for="ville" :value="__('City :')" />
            <div>
                @if(Auth::user()->delivery_addresses)
                    {{ Auth::user()->delivery_addresses->first()->ville }}
                @else
                    <span>{{ __('No city found') }}</span>
                @endif
            </div>

            <br>

            <!-- Adresse de facturation -->
            <x-input-label for="adresse_facturation" :value="__('Billing Address :')" />
            <div>
                @if(Auth::user()->delivery_addresses)
                    {{ Auth::user()->delivery_addresses->first()->adresse_facturation }}
                @else
                    <span>{{ __('No billing address found') }}</span>
                @endif
            </div>



            <div class="flex items-center justify-end mt-8">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow mr-2">
                    <a href="{{ route('paiement.index') }}">{{__('Payement')}}</a>
                </button>

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    <a href="{{ route('adresse.edit', Auth::user()->id) }}">{{__('Edit address')}}</a>
                </button>
            </div>


    </x-puzzles-card>
</x-app-layout>
