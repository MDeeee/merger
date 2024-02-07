<?php

namespace App\Providers;

use App\Enums\MovieSystems;
use App\Adapters\BarMovieDataAdapter;
use App\Adapters\BazMovieDataAdapter;
use App\Adapters\FooMovieDataAdapter;
use App\Services\Movies\MovieService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Inject dependencies into MovieService
        $this->app->singleton(MovieService::class, function (Application $app) :MovieService {
            return new MovieService([
                MovieSystems::Bar->value => $app->make(BarMovieDataAdapter::class),
                MovieSystems::Foo->value => $app->make(FooMovieDataAdapter::class),
                MovieSystems::Baz->value => $app->make(BazMovieDataAdapter::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
