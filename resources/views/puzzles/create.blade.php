<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a puzzle') }}
        </h2>
    </x-slot>

    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('puzzles.store') }}" method="post">
            @csrf

            <!-- Nom -->
            <div>
                <x-input-label for="nom" :value="__('nom')" />
                <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <!-- categorie -->
            <div>
                <x-input-label for="categorie" :value="__('categorie')" />
                <x-text-input id="categorie" class="block mt-1 w-full" type="text" name="categorie" :value="old('categorie')" required autofocus />
                <x-input-error :messages="$errors->get('categorie')" class="mt-2" />
            </div>

            <!-- description -->
            <div>
                <x-input-label for="description" :value="__('description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- image -->
            <div>
                <x-input-label for="image" :value="__('image')" />
                <x-text-input id="image" class="block mt-1 w-full" type="text" name="image" required autofocus />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- prix -->
            <div>
                <x-input-label for="prix" :value="__('prix')" />
                <x-text-input id="prix" class="block mt-1 w-full" type="number" step="0.01" name="prix" :value="old('prix')" required autofocus />
                <x-input-error :messages="$errors->get('prix')" class="mt-2" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Send') }}
                </x-primary-button>
            </div>
        </form>
    </x-puzzles-card>
</x-app-layout>
