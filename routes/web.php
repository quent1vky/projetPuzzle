<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\AdresseController;
use App\Http\Controllers\OrderController;


use App\Models\Puzzle;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});


// Route du dashboard accessible à tous
Route::get('/dashboard', function () {
    // Récupérer 4 puzzles
    $puzzles = Puzzle::all();
    if (Auth::check()) {
        // Utilisateur connecté, afficher son tableau de bord personnel avec les puzzles
        return view('dashboard', [
            'user' => Auth::user(),
            'puzzles' => $puzzles
        ]);
    } else {
        // Utilisateur non connecté, afficher une version limitée du dashboard avec les puzzles
        return view('dashboard', [
            'user' => null,
            'puzzles' => $puzzles
        ]);
    }
})->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//gérer toutes les routes de puzzle ==> l'utilisateur n'a pas besoin d'être connecté
Route::resource ('puzzles', PuzzleController :: class ) -> middleware('auth');

//gérer toutes les routes de categorie ==> l'utilisateur doit être connecté pour accéder à ces routes
Route::resource('categories', CategoriesController :: class) -> middleware('auth');

// Route pour afficher toutes les adresses
Route::get('adresse', [AdresseController::class, 'index'])->name('adresse.index');

// Route pour afficher le formulaire d'ajout d'adresse (GET)
Route::get('adresse/create', [AdresseController::class, 'create'])->name('adresse.create');

// Route pour traiter le formulaire d'ajout d'adresse (POST)
Route::post('adresse/store', [AdresseController::class, 'store'])->name('adresse.store');

// Route pour afficher le formulaire d'édition (GET)
Route::get('adresse/{id}/edit', [AdresseController::class, 'edit'])->name('adresse.edit');

// Route pour traiter le formulaire d'édition (POST)
Route::post('adresse/update', [AdresseController::class, 'update'])->name('adresse.update');

// Route pour traiter le formulaire d'ajout d'adresse depuis la page index (POST)
Route::get('/verifier_adresse', [AdresseController::class, 'verifierAdresse'])->name('vA');


Route::get ('paiement', [OrderController :: class, 'index'])->name('paiement.index');



require __DIR__.'/auth.php';


//gérer la route pour generer le pdf (l'utilisateur doit être connecté)
Route::get('pdf', [PDFController::class, 'generatePDF']) -> middleware('auth');


// Les routes de gestion du panier
Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::post('basket/store/{puzzle}', [BasketController::class, 'store'])->name('basket.store');
Route::get('basket/edit/{puzzle}', [BasketController::class, 'edit'])->name('basket.edit');
Route::get('basket/destroy', [BasketController::class, 'destroy'])->name('basket.destroy');








