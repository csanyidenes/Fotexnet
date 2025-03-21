<?php

namespace App\ValueObject;

class Movie
{
    public function __construct(
        public ?int $id,
        public string $title,
        public int $ageRating,
        public string $language,
        public ?string $coverImage,
        public ?array $projections = []
    )    
    {
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'age_rating' => $this->ageRating,
            'language' => $this->language,
            'cover_image' => $this->coverImage,
            'projections' => array_map(fn($projection) => $projection->toArray(), $this->projections),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAgeRating(): int
    {
        return $this->ageRating;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function getProjections(): array
    {
        return $this->projections;
    }

}