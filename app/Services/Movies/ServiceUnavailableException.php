<?php

namespace App\Services\Movies;

use Exception;

class ServiceUnavailableException extends Exception
{
    protected $code = 500;
    protected $message = "Service unavailable";
}
