<?php

namespace App\Services\Movies;

use InvalidArgumentException;
use App\Services\Movies\MovieInterface;
use App\Services\Movies\BarMovieService;
use App\Services\Movies\BazMovieService;
use App\Services\Movies\FooMovieService;

class MovieServiceFactory
{
    public function __construct(
        private FooMovieService $fooMovieService,
        private BarMovieService $barMovieService,
        private BazMovieService $bazMovieService,
    ) {}

    public function create(string $system): ?MovieInterface
    {
        switch ($system) {
            case 'Foo':
                return $this->fooMovieService;
            case 'Bar':
                return $this->barMovieService;
            case 'Baz':
                return $this->bazMovieService;
            default:
                throw new InvalidArgumentException("Invalid system: $system");
        }
    }
}
