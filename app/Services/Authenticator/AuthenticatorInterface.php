<?php

namespace App\Services\Authenticator;

interface AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool;
}
