<?php

declare(strict_types=1);

namespace App\Presentation\Http;

class JsonResponse
{
    public static function ok(array $data = []): void
    {
        self::send(200, ['success' => true, 'data' => $data]);
    }

    public static function badRequest(string $message = 'Bad request'): void
    {
        self::send(400, ['success' => false, 'error' => $message]);
    }
    public static function forbidden(string $message = 'Forbidden'): void
    {
        self::send(403, ['success' => false, 'error' => $message]);
    }


    public static function validationError(array $errors): void
    {
        self::send(422, ['success' => false, 'errors' => $errors]);
    }

    private static function send(int $statusCode, array $body): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($body);
        exit;
    }
}
