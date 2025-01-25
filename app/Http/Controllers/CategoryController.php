<?php

namespace App\Http\Controllers;
use App\Models\Category;
//On utilise le modèle puzzle pour recuperer les puzzle et afficher leur spécificités depuis la vue catégories.show
use App\Models\Puzzle;



use Illuminate\Http\Request;

class CategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat = Category::all();
        return view('categories.index', compact('cat'));
    }

    /**
     * Display the specified resource.
     */
    public function show($idCat)
    {
        // Récupère la catégorie avec ses puzzles
        $categorie = Category::with('puzzles')->find($idCat);
        $puzzles = Puzzle::all();

        // Renvoie les puzzles associés à cette catégorie à la vue
        return view('categories.show', ['puzzles' => $categorie->puzzles, 'categories' => $categorie]);
    }

}
