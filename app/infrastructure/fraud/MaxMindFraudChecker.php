<?php

declare(strict_types=1);

namespace App\Infrastructure\Fraud;

use App\Services\FraudChecker;

class MaxMindFraudChecker implements FraudChecker
{
    public function checkFraud(string $email, string $ip): bool
    {
        $badEmails = ['fraud.com', 'bad.mail'];
        $badIps = ['0.0.0.0', '198.51.100.42'];

        $domain = substr(strrchr($email, '@'), 1);
        if (in_array($domain, $badEmails, true)) {
            return true;
        }

        if (in_array($ip, $badIps, true)) {
            return true;
        }

        return false;
    }
}
