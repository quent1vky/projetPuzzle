<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer uniquement la dernière commande de l'utilisateur
        $order = Order::where('user_id', $user->id)->latest()->first();

        $pdf = PDF::loadView('pdf.view', ['order' => $order]);
        return $pdf->download('facture.pdf');
    }

}
