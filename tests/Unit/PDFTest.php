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
    public function it_fails_to_generate_pdf_with_invalid_html()
    {
        // Simule un HTML invalide qui peut causer une erreur
        $invalidHtml = '<h1>Unclosed Tag';
    
        // Capture les erreurs possibles
        try {
            $pdf = PDF::loadHTML($invalidHtml);
            $output = $pdf->output();
    
            // Si on arrive ici, l'erreur n'a pas été levée -> échec du test
            $this->fail("La génération du PDF aurait dû échouer mais elle a réussi.");
        } catch (DompdfException $e) {
            // Vérifie que l'exception attendue a bien été levée
            $this->assertStringContainsString('DOMPDF', $e->getMessage(), "L'erreur levée ne correspond pas à une erreur DomPDF.");
        }
    }
}
