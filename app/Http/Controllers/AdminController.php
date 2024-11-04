<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;




class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function edit(Order $orders)
    {
        return view('admin.edit', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'type_paiement' => 'required|string|max:255', // Par exemple, chaîne de caractères requise, max 255 caractères
            'date_commandes' => 'required|date', // Doit être une date
            'articles' => 'required|string', // Si les articles sont stockés sous forme de texte
            'total_prix' => 'required|numeric', // Doit être un nombre
            'methode_paiement' => 'required|string|max:255', // Méthode de paiement en chaîne de caractères
            'statut_commande' => 'required|string|max:255', // Statut de commande en chaîne de caractères
        ]);
        $order->type_paiement = $request->type_paiement; // Utilisez $data pour récupérer l'adresse validée
        $order->date_commandes = $request->date_commandes; // Utilisez $data pour récupérer l'adresse validée
        $order->articles = $request->articles; // Utilisez $data pour récupérer l'adresse validée
        $order->total_prix = $request->total_prix; // Utilisez $data pour récupérer l'adresse validée
        $order->methode_paiement = $request->methode_paiement; // Utilisez $data pour récupérer l'adresse validée
        $order->statut_commande = $request->statut_commande; // Utilisez $data pour récupérer l'adresse validée

        $order->save();

        return redirect()->route('admin.index')->with('message', "L'adresse a bien été mise à jour !");
    }

}
