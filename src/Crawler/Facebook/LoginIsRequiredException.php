<?php

namespace App\Crawler\Facebook;

use Exception;

class LoginIsRequiredException extends Exception
{
    public function __construct()
    {
        parent::__construct('Login is required!');
    }
}
