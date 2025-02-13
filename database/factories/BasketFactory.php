<?php

namespace Database\Factories;

use App\Models\Basket;
use App\Models\User;
use App\Models\Puzzle;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketFactory extends Factory
{
    protected $model = Basket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Crée un utilisateur aléatoire
            'puzzle_id' => Puzzle::factory(), // Crée un produit (puzzle) aléatoire
            'quantity' => $this->faker->numberBetween(1, 5), // Quantité aléatoire entre 1 et 5
        ];
    }
}
