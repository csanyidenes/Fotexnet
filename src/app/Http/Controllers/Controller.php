<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function response($data, int $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }
}
