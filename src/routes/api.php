<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProjectionController;

Route::middleware('api')->group(function () {
    Route::apiResource('movies', MovieController::class);
});
