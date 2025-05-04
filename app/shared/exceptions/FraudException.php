<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use Exception;

class FraudException extends Exception
{

    public function __construct(string $message = 'Fraud detected')
    {
        parent::__construct($message);
    }
}
