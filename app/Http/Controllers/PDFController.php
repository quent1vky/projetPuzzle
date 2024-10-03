<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data_test = ['title' => 'Bienvenue dans le générateur de PDF Laravel !'];
        $pdf = PDF::loadView('pdf.view', $data_test);

        return $pdf->download('document.pdf');
    }
}
