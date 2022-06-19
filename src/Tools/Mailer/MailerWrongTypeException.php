<?php

namespace App\Tools\Mailer;

use Exception;

class MailerWrongTypeException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Type "%s" is not exists.', $type));
    }
}
