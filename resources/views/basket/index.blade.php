<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Basket')
        </h2>
    </x-slot>

    <x-app-layout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1>{{ $puzzle->name }}</h1>
                    <h3 class="text-success" >{{ $puzzle->price }} $</h3>
                    <div class="mb-3" >{!! nl2br($puzzle->description) !!}</div>
                    <div class="bg-white mt-3 p-3 border text-center" >
                        <p>Commander <strong>{{ $puzzle->name }}</strong></p>
                        <form method="POST" action="#" class="form-inline d-inline-block" >
                            @csrf

                            <input type="number" name="quantity" placeholder="Quantité ?" class="form-control mr-2" >
                            <button type="submit" class="btn btn-warning" >+ Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>


</x-app-layout>
