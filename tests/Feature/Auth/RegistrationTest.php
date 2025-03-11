<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Login;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;


    public function test_new_users_can_register(): void
    {
        // Création de l'utilisateur avec le rôle admin
        $user = User::factory()->create();

        // Création de la connexion associée à l'admin
        $login = Login::factory()->create([
            'user_id' => $user->id, // Associe le login à l'utilisateur créé
        ]);

        // Vérifie que l'utilisateur a bien été inséré dans la base de données
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name, // Vérifie le prénom
            'last_name' => $user->last_name, // Vérifie le nom de famille
            'age' => $user->age, // Vérifie le nom de famille
            'tel' => $user->tel, // Vérifie le nom de famille
        ]);

        // Vérifie que la connexion a bien été insérée dans la table login
        $this->assertDatabaseHas('logins', [
            'user_id' => $user->id, // Vérifie que la connexion est associée à l'utilisateur
        ]);
    }
}
