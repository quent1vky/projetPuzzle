<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Liste des puzzles')
        </h2>
    </x-slot>

        <!-- Message de réussite -->
        @if (session()->has('message'))
        <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
            {{ session('message') }}
        </div>
        @endif

        @foreach ($puzzles as $puzzle)

            <x-link-button href="{{ route('puzzles.show', $puzzle->id) }}">
                @if ($puzzle->path_image)
                    <img src={{ asset($puzzle->path_image) }} alt="" style="max-width: 200px;">
                @else
                    <p>@lang('No image available')</p>
                @endif
            </x-link-button>
            <p>{{ $puzzle->nom }}</p>

        @endforeach

</x-app-layout>
