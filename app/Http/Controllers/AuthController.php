<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Services\Authenticator\AuthenticatorFactory;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        // TODO

        $authenticator = AuthenticatorFactory::create($request->login);

        if ($authenticator->authenticate($request->login, $request->password)) {
            return response()->json([
                'status' => 'success',
                'token' => Str::random(128),
            ]);
        }

        return response()->json([
            'status' => 'failure',
        ], 401);
    }
}
