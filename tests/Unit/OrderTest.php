<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\Puzzle; // Assurez-vous d'importer le modèle Puzzle (ou un modèle de produit similaire)
use App\Models\Basket; // Assurez-vous d'importer le modèle Basket si vous l'utilisez
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the store method to create an order.
     *
     * @return void
     */
    public function test_store_order()
    {
        // Arrange: Préparer l'utilisateur et les produits (par exemple les puzzles)
        $user = User::factory()->create();
        $puzzle1 = Puzzle::factory()->create();
    
        // Agir: Se connecter en tant que cet utilisateur
        $this->actingAs($user);
    
        // Vérifier que l'utilisateur est bien authentifié
        $this->assertTrue(auth()->check(), "L'utilisateur n'est pas authentifié.");
    
        // Créer un panier pour l'utilisateur avec des articles
        Basket::factory()->create([
            'user_id' => $user->id,
            'puzzle_id' => $puzzle1->id, // Puzzle 1 dans le panier
            'quantity' => 2
        ]);
    
        // Vérifier que l'article a bien été ajouté au panier
        $this->assertDatabaseHas('baskets', [
            'user_id' => $user->id,
            'puzzle_id' => $puzzle1->id,
            'quantity' => 2
        ]);
    
        // Act: Effectuer une requête POST à la route de stockage pour créer la commande
        $response = $this->post(route('paiement.store'), [
            'type_paiement' => 'Credit Card',
            'methode_paiement' => 'Stripe',
        ]);
    
        // Vérifiez que la réponse a un statut de succès (200 OK)
        // Ici, on s'attend à une redirection (302) en cas de succès et non pas un code 200.
        // Donc, on vérifie d'abord si c'est une redirection.
        $response->assertStatus(302);
    
        // Vérifiez que la commande a bien été créée
        $order = Order::latest()->first();
        $this->assertNotNull($order);  // Vérifier que la commande a bien été créée
    
        // Décoder les articles depuis le champ 'articles' (qui est encodé en JSON)
        $articles = json_decode($order->articles, true); // true pour obtenir un tableau associatif
    
        // Vérifiez que la commande a bien les bons articles
        $this->assertCount(1, $articles);  // Le panier contient 1 article (puzzle)
    
        // Vérifiez que les articles du panier sont supprimés après la commande
        $this->assertDatabaseMissing('baskets', [
            'user_id' => $user->id,
        ]);
    }

    public function test_cant_store_corrupt_order()
    {
        // Arrange: Préparer l'utilisateur et les puzzles
        $user = User::factory()->create();
        $puzzle1 = Puzzle::factory()->create();
        
        // Se connecter en tant que cet utilisateur
        $this->actingAs($user);
        
        // Vérifier que l'utilisateur est bien authentifié
        $this->assertTrue(auth()->check(), "L'utilisateur n'est pas authentifié.");
        
        // Créer un panier pour l'utilisateur avec un 'user_id' incorrect
        $basket = Basket::factory()->create([
            'user_id' => $user->id,  // user_id est nul, ce qui est une donnée corrompue
            'puzzle_id' => $puzzle1->id,
            'quantity' => 2
        ]);
        
        // Act: Essayer de créer une commande avec des données invalides
        $response = $this->post(route('paiement.store'), [
            'type_paiement' => '',  // type_paiement vide (champ requis)
            'methode_paiement' => 'Stripe',
        ]);
    
        // Assert: Vérifiez que la réponse contient une erreur de validation
        // Le code de statut attendu doit être 302 (redirige vers la page précédente avec les erreurs)
        $response->assertStatus(302);
        
        // Vérifiez que des erreurs de validation sont présentes dans la session
        $response->assertSessionHasErrors('type_paiement');
        
        // Vérifier que la commande n'a pas été créée dans la base de données
        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
            'type_paiement' => '',  // La commande ne doit pas être enregistrée avec un type_paiement vide
        ]);
        
        // Vérifiez que l'article du panier n'a pas été supprimé (la commande n'a pas été créée)
        $this->assertDatabaseHas('baskets', [
            'user_id' => $user->id, // le panier avec un user_id nul devrait toujours exister dans la table baskets
            'puzzle_id' => $puzzle1->id,
        ]);
    }
     
}