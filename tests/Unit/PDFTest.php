<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PDFTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_pdf_for_the_last_order()
    {
        // Créez un utilisateur fictif
        $user = User::factory()->create();

        // Créez une commande pour cet utilisateur
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);

        // Connectez l'utilisateur
        $this->actingAs($user);

        // Simulez la requête pour générer le PDF
        $response = $this->get(route('pdf.generate'));  // Assurez-vous que la route existe

        // Vérifiez que la réponse est un fichier PDF
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="facture.pdf"');

        // Vous pouvez également vérifier si le fichier existe dans la réponse (si nécessaire)
        $response->assertSuccessful();
    }
}
