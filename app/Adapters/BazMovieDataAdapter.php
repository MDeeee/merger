<?php

namespace App\Adapters;

use App\Contracts\MovieDataProvider;
use External\Baz\Movies\MovieService;

class BazMovieDataAdapter implements MovieDataProvider
{
    public function __construct(private MovieService $movieService) {}

    public function getTitles(): ?array
    {
        $titles = [];

        $titles = $this->movieService->getTitles();

        if (count($titles) > 0 && isset($titles['titles'])) {
            return $titles['titles'];
        }

        return $titles;
    }
}
