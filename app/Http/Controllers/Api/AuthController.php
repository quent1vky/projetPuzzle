<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Validator;

class AuthController extends Controller
{
    /* Pour tester depuis Postman :
        Méthode POST : http://127.0.0.1:8000/api/authentificate
        Body :
        {
            "email": "e@e",
            "password": "abcdefgh"
        }
    */
    public function authenticate(Request $request)
    {
        // Limiter les tentatives de connexion
        $maxAttempts = 5;
        $decayMinutes = 1;
        $key = 'login_attempts_' . $request->ip();

        // Vérifier si l'utilisateur a dépassé le nombre de tentatives
        if (Cache::has($key) && Cache::get($key) >= $maxAttempts) {
            return response()->json(['error' => 'Vous avez tenter trop de fois.'], 429);
        }

        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Cherche l'utilisateur dans la table logins
        $login = Login::where('email', $request->email)->first();

        // Vérifie si l'utilisateur existe
        if (!$login) {
            // Augmenter le compteur de tentatives échouées
            Cache::increment($key);
            if (Cache::get($key) == 1) {
                Cache::put($key, 1, $decayMinutes * 60); // Stocker pendant 1 minute
            }
            return response()->json(['error' => 'User not found'], 404);
        }

        // Vérifie si le mot de passe est correct
        if (Hash::check($request->password, $login->password)) {
            // Authentification réussie, renvoyer les informations de l'utilisateur
            return response()->json($login);
        } else {
            // Mot de passe incorrect, augmenter le compteur de tentatives échouées
            Cache::increment($key);
            if (Cache::get($key) == 1) {
                Cache::put($key, 1, $decayMinutes * 60); // Stocker pendant 1 minute
            }
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
