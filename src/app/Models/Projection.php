<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projection extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'available_seats',
        'movie_id',
    ];

    // Kapcsolat a Movie modellel (egy vetítés egy filmhez tartozik)
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
