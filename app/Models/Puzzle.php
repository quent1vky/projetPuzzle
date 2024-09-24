<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model{
    use HasFactory;

    protected $puzzle = [
        'nom',
        'categorie',
        'description',
        'image',
        'prix',
    ];
}
