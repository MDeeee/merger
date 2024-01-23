<?php

namespace App\Services\Authenticator;

use External\Bar\Auth\LoginService;
use App\Services\Authenticator\AuthenticatorInterface;

class BarAuthenticator implements AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $authService = new LoginService();

        return $authService->login($login, $password);
    }
}
