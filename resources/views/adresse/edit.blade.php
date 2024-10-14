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

            <!-- Adresse -->
            <div>
                <x-input-label for="address" :value="__('adresse')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ Auth::user()->user->address }}"/>
            </div>

            <br>

            <!-- Code postal -->
            <div>
                <x-input-label for="code_postal" :value="__('code postal')" /> <!-- Assurez-vous que l'ID est unique -->
                <x-text-input id="code_postal" class="block mt-1 w-full" type="text" name="code_postal" value="{{ Auth::user()->user->code_postal }}"/> <!-- Changer le name ici -->
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="ml-3">
                    {{ __('Update address') }}
                </button>
            </div>
        </form>


    </x-puzzles-card>
</x-app-layout>
