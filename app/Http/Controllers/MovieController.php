<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\Movies\MovieServiceFactory;
use App\Services\Movies\ServiceUnavailableException;

class MovieController extends Controller
{
    public function getTitles(): JsonResponse
    {
        // TODO

        try {
            $titles = $this->retrieveAndCombineTitles();
            return response()->json($titles, 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

    private function retrieveAndCombineTitles()
    {
        $titles = [];

        // Retrieve titles from each system with retries and caching
        foreach (['Foo', 'Bar', 'Baz'] as $system) {
            $titles = array_merge($titles, $this->retrieveTitlesWithRetriesAndCache($system));
        }

        return $titles;
    }

    private function retrieveTitlesWithRetriesAndCache($system): ?array
    {
        $cacheKey = "movie_titles_$system";

        if ($titles = cache()->get($cacheKey)) {
            return $titles;
        }

        $titles = $this->retrieveTitlesWithRetries($system);

        cache()->put($cacheKey, $titles, now()->addMinutes(15));

        return $titles;
    }

    private function retrieveTitlesWithRetries($system): ?array
    {
        $maxRetries = 3;
        $retryDelay = 500; // milliseconds

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {

                $movieService = MovieServiceFactory::create($system);

                return $movieService->getTitles();

            } catch (ServiceUnavailableException $e) {

                if ($attempt < $maxRetries) {
                    usleep($retryDelay * 1000); // Delay before retry
                } else {
                    throw $e; // Rethrow after final attempt
                }
            }
        }
    }
}
