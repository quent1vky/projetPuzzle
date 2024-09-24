<?php

namespace Tests\Unit;

use App\Models\Puzzle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PuzzleTest extends TestCase
{
    use RefreshDatabase;

    public function test_puzzle_can_be_created()
    {
        $puzzle = Puzzle::factory()->create([
            'nom' => 'Test Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'image' => 'test_image.png', // Ajouter le champ image
        ]);

        $this->assertDatabaseHas('puzzles', [
            'nom' => 'Test Puzzle',
        ]);
    }

    public function test_puzzle_creation_fails_with_missing_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => '',
            'categorie' => '',
            'description' => '',
            'prix' => '',
            'image' => '', // Ajouter le champ image
        ];

        // Valider les données manuellement
        $validator = Validator::make($puzzleData, [
            'nom' => 'required',
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric',
            'image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData);
    }

    public function test_puzzle_creation_fails_with_invalid_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => str_repeat('A', 256), // Nom trop long
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => -5.99, // Prix négatif
            'image' => 'test_image.png', // Ajouter le champ image
        ];

        // Valider les données manuellement
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|max:255',
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'required',
        ]);

        $validator->validate();
    }

    public function test_puzzle_creation_fails_with_duplicate_data()
    {
        $puzzleData = [
            'nom' => 'Unique Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'image' => 'test_image.png',
        ];
    
        // Créer le premier puzzle avec des données uniques
        Puzzle::create($puzzleData);
    
        // Tenter de créer un deuxième puzzle avec le même nom unique
        $this->expectException(ValidationException::class);
    
        // Valider les données manuellement avec la règle d'unicité
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|unique:puzzles,nom',  // Règle d'unicité sur 'nom'
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'required',
        ]);
    
        // Le deuxième puzzle ne devrait pas être créé
        $validator->validate();
    }

    public function test_puzzle_can_be_read()
    {
        $puzzle = Puzzle::factory()->create([
            'nom' => 'Test Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
        ]);

    $foundPuzzle = Puzzle::find($puzzle->id);
    }

    public function test_puzzle_can_be_updated()
    {
        $puzzle = Puzzle::factory()->create();
    
        $puzzle->nom = 'Nom mis à jour';
        $puzzle->save();
    }

    public function test_puzzle_can_be_deleted()
    {
        $puzzle = Puzzle::factory()->create();

        $puzzle->delete();
    }

    

    
}
