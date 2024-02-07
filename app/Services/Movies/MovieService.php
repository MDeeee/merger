<?php

namespace App\Services\Movies;

use App\Enums\MovieSystems;
use Illuminate\Support\Str;
use App\Exceptions\ServiceUnavailableException;

class MovieService
{
    private array $movieDataProviders;
    private int $maxRetries;
    private int $retryDelay;
    private int $cacheDuration;
    private string $cachePrefix;

    public function __construct(array $movieDataProviders) {
        $this->movieDataProviders = $movieDataProviders;
        $this->maxRetries = 3;
        $this->retryDelay = 5000;// millisecond
        $this->cacheDuration = 15;// minutes
        $this->cachePrefix = 'movie_titles_';
    }

    public function retrieveAndCombineTitles(): ?array
    {
        $titles = [];

        foreach (MovieSystems::cases() as $system) {
            $titles = array_merge($titles, $this->retrieveTitlesWithRetriesAndCache($system->value));
        }

        return $titles;
    }

    private function retrieveTitlesWithRetriesAndCache(string $system): ?array
    {
        $cacheKey = Str::of($this->cachePrefix)->append($system);

        return cache()->remember($cacheKey, $this->cacheDuration, function () use ($system) {
            return $this->retrieveTitlesWithRetries($system);
        });
    }

    private function retrieveTitlesWithRetries(string $system): ?array
    {
        return retry($this->maxRetries, function () use ($system) {

            $movieService = $this->movieDataProviders[$system];

            return $movieService->getTitles();

        }, $this->retryDelay / 1000, function ($e) {

            return $e instanceof ServiceUnavailableException;
        });
    }
}
