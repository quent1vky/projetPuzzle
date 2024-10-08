<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <p>@lang('Category') : {{$categories->libelle}}</p> <!-- Affiche le libelle de la catégorie -->
        </h2>
    </x-slot>

    <div>
        <p>Description : {{$categories->description}}</p> <!-- Affiche la description de la catégorie -->
    </div>


    @foreach($puzzles as $p)

    <x-link-button href="{{ route('puzzles.show', $p->id) }}">
        <h3 class="font-semibold text-xl text-gray-800 pt-2"> @lang('Image') </h3>
        @if ($p->path_image)
            <img src={{ asset($p->path_image) }} alt="" style="max-width: 200px;">
        @else
            <p>@lang('No image available')</p>
        @endif
    </x-link-button>
    @endforeach



</x-app-layout>

