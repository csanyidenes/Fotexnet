<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            'Inception', 'The Matrix', 'Titanic', 'Gladiator', 'Avatar',
            'The Godfather', 'Pulp Fiction', 'Fight Club', 'Forrest Gump', 'The Shawshank Redemption',
            'Interstellar', 'The Dark Knight', 'The Prestige', 'Django Unchained', 'Whiplash',
            'The Lord of the Rings', 'Harry Potter', 'Star Wars', 'Jurassic Park', 'Saving Private Ryan'
        ];

        foreach ($movies as $movie) {
            Movie::create([
                'title' => $movie,
                'age_rating' => rand(0, 18),
                'language' => ['English', 'Spanish', 'French', 'German'][rand(0, 3)],
                'cover_image' => null, // vagy adhatunk meg képeket
            ]);
        }
    }
}
