<?php

namespace App\Services\Movies;

use External\Foo\Movies\MovieService;
use App\Services\Movies\MovieInterface;

class FooMovieService implements MovieInterface
{
    public function getTitles(): ?array
    {
        $movieService = new MovieService();

        return $movieService->getTitles();
    }
}
