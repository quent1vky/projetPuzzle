<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $filliable = [
        'type_paiement',
        'statut',
        'statut',
        'order_date',
        'articles',
        'total_price',
        'paiement_method'
    ];
}
