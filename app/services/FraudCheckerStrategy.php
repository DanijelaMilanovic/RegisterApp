<?php

declare(strict_types=1);

namespace App\Services;

interface FraudCheckerStrategy
{
    public function checkFraud(string $email, string $ip): bool;
}
