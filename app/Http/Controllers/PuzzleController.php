<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Puzzle;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puzzles = Puzzle::all();
        return view('puzzles.index', compact('puzzles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('puzzles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'nom' => 'required|max:100',
            'categorie' => 'required|max:500',
            'description' => 'required|max:500',
            'image' => 'required|max:100',
            'prix' => 'required|numeric|between:0,99.99',
        ]);


        //Creation du puzzle
        $puzzle = new Puzzle();
        $puzzle->nom = $request->nom;
        $puzzle->categorie = $request->categorie;
        $puzzle->description = $request->description;
        $puzzle->image = $request->image;
        $puzzle->prix = $request->prix;
        $puzzle->save();
        return back()->with('message', "Le puzzle a bien été crée !");
    }

    /**
     * Display the specified resource.
     */
    public function show(Puzzle $puzzle)
    {
        return view('puzzles.show', compact('puzzle')); // Passer le puzzle à la vue
    }

    /**
     * Show the form to edit the specified resource
     */
    public function edit(Puzzle $puzzle)
    {
        return view('puzzles.edit',compact('puzzle'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Puzzle $puzzle)
    {
        $data = $request->validate([
            'nom' => 'required|max:100',
            'description' => 'required|max:500',
            'path_mage' => 'required|max:500',
            'prix' => 'required|numeric|between:0,99.99',
            'categorie_id' => 'required|exists:categories,id', // Verifier que la catégorie existe
        ]);
        $puzzle->nom = $request->nom;
        $puzzle->description = $request->description;
        $puzzle->path_image = $request->path_image;
        $puzzle->prix = $request->prix;
        $puzzle->categorie_id = $request->categorie_id;
        $puzzle->save();
        return back()->with('message', "Le puzzle a bien été mis à jour !");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Puzzle $puzzle)
    {
        $puzzle -> delete();
        return back()->with('message', "Le puzzle a bien supprimé !");
    }
}


