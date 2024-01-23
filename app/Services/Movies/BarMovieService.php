<?php

namespace App\Services\Movies;

use Illuminate\Support\Arr;
use External\Bar\Movies\MovieService;
use App\Services\Movies\MovieInterface;

class BarMovieService implements MovieInterface
{
    public function getTitles(): ?array
    {
        $movieService = new MovieService();

        $titles = $movieService->getTitles();

        if (count($titles) > 0) {
            return Arr::pluck($titles['titles'], 'title');
        }
    }
}
