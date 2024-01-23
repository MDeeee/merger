<?php

namespace App\Services\Authenticator;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use App\Services\Authenticator\AuthenticatorInterface;

class BazAuthenticator implements AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $authService = new Authenticator();

        $returnObj = $authService->auth($login, $password);

        return $returnObj instanceof Success;
    }
}
