<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Basket')
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        @if (session()->has('message'))
            <div class="bg-blue-100 border border-blue-500 text-blue-700 p-4 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has("basket"))
            <h1 class="text-2xl font-bold mb-4">Mon panier</h1>
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200 mb-4">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-2 text-left">Produit</th>
                            <th class="py-3 px-2 text-left">Prix</th>
                            <th class="py-3 px-2 text-left">Quantité</th>
                            <th class="py-3 px-2 text-left">Total</th>
                            <th class="py-3 px-2 text-left">Opérations</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <!-- Initialisation du total général à 0 -->
                        @php $total = 0 @endphp

                        <!-- On parcourt les produits du panier en session : session('basket') -->
                        @foreach (session("basket") as $puzzles => $item)
                            <!-- On incrémente le total général par le total de chaque produit du panier -->
                            @php $total += $item['prix'] * $item['quantity'] @endphp
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 px-2 flex items-center">
                                    @if (isset($item['path_image']))
                                        <div class="flex flex-col items-center">
                                            <img src="{{ asset($item['path_image']) }}" alt="{{ $item['nom'] }}" class="h-20 w-20 object-cover rounded mb-1">
                                            <span class="text-center text-gray-800">{{ $item['nom'] }}</span>
                                        </div>
                                    @else
                                        <p>@lang('No image available')</p>
                                    @endif
                                </td>
                                <td class="py-4 px-2">${{ $item['prix'] }}</td>
                                <td class="py-4 px-2">
                                    <form method="POST" action="{{ route('basket.store', $puzzles) }}" class="form-inline d-inline-block">
                                        {{ csrf_field() }}
                                        <input type="number" name="quantity" placeholder="Quantité ?" value="{{ $item['quantity'] }}" class="border border-gray-300 rounded p-1 w-16 mr-2">
                                        <input type="submit" class="bg-blue-500 text-white rounded p-1 hover:bg-blue-600" value="Actualiser" />
                                    </form>
                                </td>
                                <td class="py-4 px-2">${{ $item['prix'] * $item['quantity'] }}</td>
                                <td class="py-4 px-2">
                                    <a href="{{ route('basket.edit', $puzzles) }}" class="bg-red-500 text-white rounded p-1 hover:bg-red-600" title="Retirer le produit du panier">Retirer</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold">
                            <td colspan="4" class="py-4 px-2 text-left">Total général</td>
                            <td class="py-4 px-2">${{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Lien pour vider le panier -->
            <form id="basket-destroy-form" action="{{ route('basket.destroy') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

        @else
            <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded mb-4">Aucun produit au panier</div>
        @endif
    </div>

    <pre class="hidden">{{ print_r(session("basket"), true) }}</pre>
</x-app-layout>
