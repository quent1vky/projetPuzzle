<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_products;
use App\Models\Puzzle;
use App\Models\Basket;

// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            // Utilisateur connecté : récupérer les éléments du panier avec la relation puzzle
            $basket = Basket::with('puzzle')->where('user_id', auth()->id())->get();

            // Si nécessaire, vous pouvez manipuler les données pour ajouter des informations supplémentaires
            // ou calculer des totaux pour la vue.
            $totalP = $basket->reduce(function ($total, $item) {
                return $total + ($item->puzzle->prix * $item->quantity);
            }, 0);

        } else {
            // Utilisateur non connecté : récupérer les éléments du panier depuis la session
            $basketSession = session()->get('basket', []);
            $basket = collect(); // Utiliser une collection pour uniformiser la structure des données

            // Créer une collection d'objets à partir des données de la session
            foreach ($basketSession as $puzzleId => $data) {
                $basket->push((object) [
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

            // Calculer le total général du panier pour un utilisateur non connecté
            $totalP = $basket->sum(function ($item) {
                return $item->puzzle->prix * $item->quantity;
            });
        }

        // Retourner la vue du récapitulatif avec toutes les informations nécessaires
        return view('paiement.index', compact('basket', 'totalP'));
    }



    public function transaction()
    {
        return view('paiement.transaction');
    }

    public function store(Request $request)
    {
        if(auth()->check()){
            // Récupérer les articles dans le panier pour cet utilisateur
            $elemPanier = Basket::with('puzzle')->where('user_id', Auth::id())->get();
        }else {
            // Si l'utilisateur n'est pas connecté, récupérer les articles depuis la session
            $elemPanier = collect(session('basket', []));
        }

        // Calculer le total et préparer les articles
        $total = 0;
        $articles = [];

        foreach ($elemPanier as $id => $item) {
            if (auth()->check()) {
                // Pour un utilisateur connecté, les articles viennent de la BDD
                $articles[] = [
                    'id' => $item->puzzle->id,
                    'nom' => $item->puzzle->nom,
                    'prix' => $item->puzzle->prix,
                    'quantity' => $item->quantity
                ];
                $total += $item->puzzle->prix * $item->quantity;
            } else {
                // Pour un utilisateur non connecté, les articles viennent de la session
                $articles[] = [
                    'id' => $id,
                    'nom' => $item['nom'],
                    'prix' => $item['prix'],
                    'quantity' => $item['quantity']
                ];
                $total += $item['prix'] * $item['quantity'];
            }
        }

        // Valider les données de la commande
        $data = $request->validate([
            'type_paiement' => 'required|string|max:255',
            'methode_paiement' => 'required|string|max:255',
        ]);

        try {
            // Créer une nouvelle commande
            $order = new Order();
            $order->type_paiement = $data['type_paiement'];
            $order->date_commande = now(); // Date de la commande
            $order->articles = json_encode($articles); // Encodage JSON des articles
            $order->total_prix = $total;
            $order->methode_paiement = $data['methode_paiement'];
            $order->statut_commande = 0; // Statut par défaut : en attente
            // Si l'utilisateur est connecté, on utilise son ID
            if (auth()->check()) {
                $order->user_id = Auth::id(); // ID de l'utilisateur connecté
            } else {
                // Si l'utilisateur n'est pas connecté, on utilise un identifiant unique pour l'anonyme
                $order->user_id = session('user_id', 1); // ID null pour user non connecté
            }

            // Sauvegarder la commande dans la base de données
            $order->save();


            if (auth()->check()){
                Basket::where('user_id', Auth::id())->delete();
            }else{
                session()->forget('basket');
            }

            if (auth()->check()){
                // Rediriger vers une page de confirmation ou de paiement
                return redirect()->route('pdf');
            }else{
                return redirect()->route('paiement.transaction')->with('message', "La commande a été enregistrée avec succès ! Vous serez redirigé sur la page d'accueil dans 3 secondes");              
            }
        } catch (\Exception $e) {
            return back()->withErrors('Erreur lors de la sauvegarde de la commande : ' . $e->getMessage());
        }
    }


}
