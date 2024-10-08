<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Liste des catégories')
        </h2>
    </x-slot>

        <!-- Message de réussite -->
        @if (session()->has('message'))
        <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
            {{ session('message') }}
        </div>
        @endif

        @foreach ($cat as $categorie)

        <x-link-button href="{{ route('categories.show', $categorie->id) }}">

            @if ($categorie->path_image)
                <img src="{{ asset($categorie->path_image) }}" alt="" style="max-width: 200px;">
            @else
                <p>@lang('No image available')</p>
            @endif

            <p>{{ $categorie->libelle }}</p>
            <p>{{ $categorie->description }}</p>

            <br>
            <br>

        </x-link-button>

        @endforeach



</x-app-layout>
