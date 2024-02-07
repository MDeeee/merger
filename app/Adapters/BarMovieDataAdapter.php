<?php

namespace App\Adapters;

use Illuminate\Support\Arr;
use App\Contracts\MovieDataProvider;
use External\Bar\Movies\MovieService;

class BarMovieDataAdapter implements MovieDataProvider
{
    public function __construct(private MovieService $movieService) {}

    public function getTitles(): ?array
    {
        $titles = [];

        $titles = $this->movieService->getTitles();

        if (count($titles) > 0 && isset($titles['titles'])) {
            return Arr::pluck($titles['titles'], 'title');
        }

        return $titles;
    }
}
