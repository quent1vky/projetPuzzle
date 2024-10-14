<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

// importer la façade Auth pour modifier la table user
use Illuminate\Support\Facades\Auth;


class AdresseController extends Controller
{
    public function index()
    {
        return view('adresse.index');
    }


    public function edit()
    {
        return view('adresse.edit');
    }


    public function update(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string|max:255',
            'code_postal' => 'required|string|max:10',
        ]);

        $user = Auth::user()->user;

        // Mettre à jour les informations de l'utilisateur
        $user->address = $data['address']; // Utilisez $data pour récupérer l'adresse validée
        $user->code_postal = $data['code_postal']; // Utilisez $data pour récupérer le code postal validé
        $user->save();

        return back()->with('message', "L'adresse a bien été mise à jour !");
    }
}
