<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Projection;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays(5);

        foreach ($movies as $movie) {
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                for ($i = 0; $i < 3; $i++) {
                    Projection::create([
                        'movie_id' => $movie->id,
                        'start_time' => $date->copy()->setHour(rand(10, 22))->setMinute(rand(0, 59)),
                        'available_seats' => rand(50, 150),
                    ]);
                }
            }
        }
    }
}
