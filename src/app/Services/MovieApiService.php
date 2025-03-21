<?php

namespace App\Services;

use App\Models\Movie;
use App\ValueObject\Movie as MovieObject;
use App\Factories\MovieFactory;
use App\Contracts\MovieFactoryInterface;
use App\Contracts\MovieApiServiceInterface;


class MovieApiService implements MovieApiServiceInterface
{
    public function __construct(
        protected readonly MovieFactoryInterface $movieFactory
        )
    {
    }

    public function getMovies(): ?array
    {
        $movies = $movies = Movie::with('projections')->get();

        if (!$movies) {
            return null;
        }

        return $this->movieFactory->buildAll($movies->toArray());
    }

    public function getMovieById($movieId): ?MovieObject
    {
        $movie = Movie::where('id', $movieId)->first();

        if (!$movie) {
            return null;
        }

        return $this->movieFactory->build($movie->toArray());

    }

    public function createMovie($movieData): int
    {
        $movie = $this->movieFactory->build($movieData);

        $movieModel = new Movie();
        $movieModel->title = $movie->getTitle();
        $movieModel->age_rating = $movie->getAgeRating();
        $movieModel->language = $movie->getLanguage();
        $movieModel->cover_image = $movie->getCoverImage();
        $movieModel->save();

        if ($movie->getProjections()) {
            foreach ($movie->getProjections() as $projection) {
                $movieModel->projections()->create([
                    'start_time' => $projection->getStartTime(),
                    'available_seats' => $projection->getAvailableSeats(),
                ]);
            }
        }

        return $movieModel->id;
    }

    public function updateMovie($movieId, $movieData): ?int
    {
        $movieModel = Movie::where('id', $movieId)->first();

        if (!$movieModel) {
            return null;
        }

        $movie = $this->movieFactory->build($movieData);

        $movieModel->title = $movie->getTitle();
        $movieModel->age_rating = $movie->getAgeRating();
        $movieModel->language = $movie->getLanguage();
        $movieModel->cover_image = $movie->getCoverImage();
        $movieModel->save();
        
        if ($movie->getProjections()) {
            foreach ($movie->getProjections() as $projection) {
                $movieModel->projections()->updateOrCreate(
                    ['start_time' => $projection->getStartTime()],
                    ['available_seats' => $projection->getAvailableSeats()]
                );
            }
        }

        return $movieModel->id;
    }
}