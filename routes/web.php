<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\PDFController;


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
    if (Auth::check()) {
        // Utilisateur connecté, afficher son tableau de bord personnel
        return view('dashboard', ['user' => Auth::user()]);
    } else {
        // Utilisateur non connecté, afficher une version limitée du dashboard
        return view('dashboard', ['user' => null]);
    }
})->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//gérer toutes les routes de puzzle ==> l'utilisateur doit être connecté pour accéder à ces routes
Route::resource ('puzzles', PuzzleController :: class ) -> middleware ('auth');
require __DIR__.'/auth.php';


//gérer la route pour generer le pdf (l'utilisateur doit être connecté)
Route::get('pdf', [PDFController::class, 'generatePDF']) -> middleware('auth');


//acceder au vue de puzzle sans être connecté (pas de middleware)
//Route::resource ('puzzles', PuzzleController :: class );



