<?php

declare(strict_types=1);

namespace App\Services;

interface Mailer
{
    public function send(string $to, string $subject, string $body): void;
}
