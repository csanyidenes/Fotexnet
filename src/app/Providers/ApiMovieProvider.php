<?php

namespace App\Providers;

use App\Factories\MovieFactory;
use App\Services\MovieApiService;
use App\Factories\ProjectionFactory;
use Illuminate\Support\ServiceProvider;
use App\Contracts\MovieFactoryInterface;
use App\Contracts\MovieApiServiceInterface;
use App\Contracts\ProjectionFactoryInterface;

class ApiMovieProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProjectionFactoryInterface::class,
            ProjectionFactory::class
        );
        
        $this->app->bind(
            MovieFactoryInterface::class,
            function ($app) {
                return new MovieFactory($app->make(ProjectionFactoryInterface::class));
            }
        );
        
        $this->app->bind(
            MovieApiServiceInterface::class, function ($app) {
                return new MovieApiService($app->make(MovieFactoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
