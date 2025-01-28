<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Adresse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdresseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_the_user_address()
    {
        // Créez un utilisateur fictif
        $user = User::factory()->create();

        // Créez une adresse pour cet utilisateur
        $adresse = Adresse::factory()->create([
            'user_id' => $user->id,
        ]);

        // Connectez l'utilisateur
        $this->actingAs($user);

        // Données de mise à jour
        $updatedData = [
            'deliv_adresse' => 'Nouvelle adresse de livraison',
            'ville' => 'Paris',
            'code_postal' => '75001',
            'adresse_facturation' => 'Adresse de facturation mise à jour',
        ];

        // Simulez la requête pour mettre à jour l'adresse
        $response = $this->put(route('adresse.update', $adresse->id), $updatedData);

        // Vérifiez que la réponse redirige vers la page des adresses
        $response->assertRedirect(route('adresse.index'));

        // Vérifiez que l'adresse a bien été mise à jour dans la base de données
        $this->assertDatabaseHas('delivery_addresses', [
            'id' => $adresse->id,
            'deliv_adresse' => $updatedData['deliv_adresse'],
            'ville' => $updatedData['ville'],
            'code_postal' => $updatedData['code_postal'],
            'adresse_facturation' => $updatedData['adresse_facturation'],
        ]);
    }
 
    /** @test 
    public function it_does_not_update_other_users_address()
    {
        // Créez deux utilisateurs
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Créez une adresse pour l'utilisateur
        $adresse = Adresse::factory()->create([
            'user_id' => $user->id,
        ]);

        // Connectez l'autre utilisateur
        $this->actingAs($otherUser);

        // Données de mise à jour
        $updatedData = [
            'deliv_adresse' => 'Nouvelle adresse',
            'ville' => 'Lyon',
            'code_postal' => '69001',
            'adresse_facturation' => 'Nouvelle adresse de facturation',
        ];

        // Tentez de mettre à jour l'adresse de l'autre utilisateur
        $response = $this->put(route('adresse.update', $adresse->id), $updatedData);

        // Vérifiez que la réponse redirige vers la page des adresses
        $response->assertRedirect(route('adresse.index'));

        // Vérifiez que l'adresse de l'autre utilisateur n'a pas été mise à jour
        $this->assertDatabaseMissing('delivery_addresses', [
            'id' => $adresse->id,
            'deliv_adresse' => $updatedData['deliv_adresse'],
        ]);
    }
        */
}
