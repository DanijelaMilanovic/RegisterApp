<?php

declare(strict_types = 1);

namespace App\Shared;

/**
 * @property-read ?array $db
 */
class DatabaseConfiguration
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USER'],
                'pass'     => $env['DB_PASS'],
                'database' => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'],
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
