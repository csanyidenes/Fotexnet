<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'age_rating',
        'language',
        'cover_image',
    ];

    // Kapcsolat a Projection modellel (egy filmhez több vetítés tartozhat)
    public function projections()
    {
        return $this->hasMany(Projection::class);
    }
}
