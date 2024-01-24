<?php

namespace App\Services\Authenticator;

use InvalidArgumentException;
use App\Services\Authenticator\BarAuthenticator;
use App\Services\Authenticator\BazAuthenticator;
use App\Services\Authenticator\FooAuthenticator;
use App\Services\Authenticator\AuthenticatorInterface;

class AuthenticatorFactory
{
    public function __construct(
        private FooAuthenticator $fooAuthenticator,
        private BarAuthenticator $barAuthenticator,
        private BazAuthenticator $bazAuthenticator,
    ) {}

    public function create(string $company): AuthenticatorInterface
    {
        switch (substr($company, 0, 4)) {
            case 'FOO_':
                return $this->fooAuthenticator;
            case 'BAR_':
                return $this->barAuthenticator;
            case 'BAZ_':
                return $this->bazAuthenticator;
            default:
                throw new InvalidArgumentException('Invalid company');
        }
    }
}
