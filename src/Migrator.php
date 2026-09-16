<?php

declare(strict_types=1);

namespace DevinaCms;

use RuntimeException;

final class Migrator
{
    public function __construct(private readonly Database $db) {}

    public function migrate(): void
    {
        $driver = $this->db->driver();
        if (!in_array($driver, ['sqlite', 'mysql'], true)) throw new RuntimeException('Devina CMS v0.1 supports SQLite and MySQL/MariaDB.');
        foreach ($this->statements($driver) as $sql) $this->db->pdo()->exec($sql);
    }

    private function statements(string $driver): array
    {
        if ($driver === 'sqlite') return [
            "CREATE TABLE IF NOT EXISTS cms_contents (id INTEGER PRIMARY KEY AUTOINCREMENT,type TEXT NOT NULL,title TEXT NOT NULL,slug TEXT NOT NULL,excerpt TEXT NULL,body TEXT NOT NULL DEFAULT '',status TEXT NOT NULL DEFAULT 'draft',published_at TEXT NULL,starts_at TEXT NULL,ends_at TEXT NULL,location TEXT NULL,seo_title TEXT NULL,seo_description TEXT NULL,cover_media_id INTEGER NULL,created_at TEXT NOT NULL,updated_at TEXT NOT NULL,UNIQUE(type, slug))",
            'CREATE INDEX IF NOT EXISTS idx_cms_contents_type_status ON cms_contents(type, status)',
            'CREATE INDEX IF NOT EXISTS idx_cms_contents_published_at ON cms_contents(published_at)',
            'CREATE TABLE IF NOT EXISTS cms_navigation_items (id INTEGER PRIMARY KEY AUTOINCREMENT,location TEXT NOT NULL,label TEXT NOT NULL,url TEXT NOT NULL,parent_id INTEGER NULL,position INTEGER NOT NULL DEFAULT 0,is_visible INTEGER NOT NULL DEFAULT 1,created_at TEXT NOT NULL,updated_at TEXT NOT NULL)',
            'CREATE INDEX IF NOT EXISTS idx_cms_nav_location_position ON cms_navigation_items(location, position)',
            'CREATE TABLE IF NOT EXISTS cms_media (id INTEGER PRIMARY KEY AUTOINCREMENT,filename TEXT NOT NULL,storage_name TEXT NOT NULL UNIQUE,mime_type TEXT NOT NULL,size_bytes INTEGER NOT NULL,alt_text TEXT NULL,title TEXT NULL,created_at TEXT NOT NULL)',
            "CREATE TABLE IF NOT EXISTS cms_users (id INTEGER PRIMARY KEY AUTOINCREMENT,email TEXT NOT NULL UNIQUE,display_name TEXT NOT NULL,password_hash TEXT NOT NULL,role TEXT NOT NULL DEFAULT 'editor',status TEXT NOT NULL DEFAULT 'active',created_at TEXT NOT NULL,updated_at TEXT NOT NULL)",
        ];
        return [
            "CREATE TABLE IF NOT EXISTS cms_contents (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,type VARCHAR(32) NOT NULL,title VARCHAR(255) NOT NULL,slug VARCHAR(190) NOT NULL,excerpt TEXT NULL,body MEDIUMTEXT NOT NULL,status VARCHAR(20) NOT NULL DEFAULT 'draft',published_at DATETIME NULL,starts_at DATETIME NULL,ends_at DATETIME NULL,location VARCHAR(255) NULL,seo_title VARCHAR(255) NULL,seo_description TEXT NULL,cover_media_id BIGINT UNSIGNED NULL,created_at DATETIME NOT NULL,updated_at DATETIME NOT NULL,UNIQUE KEY uq_cms_content_type_slug (type, slug),KEY idx_cms_contents_type_status (type, status),KEY idx_cms_contents_published_at (published_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            'CREATE TABLE IF NOT EXISTS cms_navigation_items (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,location VARCHAR(64) NOT NULL,label VARCHAR(255) NOT NULL,url VARCHAR(2048) NOT NULL,parent_id BIGINT UNSIGNED NULL,position INT NOT NULL DEFAULT 0,is_visible TINYINT(1) NOT NULL DEFAULT 1,created_at DATETIME NOT NULL,updated_at DATETIME NOT NULL,KEY idx_cms_nav_location_position (location, position)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci',
            'CREATE TABLE IF NOT EXISTS cms_media (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,filename VARCHAR(255) NOT NULL,storage_name VARCHAR(255) NOT NULL UNIQUE,mime_type VARCHAR(128) NOT NULL,size_bytes BIGINT UNSIGNED NOT NULL,alt_text VARCHAR(255) NULL,title VARCHAR(255) NULL,created_at DATETIME NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci',
            "CREATE TABLE IF NOT EXISTS cms_users (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,email VARCHAR(190) NOT NULL UNIQUE,display_name VARCHAR(255) NOT NULL,password_hash VARCHAR(255) NOT NULL,role VARCHAR(32) NOT NULL DEFAULT 'editor',status VARCHAR(20) NOT NULL DEFAULT 'active',created_at DATETIME NOT NULL,updated_at DATETIME NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        ];
    }
}
