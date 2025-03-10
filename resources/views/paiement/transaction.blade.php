<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Transaction effectué')
        </h2>
    </x-slot>

    <!-- Affichage des messages de session -->
    @if (session()->has('message'))
        <div class="mt-3 mb-4 list-disc list-inside text-2xl text-green-600 px-6">
            {{ session('message') }}
        </div>
    @endif

    <

    <!-- Script de redirection après un délai -->
    <script>
        // Fonction de redirection avec délai
        function redirectionPaiement(url, time) {
            setTimeout(function() {
                window.location.href = url; // Redirection vers l'URL après le délai
            }, time); // Délai en millisecondes
        }

        // Appel de la fonction pour rediriger après 3 secondes (3000 ms)
        redirectionPaiement("{{ route('dashboard') }}", 3000); // Redirection vers le dashboard après 3 secondes
    </script>

</x-app-layout>
