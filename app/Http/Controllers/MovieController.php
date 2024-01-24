<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Services\Movies\MovieService;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService) {}

    public function getTitles(): JsonResponse
    {
        // TODO

        try {

            $titles = $this->movieService->retrieveAndCombineTitles();

            return response()->json($titles, 200);

        } catch (Exception $e) {

            return response()->json(['status' => 'failure', 'message' => $e->getMessage()], 500);
        }
    }

}
