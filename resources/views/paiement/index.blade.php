
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Paiement')
        </h2>
    </x-slot>

        <!-- Message d'erreur global -->
        @if ($errors->any())
            <div class="mt-3 mb-4 text-sm text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <div class="container mx-auto p-4">

        @if ($basket)
            <h1 class="text-2xl font-bold mb-4">Récapitulatif de votre commande</h1>
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200 mb-4">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-2 text-left">Produit</th>
                            <th class="py-3 px-2 text-left">Prix</th>
                            <th class="py-3 px-2 text-left">Quantité</th>
                            <th class="py-3 px-2 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">

                        @php
                            $totalP = 0;
                        @endphp

                        @foreach ($basket as $item)
                            @php
                                // Accéder aux informations du puzzle et de la quantité
                                $nom = $item->puzzle->nom ?? 'Nom indisponible';  // Récupérer le nom du puzzle
                                $prix = $item->puzzle->prix ?? 0;  // Récupérer le prix du puzzle
                                $quantity = $item->quantity ?? 1;  // Récupérer la quantité
                                $total = $prix * $quantity;  // Calculer le total pour cet article
                                $imagePath = $item->puzzle->path_image ?? null; // Récupérer l'image
                                $totalP += $total;
                            @endphp
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-4 px-2 flex items-center">
                                    @if ($imagePath)
                                        <div class="flex flex-col items-center">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $nom }}" class="h-20 w-20 object-cover rounded mb-1">
                                            <span class="text-center text-gray-800">{{ $nom }}</span>
                                        </div>
                                    @else
                                        <p>@lang('No image available')</p>
                                    @endif
                                </td>
                                <td class="py-4 px-2">{{ number_format($prix, 2) }} €</td>
                                <td class="py-4 px-2">{{ $quantity }}</td>
                                <td class="py-4 px-2">{{ number_format($total, 2) }} €</td>
                            </tr>
                        @endforeach

                        <tr class="font-bold">
                        <td colspan="3" class="py-4 px-2 text-left">Total général</td>
                        <td class="py-4 px-2">{{ $totalP }} €</td>


                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-red-100 border border-red-500 text-red-700 p-4 rounded mb-4">Aucun produit dans le panier</div>
        @endif

    </div>

    <div class="container mx-auto p-4" py-8>
        <h1 class="text-2xl font-bold mb-4">Choisissez un moyen de paiement</h1>
    </div>

    <div class="container mx-auto p-4">
        <!-- Formulaire Carte Bancaire -->
        <div class="border rounded-lg shadow p-6 bg-white">
            <p class="font-semibold text-lg mb-4">Carte Bancaire</p>
            <button onclick="toggleForm('carte-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Carte Bancaire')
            </button>

            <div id="carte-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="carte-bancaire"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y-m-d') }}">

                    <div class="mb-4">
                        <label for="card-number" class="block text-left">Numéro de Carte:</label>
                        <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" class="border border-gray-300 rounded-lg p-2 w-full" maxlength="19" required>
                        <small class="text-gray-500">Format: 1234 5678 9012 3456</small>
                        <x-input-error :messages="$errors->get('card-number')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="expiration-date" class="block text-left">Date d'Expiration:</label>
                            <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/AA" class="border border-gray-300 rounded-lg p-2 w-full" required>
                            <x-input-error :messages="$errors->get('expiration-date')" class="mt-2" />
                        </div>
                        <div>
                            <label for="cvv" class="block text-left">CVV:</label>
                            <input type="text" id="cvv" name="cvv" class="border border-gray-300 rounded-lg p-2 w-full" required>
                            <x-input-error :messages="$errors->get('cvv')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="card-holder" class="block text-left">Nom du Titulaire de la Carte:</label>
                        <input type="text" id="card-holder" name="card-holder" placeholder="Nom sur la carte" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>

        <!-- Formulaire PayPal -->
        <div class="border rounded-lg shadow p-6 bg-white mt-4">
            <p class="font-semibold text-lg mb-4">Paypal</p>
            <button onclick="toggleForm('paypal-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Paypal')
            </button>

            <div id="paypal-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="paypal"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y_m-d') }}">

                    <div class="mb-4">
                        <label for="paypal-email" class="block text-left">Email PayPal:</label>
                        <input type="email" id="paypal-email" name="paypal-email" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>

        <!-- Formulaire Chèque -->
        <div class="border rounded-lg shadow p-6 bg-white mt-4">
            <p class="font-semibold text-lg mb-4">Chèque</p>
            <button onclick="toggleForm('cheque-form')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mb-4">
                @lang('Payer par Chèque')
            </button>

            <div id="cheque-form" class="hidden mt-4">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type_paiement" value="cheque"> <!-- Champ caché pour type de paiement -->
                    <input type="hidden" name="date_commande" value="{{ now()->format('Y_m-d') }}">

                    <div class="mb-4">
                        <label for="cheque-name" class="block text-left">Nom du Titulaire du Chèque:</label>
                        <input type="text" id="cheque-name" name="cheque-name" placeholder="Nom sur le chèque" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="cheque-amount" class="block text-left">Montant:</label>
                        <input type="text" id="cheque-amount" name="cheque-amount" placeholder="Montant du chèque" class="border border-gray-300 rounded-lg p-2 w-full" required>
                    </div>

                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg mt-4">
                        @lang('Confirmer le paiement')
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script pour afficher/masquer le formulaire -->
    <script src={{ asset('js/script.js')  }}></script>
</x-app-layout>
