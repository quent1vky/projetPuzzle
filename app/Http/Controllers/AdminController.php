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

    public function edit($id)
    {
        $order = Order::findOrFail($id); // Trouver la commande avec l'ID donné
        return view('admin.edit', compact('order')); // Passer l'objet `order` à la vue
    }

    public function update(Request $request, Order $order)
    {
        // Validation des données du formulaire
        $data = $request->validate([
            'type_paiement' => 'required|string|max:255',
            'date_commande' => 'required|date',
            'articles' => 'required|string',
            'total_prix' => 'required|numeric',
            'methode_paiement' => 'required|string|max:255',
            'statut_commande' => 'required|string|max:255',
        ]);

        // Mise à jour de l'objet $order avec les données validées
        $order->update([
            'type_paiement' => $request->type_paiement,
            'date_commande' => $request->date_commande, // Assurez-vous de la bonne orthographe du champ
            'articles' => $request->articles,
            'total_prix' => $request->total_prix,
            'methode_paiement' => $request->methode_paiement,
            'statut_commande' => $request->statut_commande,
            'user_id' => Auth::id(), // Utilise `Auth::id()` pour récupérer l'ID de l'utilisateur connecté
        ]);

        // Redirection après la mise à jour
        return redirect()->route('admin.index')->with('message', "La commande a bien été mise à jour !");
    }


}
