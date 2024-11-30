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
use App\Http\Controllers\AdminController;

use App\Models\Puzzle;
use App\Models\User;
use App\Models\Order;




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


// Route du dashboard accessible à tous
Route::get('/', function () {
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


Route::get('/admin', function () {
    $orders = Order::all();
    if (Auth::check() && Auth::user()->role === 'admin') {
        return view('admin.index', compact('orders'));
    }
})->name('admin.index');


Route::get('admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('admin/update', [AdminController::class, 'update'])->name('admin.update');

//gérer toutes les routes de puzzle ==> l'utilisateur n'a pas besoin d'être connecté
Route::resource ('puzzles', PuzzleController :: class );

//gérer toutes les routes de categorie ==> l'utilisateur doit être connecté pour accéder à ces routes
Route::resource('categories', CategoriesController :: class);


// Les routes de gestion de l'adresse
Route::get('adresse', [AdresseController::class, 'index'])->name('adresse.index');
Route::get('adresse/create', [AdresseController::class, 'create'])->name('adresse.create');
Route::post('adresse/store', [AdresseController::class, 'store'])->name('adresse.store');
Route::get('adresse/{id}/edit', [AdresseController::class, 'edit'])->name('adresse.edit');
Route::put('adresse/update', [AdresseController::class, 'update'])->name('adresse.update');
Route::get('/verifier_adresse', [AdresseController::class, 'verifierAdresse'])->name('vA');

// Les routes de gestion du paiement
Route::get ('paiement', [OrderController::class, 'index'])->name('paiement.index');
Route::get ('paiement/methode', [OrderController::class, 'methode'])->name('paiement.methode');
Route::post('paiement/store', [OrderController::class, 'store'])->name('p.store');
Route::get ('paiement/transaction', [OrderController::class, 'transaction'])->name('paiement.transaction');


// Les routes de gestion du panier
Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::post('basket/store/{puzzle}', [BasketController::class, 'store'])->name('basket.store');
Route::get('basket/edit/{puzzle}', [BasketController::class, 'edit'])->name('basket.edit');
Route::get('basket/destroy', [BasketController::class, 'destroy'])->name('basket.destroy');


//gérer la route pour generer le pdf (l'utilisateur doit être connecté)
Route::get('pdf', [PDFController::class, 'generatePDF']) -> middleware('auth') -> name('pdf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';








