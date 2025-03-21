<?php

namespace App\Contracts;

use App\ValueObject\Movie;

interface MovieFactoryInterface
{

    public function build($data): Movie;

    public function buildAll($data): array;
}