<?php

declare(strict_types=1);

namespace App\Contracts;

interface FraudCheckerStrategy
{
    public function checkFraud(string $email, string $ip): bool;
}
