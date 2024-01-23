<?php

namespace App\Services\Movies;

use InvalidArgumentException;
use App\Services\Movies\MovieInterface;

class MovieServiceFactory
{
    public static function create(string $system): ?MovieInterface
    {
        switch ($system) {
            case 'Foo':
                return new FooMovieService();
            case 'Bar':
                return new BarMovieService();
            case 'Baz':
                return new BazMovieService();
            default:
                throw new InvalidArgumentException("Invalid system: $system");
        }
    }
}
