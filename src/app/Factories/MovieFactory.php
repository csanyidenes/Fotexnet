<?php

declare(strict_types=1);

namespace App\Factories;

use App\ValueObject\Movie;
use App\Contracts\MovieFactoryInterface;
use App\Contracts\ProjectionFactoryInterface;


class MovieFactory implements MovieFactoryInterface
{
    public function __construct(protected readonly ProjectionFactoryInterface $projectionFactory) {}

    public function build($movie): Movie
    {
        return new Movie(
            id: $movie['id'] ?? null,
            title: $movie['title'],
            ageRating: $movie['age_rating'],
            language: $movie['language'],
            coverImage: $movie['cover_image'] ?? null,
            projections: $this->projectionFactory->buildAll(is_array($movie['projections'] ?? null) ? $movie['projections'] : [])
        );
    }

    public function buildAll($data): array
    {
        return array_map(function ($movie) {
            return $this->build($movie);
        }, $data);
    }
}
