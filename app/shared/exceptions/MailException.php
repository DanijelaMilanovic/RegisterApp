<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Exception;

class MailException extends Exception
{

    public function __construct(string $message = 'Mail send failed')
    {
        parent::__construct($message);
    }
}
