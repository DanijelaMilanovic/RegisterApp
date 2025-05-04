<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Services\Mailer;
use App\Shared\Exceptions\MailException;

final class SmtpMailer implements Mailer
{
    private string $from;
    public function __construct(string $from)
    {
        $this->from = $from;
    }

    public function send(string $to, string $subject, string $body): void
    {
        $headers = "From: {$this->from}\r\n" .
                    "Reply-To: {$this->from}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8\r\n";

        if (!mail($to, $subject, $body, $headers)) {
            throw new MailException('Mail send failed!');
        }
    }
}
