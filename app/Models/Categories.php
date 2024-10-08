<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable  = [
        'libelle',
        'description',
        'path_image',
    ];

    public function puzzles()
    {
        return $this->hasMany(Puzzle::class, 'categorie_id'); // Assurez-vous que la relation est correctement définie
    }
}
