<?php

declare(strict_types=1);

namespace App\Factories;

use App\ValueObject\Projection;
use App\Contracts\ProjectionFactoryInterface;
use App\Models\Projection as ProjectionModel;

class ProjectionFactory implements ProjectionFactoryInterface
{
    public function build($projection): Projection    
    {
        return new Projection(
            id: $projection['id'] ?? null,
            startTime: $projection['start_time'],
            availableSeats: $projection['available_seats'],
        );
    }
    
    public function buildAll($data): array
    {
        return array_map(function ($projection) {
            return $this->build($projection);
        }, $data);
    }
}
