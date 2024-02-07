<?php

namespace App\Services\Movies;

use InvalidArgumentException;
use App\Contracts\MovieDataProvider;
use App\Adapters\BarMovieDataAdapter;
use App\Adapters\BazMovieDataAdapter;
use App\Adapters\FooMovieDataAdapter;

class MovieServiceFactory
{
    public function __construct(
        private BarMovieDataAdapter $fooMovieService,
        private BazMovieDataAdapter $barMovieService,
        private FooMovieDataAdapter $bazMovieService,
    ) {}

    public function create(string $system): ?MovieDataProvider
    {
        return match ($system) {
            'Foo'   => $this->fooMovieService,
            'Bar'   => $this->barMovieService,
            'Baz'   => $this->bazMovieService,
            default => throw new InvalidArgumentException("Invalid system: $system"),
        };
    }
}
