<?php

namespace App\Services\Authenticator;

use Illuminate\Support\Str;
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

    public function create(string $company): AuthenticatorInterface|InvalidArgumentException
    {
        $companyName = Str::upper($company);

        return match (Str::substr($companyName, 0, 4)) {
            'FOO_'  => $this->fooAuthenticator,
            'BAR_'  => $this->barAuthenticator,
            'BAZ_'  => $this->bazAuthenticator,
            default => throw new InvalidArgumentException('Invalid company'),
        };
    }
}
