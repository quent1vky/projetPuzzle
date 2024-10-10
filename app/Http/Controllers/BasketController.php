<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasketController extends Controller
{

    protected $basketRepository; // L'instance BasketSessionRepository

    public function __construct (BasketInterfaceRepository $basketRepository) {
    	$this->basketRepository = $basketRepository;
    }


    public function index()
    {
        return view("basket.index");
    }


    public function show(Basket $basket){
        return view('basket.show', compact('basket')); // Passer le puzzle à la vue
    }

    # Ajouter/Mettre à jour un produit du panier
	public function store (Puzzle $puzzle, $quantity) {
		$basket = session()->get("basket"); // On récupère le panier en session

		// Les informations du produit à ajouter
		$puzzle_details = [
			'name' => $puzzle->nom,
			'price' => $puzzle->prix,
			'quantité' => $quantity
		];

		$basket[$puzzle->id] = $puzzle_details; // On ajoute ou on met à jour le produit au panier
		session()->put("basket", $basket); // On enregistre le panier
        return back()->withMessage("Produit ajouté au panier");
	}

    # Retirer un produit du panier
	public function destroy (Puzzle $puzzle) {
		$basket = session()->get("basket"); // On récupère le panier en session
		unset($basket[$product->id]); // On supprime le produit du tableau $basket
		session()->put("basket", $basket); // On enregistre le panier
        return back()->withMessage("Produit retiré du panier");
	}

	# Vider le panier
	public function empty () {
		session()->forget("basket"); // On supprime le panier en session
        return back()->withMessage("Panier vidé");
	}

}


