<?php

namespace App\Services\Movies;

use App\Enums\MovieSystems;
use App\Services\Movies\MovieServiceFactory;
use App\Services\Movies\ServiceUnavailableException;

class MovieService
{
    public function __construct(
        private MovieServiceFactory $movieServiceFactory,
        private int $maxRetries = 3,
        private int $retryDelay = 5000,// millisecond
        private int $cacheDuration = 15,// minutes
        private string $cachePrefix = 'movie_titles_'
    ) {}

    public function retrieveAndCombineTitles(): ?array
    {
        $titles = [];

        // Retrieve titles from each system with retries and caching
        foreach (MovieSystems::cases() as $system) {
            $titles = array_merge($titles, $this->retrieveTitlesWithRetriesAndCache($system->value));
        }

        return $titles;
    }

    private function retrieveTitlesWithRetriesAndCache(string $system): ?array
    {
        $cacheKey = $this->cachePrefix . $system;

        $titles = cache()->get($cacheKey);

        if (!empty($titles)) return $titles;

        $titles = $this->retrieveTitlesWithRetries($system);

        cache()->put($cacheKey, $titles, now()->addMinutes($this->cacheDuration));

        return $titles;
    }

    private function retrieveTitlesWithRetries(string $system): ?array
    {
        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {

            try {

                $movieService = $this->movieServiceFactory->create($system);

                return $movieService->getTitles();

            } catch (ServiceUnavailableException $e) {

                if ($attempt < $this->maxRetries) {

                    usleep($this->retryDelay);

                } else {
                    throw $e;
                }
            }
        }
    }
}
