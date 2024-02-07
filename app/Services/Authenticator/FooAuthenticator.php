<?php

namespace App\Services\Authenticator;

use Exception;
use External\Foo\Auth\AuthWS;
use Illuminate\Support\Facades\Log;
use App\Services\Authenticator\AuthenticatorInterface;

class FooAuthenticator implements AuthenticatorInterface
{
    public function __construct(private AuthWS $authService) {}

    public function authenticate(string $login, string $password): bool
    {
        try {

            $this->authService->authenticate($login, $password);

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return false;
        }

        return true;
    }
}
