<?php

namespace App\Repositories;

use App\Models\Puzzle;

class BasketSessionRepository implements BasketInterfaceRepository  {

	# Afficher le panier
	public function index() {
		return view("basket.index"); // resources\views\basket\index.blade.php
	}

	# Ajouter/Mettre à jour un produit du panier
	public function store (Puzzle $puzzle, $quantity) {
		$basket = session()->get("basket"); // On récupère le panier en session

		// Les informations du produit à ajouter
		$puzzle_details = [
			'nom' => $puzzle->nom,
			'prix' => $puzzle->prix,
			'quantity' => $quantity,
            'path_image' => $puzzle->path_image
		];

		$basket[$puzzle->id] = $puzzle_details; // On ajoute ou on met à jour le produit au panier
		session()->put("basket", $basket); // On enregistre le panier
	}

	# Retirer un produit du panier
	public function edit (Puzzle $puzzle) {
		$basket = session()->get("basket"); // On récupère le panier en session
		unset($basket[$puzzle->id]); // On supprime le produit du tableau $basket
		session()->put("basket", $basket); // On enregistre le panier
	}

	# Vider le panier
	public function destroy () {
		session()->forget("basket"); // On supprime le panier en session
	}

}
