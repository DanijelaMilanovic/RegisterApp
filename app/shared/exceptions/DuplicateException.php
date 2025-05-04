<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Exception;

class DuplicateException extends Exception
{

    public function __construct(string $message = 'Duplicated field')
    {
        parent::__construct($message);
    }
}
