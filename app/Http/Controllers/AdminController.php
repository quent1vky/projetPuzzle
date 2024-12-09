<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;




class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function edit($id)
    {
        // Récupérer la commande spécifique par son ID
        $orders = Order::findOrFail($id);

        // Les articles sont automatiquement décodés si le champ est de type JSON
        $articles = json_decode($orders->articles, true);

        // Passer la commande à la vue
        return view('admin.edit', ['o' => $orders, 'articles' => $articles]);
    }


    public function update(Request $request, $id)
    {
        // Validation des données : uniquement pour le statut de la commande
        $data = $request->validate([
            'statut_commande' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);

        // Mise à jour du champ 'statut_commande'
        $order->statut_commande = $request->statut_commande;

        // Sauvegarde de la commande modifiée
        $order->save();

        return redirect()->route('admin.index')->with('message', "Le statut de la commande a été modifié avec succès !");
    }



}
