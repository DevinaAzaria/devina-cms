<?php

declare(strict_types=1);
namespace DevinaCms\Http;
final class Json
{
    public static function send(mixed $data, int $status = 200): never
    {
        http_response_code($status); header('Content-Type: application/json; charset=utf-8'); header('X-Content-Type-Options: nosniff');
        echo json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); exit;
    }
}
