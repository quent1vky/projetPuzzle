<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adresse;
use App\Models\User;


// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class AdresseController extends Controller
{
    public function index()
    {
        $deliveryAddresses = Auth::user()->delivery_addresses; // Récupérer toutes les adresses de livraison de l'utilisateur
        return view('adresse.index', compact('deliveryAddresses'));
    }


    public function edit()
    {
        return view('adresse.edit');
    }

    public function create()
    {
        return view('adresse.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deliv_adresse' => 'required|string|max:255',
            'code_postal' => 'required|max:10',
            'ville' => 'required|string|max:255',
        ]);


        //Creation d'une adresse'
        $adresse = new Adresse();
        $adresse -> deliv_adresse = $request-> deliv_adresse;
        $adresse->code_postal = $request->code_postal;
        $adresse->ville = $request->ville;
        $adresse-> adresse_facturation = $request-> adresse_facturation;
        $adresse->user_id = Auth::id();
        $adresse->save();
        return redirect()->route('adresse.index')->with('message', "L'adresse a bien été ajoutée !");
    }


    public function update(Request $request)
    {
        $data = $request->validate([
            'deliv_adresse' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
            'ville' => 'required|string|max:255',
        ]);

        $adresse = Auth::user()->delivery_addresses;

        // Mettre à jour les informations de l'utilisateur
        $adresse->deliv_adresse = $data['deliv_adresse']; // Utilisez $data pour récupérer l'adresse validée
        $adresse->code_postal = $data['code_postal']; // Utilisez $data pour récupérer le code postal validé
        $adresse->ville = $data['ville']; // Utilisez $data pour récupérer la ville
        $adresse->save();

        return back()->with('message', "L'adresse a bien été mise à jour !");
    }

    public function verifierAdresse()
    {
    // Vérifie si l'utilisateur a une adresse de livraison
        if (Auth::user()->delivery_addresses) {
        // Redirige vers index.php si l'utilisateur a une adresse
            return redirect()->route('adresse.index');
        } else {
        // Redirige vers adresse.store si l'utilisateur n'a pas d'adresse
            return redirect()->route('adresse.create');
        }
    }

}
