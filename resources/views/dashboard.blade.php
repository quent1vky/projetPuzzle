<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accueil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(isset($user))
                    <li>Bienvenue,{{ $user->first_name }}</li>
                @else
                    <li>Bienvenue, invité</li>
                @endif

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($puzzles as $p)
                    <x-link-button href="{{ route('puzzles.show', $p->id) }}">
                        @if ($p->path_image)
                            <img src={{ asset($p->path_image) }} alt="" style="max-width: 200px;">
                        @else
                            <p>@lang('No image available')</p>
                        @endif
                        <p>{{ $p->nom }}</p>
                    </x-link-button>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
