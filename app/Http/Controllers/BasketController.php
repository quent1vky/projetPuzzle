<?php


namespace App\Http\Controllers;

use App\Models\Puzzle; // Assure-toi que Puzzle est aussi importé
use App\Models\Basket; // Importation du modèle Basket
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class BasketController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            // Utilisateur connecté : récupérer les éléments du panier avec la relation puzzle
            $basket = Basket::with('puzzle')->where('user_id', auth()->id())->get();
        } else {
            // Utilisateur non connecté : Créer un identifiant utilisateur unique pour la session
            if (!session()->has('user_id')) {
                // Générer un ID unique pour l'utilisateur non connecté
                session(['user_id' => -1]);  // L'ID attribué à l'user est -1
            }

            // Utilisateur non connecté : récupérer les éléments du panier depuis la session
            $basketSession = session()->get('basket', []);
            $basket = collect(); // Utiliser une collection pour uniformiser

            foreach ($basketSession as $puzzleId => $data) {
                $basket->push((object) [ // Utiliser ->push() pour créer une collection comme Eloquent
                    'id' => $puzzleId,
                    'puzzle' => (object) [
                        'id' => $puzzleId,
                        'nom' => $data['nom'],
                        'prix' => $data['prix'],
                        'path_image' => $data['path_image'],
                    ],
                    'quantity' => $data['quantity']
                ]);
            }
        }

        return view('basket.index', compact('basket'));
    }



    // Ajouter/Mettre à jour un produit dans le panier
    public function store(Request $request, Puzzle $puzzle)
    {
        $quantity = $request->input('quantity', 1);

        if (auth()->check()) {
            // Utilisateur connecté : Enregistrer dans la base de données
            $basketItem = Basket::updateOrCreate(
                ['user_id' => Auth::id(), 'puzzle_id' => $puzzle->id],
                ['quantity' => $quantity]
            );
        } else {
            // Utilisateur non connecté : Enregistrer dans la session
            $basket = session()->get('basket', []);
            $basket[$puzzle->id] = [
                'nom' => $puzzle->nom,
                'prix' => $puzzle->prix,
                'quantity' => $quantity,
                'path_image' => $puzzle->path_image
            ];
            session()->put('basket', $basket);
        }

        return back()->with('message', 'Produit ajouté au panier !');
    }

    // Retirer un produit du panier
    public function destroy(Puzzle $puzzle)
    {
        if (auth()->check()) {
            // Utilisateur connecté : Supprimer de la base de données
            Basket::where('user_id', auth()->id())->where('puzzle_id', $puzzle->id)->delete();
        } else {
            // Utilisateur non connecté : Supprimer de la session
            $basket = session()->get('basket', []);
            unset($basket[$puzzle->id]);
            session()->put('basket', $basket);
        }

        return redirect()->route('basket.index');
    }

    // Vider le panier
    public function clear()
    {
        if (auth()->check()) {
            // Utilisateur connecté : Vider la base de données
            Basket::where('user_id', auth()->id())->delete();
        } else {
            // Utilisateur non connecté : Vider la session
            session()->forget('basket');
        }

        return redirect()->route('basket.index');
    }
}



