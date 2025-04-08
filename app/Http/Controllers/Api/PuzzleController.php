<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Puzzle;
use Illuminate\Support\Facades\Validator;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.jkyhtgu-yt
     */
    public function index()
    {
        $puzzles = Puzzle::all();
        return response()->json($puzzles);  // Retourner les données filtrées en JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Valider les données de la requête
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'path_image' => 'required|string|max:255',
        'prix' => 'required|numeric|between:0,99.99',
        'stock' => 'required|integer|min:0', // Ajout de la validation pour stock
        'categorie_id' => 'required|exists:categories,id', // Vérifier que la catégorie existe
    ]);

    // Si la validation échoue, retourner les erreurs
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'erreur' => $validator->errors()
        ], 422); // Code de statut 422 pour une validation échouée
    }

    try {
        // Créer un nouveau puzzle avec les données validées
        $puzzle = Puzzle::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'path_image' => $request->path_image,
            'prix' => $request->prix,
            'stock' => $request->stock, // Ajout de stock
            'categorie_id' => $request->categorie_id,
            // Ajoute d'autres attributs ici si nécessaire
        ]);


        // Retourner la ressource nouvellement créée
        return response()->json([
            'success' => true,
            'message' => 'Puzzle créé avec succès',
            'données' => $puzzle
        ], 201); // Code de statut 201 pour indiquer la création
    } catch (\Exception $e) {
        // Retourner une erreur en cas d'exception
        return response()->json([
            'success' => false,
            'erreur' => 'Erreur lors de la création du puzzle : ' . $e->getMessage(),
        ], 500); // Code de statut 500 pour une erreur serveur
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $puzzle = Puzzle::findOrFail($id);
        return response()->json($puzzle); // Renvoie l'objet complet
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Valider les données envoyées
    $validator = Validator::make($request->all(), [
        'nom' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'path_image' => 'nullable|string',
        'prix' => 'nullable|numeric',
        'categorie_id' => 'nullable|exists:categories,id',
        'stock' => 'nullable|integer|min:0', // ✅ Seul stock doit être un entier positif
    ]);

    // Si la validation échoue, retourner les erreurs
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Récupérer le puzzle à mettre à jour
    $puzzle = Puzzle::findOrFail($id);

    // Mettre à jour uniquement les champs envoyés
    $dataToUpdate = $request->only(['nom', 'description', 'path_image', 'prix', 'categorie_id', 'stock']);

    // Mise à jour du puzzle
    $puzzle->update($dataToUpdate);

    // Vérifier si le stock est bas après mise à jour
    $lowStockThreshold = 5; // Seuil pour stock bas

    // Si le stock est inférieur ou égal au seuil, on envoie une alerte
    if ($puzzle->stock <= $lowStockThreshold) {
        return response()->json([
            'success' => true,
            'message' => 'Puzzle mis à jour avec succès, mais attention, le stock est bas !',
            'data' => $puzzle,
            'alert' => 'Stock faible ! Pensez à réapprovisionner.' // ⚠️ Alerte ajoutée
        ], 200);
    }

    // Si tout va bien (pas de stock bas), retourner simplement la réponse
    return response()->json([
        'success' => true,
        'message' => 'Mise à jour effectuée avec succès',
        'data' => $puzzle
    ], 200);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $puzzles = Puzzle::findOrFail($id);
        $puzzles->delete();
        return response()->json([
            'success' => true,
            'message' => 'Le Puzzle a été supprimé'
        ], 200); //code statut 200 pour indiquer le succès
    }




}
