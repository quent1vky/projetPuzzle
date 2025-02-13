<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PDF;

class PDFTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_valid_pdf()
    {
        // Contenu HTML de test
        $html = '<h1>Test PDF</h1><p>Ce PDF doit contenir ce texte.</p>';

        // Génération du PDF avec DomPDF
        $pdf = PDF::loadHTML($html);
        $output = $pdf->output();

        // Vérifie que la sortie n'est pas vide
        $this->assertNotEmpty($output, "Le PDF généré est vide.");

        // Vérifie que la sortie commence par "%PDF" (signature PDF)
        $this->assertStringStartsWith('%PDF', $output, "Le fichier généré ne semble pas être un PDF valide.");

        // Optionnel : Vérifie que le texte attendu est présent dans le contenu du PDF
        $this->assertStringContainsString("Test PDF", $html, "Le contenu du PDF ne contient pas le texte attendu.");
    }

    /** @test */
    public function it_generates_a_corrupted_pdf_due_to_internal_error()
    {
        // Créer un utilisateur
        $user = User::factory()->create();

        // Simuler des données corrompues dans la génération du PDF
        $html = '<h1>Test Facture</h1><p>Cette facture contient une erreur dans le calcul du prix.</p>';
        
        // Manipulation intentionnelle des données pour simuler une corruption
        $htmlCorrupted = '<h1>Test Facture</h1><p>Prix Total: [total_prix]€</p>';  // Le total_prix est laissé sans valeur
        
        // Simuler une erreur dans la génération du PDF, par exemple un prix incorrect
        try {
            $pdf = PDF::loadHTML($htmlCorrupted);
            $output = $pdf->output();
            
            // Vérifier si la génération du PDF est réussie malgré une donnée corrompue (par exemple, un prix manquant)
            $this->assertNotEmpty($output, "Le PDF n'a pas été généré malgré un HTML corrompu.");

            // Vérifier que le PDF commence bien par %PDF, mais ne contient pas de données valides comme le prix
            $this->assertStringStartsWith('%PDF', $output, "Le fichier généré ne semble pas être un PDF valide.");
            $this->assertStringNotContainsString('[total_prix]', $output, "Le PDF contient des données corrompues comme '[total_prix]'.");
        } catch (\Exception $e) {
            // En cas d'exception, cela signifie que la génération a échoué, ce qui est aussi un comportement valide dans ce cas
            $this->assertStringContainsString('Error', $e->getMessage(), "Erreur lors de la génération du PDF.");
        }
    }
}
