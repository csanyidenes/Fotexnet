<?php

declare(strict_types=1);

namespace App\Contracts;

use App\ValueObject\Projection;

interface ProjectionFactoryInterface
{
    public function build($data): Projection;

    public function buildAll($data): array;
}