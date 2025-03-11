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
    public function test_it_creates_a_category(): void
    {
        // Genere une categorie valide
        $category = Category::factory()->make([
            'path_image' => 'images/puzzles.jpg', // Ensure it does not exceed 100 characters
        ])->toArray();

        // envoie une requete post pour creer une categorie
        $response = $this->post(route('categories.store'), $category);

        // Verifie la reponse de redirection
        $response->assertRedirect();

        // Verifier que la categorie a été inseré dans la bdd
        $this->assertDatabaseHas('categories', $category);
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
