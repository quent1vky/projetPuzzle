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
        if (auth()->check()) {
            // Récupérer les adresses de l'utilisateur connecté uniquement
            $adresse = Adresse::where('user_id', auth()->user()->id)->first();
        } else {
            if (!session()->has('user_id')) {
                // Générer un ID unique pour l'utilisateur non connecté
                session(['user_id' => 1]);  // ID d'un utilisateur non connecté à 0
            }
            // Récupérer l'adresse stockée en session
            $adresse = session()->has('adresse') ? [session('adresse')] : [];
        }
            // Retourner la vue avec les adresses
            return view('adresse.index', compact('adresse'));
    }



    public function edit()
    {
        if (auth()->check()){
            // Récupérer les adresses de l'utilisateur connecté uniquement
            $adresse = Adresse::where('user_id', auth()->user()->id)->first();
        }else{
            if (!session()->has('user_id')) {
                // Générer un ID unique pour l'utilisateur non connecté
                session(['user_id' => null]);  // ID d'un utilisateur non connecté à 0
            }
            // Récupérer l'adresse stockée en session
            $adresse = session()->has('adresse') ? [session('adresse')] : [];
        }
        // Retourner la vue avec les adresses
        return view('adresse.edit', compact('adresse'));
    }

    public function create()
    {
        return view('adresse.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deliv_adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|numeric|digits_between:4,10',
            'adresse_facturation' => 'required|string|max:255',
        ]);

        if (auth()->check()) {
            //Creation d'une adresse'
            $adresse = new Adresse();
            $adresse -> deliv_adresse = $request-> deliv_adresse;
            $adresse->code_postal = $request->code_postal;
            $adresse->ville = $request->ville;
            $adresse-> adresse_facturation = $request-> adresse_facturation;
            $adresse->user_id = Auth::id();
            $adresse->save();
        } else {
            // Utilisateur non connecté : enregistrer l'adresse en session
            session()->put('adresse', [
                'deliv_adresse' => $request->deliv_adresse,
                'code_postal' => $request->code_postal,
                'ville' => $request->ville,
                'adresse_facturation' => $request->adresse_facturation,
            ]);
        }
        return redirect()->route('adresse.index')->with('message', "L'adresse a bien été ajoutée !");
    }


    public function update(Request $request)
    {
        $data = $request->validate([
            // Format des champs requis
            'deliv_adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|numeric|regex:/^\d{5}$/',
            'adresse_facturation' => 'required|string|max:255',
        ], 
        // Message d'erreur en cas de mauvaises saisies
        [
            'deliv_adresse.required' => "L'adresse de livraison est obligatoire.",
            'deliv_adresse.string' => "L'adresse de livraison doit être une chaîne de caractères.",
            'ville.required' => "La ville est obligatoire.",
            'ville.string' => "La ville doit être une chaîne de caractères.",
            'code_postal.required' => "Le code postal est obligatoire.",
            'code_postal.numeric' => "Le code postal doit être un nombre.",
            'code_postal.regex' => "Le code postal doit contenir exactement 5 chiffres.",
            'adresse_facturation.required' => "L'adresse de facturation est obligatoire.",
            'adresse_facturation.string' => "L'adresse de facturation doit être une chaîne de caractères.",
        ]);

        if (auth()->check()){
            // Récupère l'adresse de livraison de l'utilisateur connecté
            $adresse = Adresse::where('user_id', auth()->user()->id)->first();

            // Mettre à jour les informations de l'utilisateur
            $adresse->deliv_adresse = $request->deliv_adresse; // Utilisez $data pour récupérer l'adresse validée
            $adresse->ville = $request->ville; // Utilisez $data pour récupérer la ville
            $adresse->code_postal = $request->code_postal; // Utilisez $data pour récupérer le code postal validé
            $adresse->adresse_facturation = $request->adresse_facturation; // Utilisez $data pour récupérer l'adresse factu
            $adresse->user_id = Auth::id();
            $adresse->save();
        }else{
            // Utilisateur non connecté : mettre à jour l'adresse en session
            session()->put('adresse', [
                'deliv_adresse' => $request->deliv_adresse,
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'adresse_facturation' => $request->adresse_facturation,
            ]);
        }

        return redirect()->route('adresse.index')->with('message', "L'adresse a bien été mise à jour !");
    }

    public function verifierAdresse()
    {
        if (auth()->check()) {
            // Utilisateur connecté : Vérifier s'il a une adresse enregistrée
            $adresse = Adresse::where('user_id', auth()->id())->first();

            if (is_null($adresse)) {
                return redirect()->route('adresse.create');
            } else {
                return redirect()->route('adresse.index');
            }
        } else {
            // Utilisateur non connecté : Vérifier si une adresse est en session
            if (!session()->has('adresse')) {
                return redirect()->route('adresse.create');
            } else {
                return redirect()->route('adresse.index');
            }
        }
    }

}
