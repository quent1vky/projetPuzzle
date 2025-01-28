<?php

namespace Tests\Unit;

use App\Http\Controllers\PuzzleController;
use App\Models\Category;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Tests\TestCase;

class PuzzleTest extends TestCase
{
    public function test_store_creates_a_puzzle()
    {
        // Créez une catégorie avec une factory pour l'associer au puzzle
        $category = Category::factory()->create();

        // Simulez une instance de la requête
        $request = new Request([
            'nom' => 'Nouveau Puzzle',
            'description' => 'Description test',
            'path_image' => 'image.png',
            'prix' => 19.99,
            'categorie_id' => $category->id,
        ]);

        // Instanciez le contrôleur
        $controller = new PuzzleController();

        // Appelez la méthode 'store' du contrôleur en lui passant la requête simulée
        $response = $controller->store($request);

        // Vérifiez que le puzzle a été ajouté à la base de données
        $this->assertDatabaseHas('puzzles', [
            'nom' => 'Nouveau Puzzle',
            'categorie_id' => $category->id,
        ]);
    }
}

