<?php

declare(strict_types=1);


namespace App\Contracts;

use App\ValueObject\Movie;

interface MovieApiServiceInterface
{

    public function getMovies(): ?array;

    public function getMovieById(int $id): ?Movie;

    public function createMovie($movieData): int;

    public function updateMovie(int $id, $movieData): ?int;

}