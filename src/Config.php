<?php

declare(strict_types=1);

namespace DevinaCms;

final class Config
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);
        return $value === false || $value === '' ? $default : $value;
    }

    public static function root(): string { return dirname(__DIR__); }

    public static function storagePath(string $suffix = ''): string
    {
        $base = (string) self::get('DEVINA_CMS_STORAGE_PATH', self::root() . '/storage');
        return $suffix === '' ? $base : rtrim($base, '/\\') . DIRECTORY_SEPARATOR . ltrim($suffix, '/\\');
    }

    public static function uploadPath(): string
    {
        return (string) self::get('DEVINA_CMS_UPLOAD_PATH', self::storagePath('uploads'));
    }

    public static function dsn(): string
    {
        return (string) self::get('DEVINA_CMS_DSN', 'sqlite:' . self::storagePath('devina-cms.sqlite'));
    }

    public static function basePath(): string
    {
        $base = trim((string) self::get('DEVINA_CMS_BASE_PATH', ''));
        return $base === '' || $base === '/' ? '' : '/' . trim($base, '/');
    }
}
