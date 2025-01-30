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


    public function update(Request $request)
    {
        // Vérifie que la requête contient bien un statut
        $request->validate([
            'statut_commande' => 'required',
        ]);

        // Récupère la commande à partir de l'ID envoyé
        $order = Order::find($request->order_id);

        if (!$order) {
            return redirect()->route('admin.index')->with('message', 'Commande introuvable');
        }

        // Met à jour le statut
        $order->statut_commande = $request->statut_commande;
        $order->save();

        return redirect()->route('admin.index')->with('message', 'Commande mise à jour avec succès');
    }



}
