<?php

namespace Tests\Unit;

use App\Models\Puzzle;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PuzzleTest extends TestCase
{
    use RefreshDatabase;

    public function test_puzzle_can_be_created()
    {
        // Ensure there is at least one category in the categories table
        $category = Category::create([
            'libelle' => 'Test Libelle',
            'name' => 'Test Categorie',  // Adjust according to your categories table structure
            'description' => 'Une description',
            'path_image' => 'Path_image',
        ]);

        // Create a puzzle with valid data
        $puzzle = Puzzle::factory()->create([
            'nom' => 'Test Puzzle',
            'categorie_id' => $category->id,  // Use the valid category ID
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'path_image' => 'test_image.png', // Ensure this is the correct field name
        ]);

        $this->assertDatabaseHas('puzzles', [
            'nom' => 'Test Puzzle',
            'categorie_id' => $category->id, // Check the category id
        ]);
    }

    public function test_puzzle_creation_fails_with_missing_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => '',
            'categorie_id' => '',  // Empty categorie_id should fail
            'description' => '',
            'prix' => '',
            'path_image' => '',
        ];

        // Validate manually
        $validator = Validator::make($puzzleData, [
            'nom' => 'required',
            'categorie_id' => 'required|exists:categories,id',  // Validate the foreign key
            'description' => 'required',
            'prix' => 'required|numeric',
            'path_image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData);
    }

    public function test_puzzle_creation_fails_with_invalid_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => str_repeat('A', 256), // Name too long
            'categorie_id' => 1,  // Assuming category exists with id 1
            'description' => 'Ceci est un puzzle de test.',
            'prix' => -5.99, // Negative price
            'path_image' => 'test_image.png', // Ensure correct field name
        ];

        // Validate manually
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|max:255',
            'categorie_id' => 'required|exists:categories,id', // Validate the foreign key
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'path_image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData);
    }

    public function test_puzzle_creation_fails_with_duplicate_data()
    {
        // Ensure there is at least one category in the categories table
        $category = Categories::create([
            'libelle' => 'Test Libelle',
            'name' => 'Test Categorie',  // Adjust according to your categories table structure
            'description' => 'Une description',
            'path_image' => 'Path_image',
        ]);

        $puzzleData = [
            'nom' => 'Unique Puzzle',
            'categorie_id' => $category->id,  // Ensure the valid category ID
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'path_image' => 'test_image.png',
        ];

        // Create the first puzzle
        Puzzle::create($puzzleData);

        $this->expectException(ValidationException::class);

        // Validate manually with the unique rule
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|unique:puzzles,nom',
            'categorie_id' => 'required|exists:categories,id', // Validate the foreign key
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'path_image' => 'required',
        ]);

        $validator->validate();

        // Try creating with the same unique name
        Puzzle::create($puzzleData);
    }
}
