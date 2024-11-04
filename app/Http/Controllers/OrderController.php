<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_products;
// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        $basket = session('basket');
        $total = 0;

        if ($basket) {
            foreach ($basket as $item) {
                $total += $item['prix'] * $item['quantity'];
            }
        }

        return view('paiement.index', compact('basket', 'total'));
    }

    public function transaction()
    {
        return redirect()->route('pdf');
    }

    public function methode()
    {
        return view('paiement.methode');
    }

    public function store(Request $request)
    {

        // On récupère la session basket
        $basket = session('basket');
        $total = 0;
        $articles = [];

        if ($basket) {
            foreach ($basket as $item) {
                $total += $item['prix'] * $item['quantity'];
                $articles[] = [
                    'nom' => $item['nom'],
                    'prix' => $item['prix'],
                    'quantity' => $item['quantity'],
                ];
            }
        }

        $data = $request->validate([
            'type_paiement' => 'required|string|max:255',
            'date_commande' => 'required|string|max:255',
            'methode_paiement' => 'required|string|max:255',
        ]);

        try {
            // Création d'une commande
            $order = new Order();
            $order->type_paiement = $request->type_paiement;
            $order->date_commande = $request->date_commande;
            $order->articles = json_encode($articles); // Convertir le tableau en JSON
            $order->total_prix = $total;
            $order->methode_paiement = $request->methode_paiement;
            $order->user_id = Auth::id();

            $order->save();


            return redirect()->route('paiement.transaction')->with('message', "La commande a bien été ajoutée !");
        } catch (\Exception $e) {
            return back()->withErrors('Erreur lors de la sauvegarde de la commande : ' . $e->getMessage());
        }
    }
}
