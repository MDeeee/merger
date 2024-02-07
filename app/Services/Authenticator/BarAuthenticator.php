<?php

namespace App\Services\Authenticator;

use Exception;
use External\Bar\Auth\LoginService;
use Illuminate\Support\Facades\Log;
use App\Services\Authenticator\AuthenticatorInterface;

class BarAuthenticator implements AuthenticatorInterface
{
    public function __construct(private LoginService $authService) {}

    public function authenticate(string $login, string $password): bool
    {
        try {

            $this->authService->login($login, $password);

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return false;
        }

        return true;
    }
}
