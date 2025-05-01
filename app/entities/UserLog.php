<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;

class UserLog
{
    private ?int $id;
    private string $action;
    private ?DateTime $logTime;
    private int $userId;

    public function __construct(?int $id, string $action, ?DateTime $logTime, int $userId)
    {
        $this->id = $id;
        $this->action = $action;
        $this->logTime = $logTime;
        $this->userId = $userId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getLogTime(): DateTime
    {
        return $this->logTime;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
