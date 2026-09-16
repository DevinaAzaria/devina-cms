<?php

declare(strict_types=1);

namespace DevinaCms;

use PDO;

final class Database
{
    private PDO $pdo;

    public function __construct(?string $dsn = null, ?string $username = null, ?string $password = null)
    {
        $dsn ??= Config::dsn();
        if (str_starts_with($dsn, 'sqlite:') && $dsn !== 'sqlite::memory:') {
            $path = substr($dsn, 7);
            $dir = dirname($path);
            if (!is_dir($dir)) mkdir($dir, 0775, true);
        }
        $username ??= (string) Config::get('DEVINA_CMS_DB_USER', '');
        $password ??= (string) Config::get('DEVINA_CMS_DB_PASSWORD', '');
        $this->pdo = new PDO($dsn, $username ?: null, $password ?: null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        if ($this->driver() === 'sqlite') $this->pdo->exec('PRAGMA foreign_keys = ON');
    }

    public function pdo(): PDO { return $this->pdo; }
    public function driver(): string { return (string) $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME); }
}
