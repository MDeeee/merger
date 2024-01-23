<?php

namespace App\Services\Authenticator;

use InvalidArgumentException;
use App\Services\Authenticator\BarAuthenticator;
use App\Services\Authenticator\BazAuthenticator;
use App\Services\Authenticator\FooAuthenticator;
use App\Services\Authenticator\AuthenticatorInterface;

class AuthenticatorFactory
{
    public static function create(string $company): AuthenticatorInterface
    {
        switch (substr($company, 0, 4)) {
            case 'FOO_':
                return new FooAuthenticator();
            case 'BAR_':
                return new BarAuthenticator();
            case 'BAZ_':
                return new BazAuthenticator();
            default:
                throw new InvalidArgumentException('Invalid company');
        }
    }
}
