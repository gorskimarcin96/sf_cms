<?php

namespace App\Crawler\Facebook\Exception;

use Exception;

class ImageNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Image not found');
    }
}
