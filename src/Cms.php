<?php

declare(strict_types=1);

namespace DevinaCms;

use DevinaCms\Repository\ContentRepository;
use DevinaCms\Repository\MediaRepository;
use DevinaCms\Repository\NavigationRepository;
use DevinaCms\Repository\UserRepository;
use DevinaCms\Security\Auth;

final class Cms
{
    public readonly Database $db;
    public readonly ContentRepository $contents;
    public readonly NavigationRepository $navigation;
    public readonly MediaRepository $media;
    public readonly UserRepository $users;
    private ?Auth $authInstance = null;

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
        $this->contents = new ContentRepository($this->db);
        $this->navigation = new NavigationRepository($this->db);
        $this->media = new MediaRepository($this->db);
        $this->users = new UserRepository($this->db);
    }

    public function auth(): Auth { return $this->authInstance ??= new Auth($this->users); }

    public function install(): void
    {
        (new Migrator($this->db))->migrate();
        $uploadDir = Config::uploadPath();
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
    }
}
