<?php

declare(strict_types=1);

namespace App\Services;

interface FraudChecker
{
    public function checkFraud(string $email, string $ip): bool;
}
