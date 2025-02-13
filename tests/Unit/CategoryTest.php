<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test the show method for a category.
     *
     * @return void
     */
    public function test_it_displays_a_category(): void
    {
        // Créer une catégorie fictive dans la base de données
        $category = Category::factory()->create([
            'libelle' => 'Categorie1',
            'description' => 'Une catégorie dédiée aux puzzles.',
            'path_image' => 'images/puzzles.jpg',
        ]);

        // Effectuer une requête GET pour afficher cette catégorie
        $response = $this->get(route('categories.index', $category->id));

        // Vérifier que la réponse est correcte (200 OK)
        $response->assertStatus(200);

        // Vérifier que les données de la catégorie sont présentes dans la vue
        $response->assertSee($category->libelle);
        $response->assertSee($category->description);
        $response->assertSee($category->path_image);
    }



        /**
     * Test the show method for a category.
     *
     * @return void
     */
    public function test_it_cant_create_a_corrupt_category(): void
    {
        // Créer une catégorie fictive dans la base de données
        $category = Category::factory()->create([
            'libelle' => '', //libelle vide est invalide
            'description' => 'Une catégorie dédiée aux puzzles.',
            'path_image' => 'images/puzzles.jpg',
        ]);

        // Effectuer une requête GET pour afficher cette catégorie
        $response = $this->post(route('categories.store'));

        // Vérifier que la réponse est incorrecte (500)
        $response->assertStatus(302);
    }
}
