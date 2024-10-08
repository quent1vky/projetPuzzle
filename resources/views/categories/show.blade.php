<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <p>@lang('Category') : {{$categorie->libelle}}</p> <!-- Affiche le libelle de la catégorie -->
        </h2>
    </x-slot>

    <div>
        <p>Description : {{$categorie->description}}</p> <!-- Affiche la description de la catégorie -->
    </div>

    @if ($categorie->path_image)
        <img src="{{ asset($categorie->path_image) }}" alt="" style="max-width: 200px;">
    @else
        <p>@lang('No image available')</p>
    @endif
</x-app-layout>
