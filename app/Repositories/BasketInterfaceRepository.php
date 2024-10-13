<?php

namespace App\Repositories;

use App\Models\Puzzle;

interface BasketInterfaceRepository {

	// Afficher le panier
	public function index();

	// Ajouter un produit au panier
	public function store (Puzzle $puzzle, Request $request);

	// Retirer un produit du panier
	public function edit (Puzzle $puzzle);

	// Vider le panier
    public function destroy ();

}

?>
