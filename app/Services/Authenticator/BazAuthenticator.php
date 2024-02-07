<?php

namespace App\Services\Authenticator;

use Exception;
use Illuminate\Support\Facades\Log;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use App\Services\Authenticator\AuthenticatorInterface;

class BazAuthenticator implements AuthenticatorInterface
{
    public function __construct(private Authenticator $authService) {}

    public function authenticate(string $login, string $password): bool
    {
        try {

            $returnObj = $this->authService->auth($login, $password);

            return $returnObj instanceof Success ?: true;

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return false;
        }
    }
}
