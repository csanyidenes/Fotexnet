<?php

namespace App\ValueObject;

class Projection
{
    public function __construct(
        public ?int $id,
        public string $startTime,
        public int $availableSeats
    ) {}


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'start_time' => $this->startTime,
            'available_seats' => $this->availableSeats,
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getAvailableSeats(): int
    {
        return $this->availableSeats;
    }
}
