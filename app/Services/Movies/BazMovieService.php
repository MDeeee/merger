<?php

namespace App\Services\Movies;

use External\Baz\Movies\MovieService;
use App\Services\Movies\MovieInterface;

class BazMovieService implements MovieInterface
{
    public function getTitles(): ?array
    {

        $movieService = new MovieService();

        $titles = $movieService->getTitles();

        if (count($titles) > 0) {
            return $titles['titles'];
        }
    }
}
