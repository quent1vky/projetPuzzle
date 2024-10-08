<?php

namespace App\Http\Controllers;
use App\Models\Categories;



use Illuminate\Http\Request;

class CategoriesController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', ['cat' => $categories]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categorie)
    {
        return view('categories.show', compact('categorie')); // Passer le puzzle à la vue
    }
}
