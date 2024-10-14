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

        <form>
            @csrf

            <!-- Adress -->
            <x-input-label for="address" :value="__('Address :')" />
            <div>{{ Auth::user()->user->address }}</div>

            <br>

            <!-- code postal -->
            <x-input-label for="address" :value="__('Code postal :')" />
            <div>{{ Auth::user()->user->code_postal }}</div>



            <div class="flex items-center justify-end mt-4">

                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    <a href="{{ route('adresse.edit', Auth::user()->user->id) }}">Edit Address</a>
                </button>
            </div>



        </form>
    </x-puzzles-card>
</x-app-layout>
