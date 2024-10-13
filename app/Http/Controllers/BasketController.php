<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puzzle;
use App\Repositories\BasketInterfaceRepository;
use App\Repositories\BasketSessionRepository;

class BasketController extends Controller
{

	protected $basketRepository; // L'instance BasketSessionRepository

    public function __construct (BasketInterfaceRepository $basketRepository) {
    	$this->basketRepository = $basketRepository;
    }

    # Affichage du panier
    public function index () {
    	return view("basket.index"); // resources\views\basket\show.blade.php
    }

    # Ajout d'un produit au panier
    public function store (Puzzle $puzzle, Request $request) {
        $this->validate($request, [
            "quantity" => "numeric|min:1"
        ]);
        $this->basketRepository->store($puzzle, $request->quantity);
        return redirect()->route("basket.index")->withMessage("Produit ajouté au panier");
    }

    // Suppression d'un produit du panier
    public function edit (Puzzle $puzzle) {

    	// Suppression du produit du panier par son identifiant
    	$this->basketRepository->edit($puzzle);

    	// Redirection vers le panier
    	return back()->withMessage("Produit retiré du panier");
    }

    // Vider la panier
    public function destroy () {

    	// Suppression des informations du panier en session
    	$this->basketRepository->empty();

    	// Redirection vers le panier
    	return back()->withMessage("Panier vidé");

    }

};


