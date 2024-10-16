<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
