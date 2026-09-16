<?php

declare(strict_types=1);
namespace DevinaCms\Security;
use DevinaCms\Config;
use DevinaCms\Repository\UserRepository;
final class Auth
{
    public function __construct(private readonly UserRepository $users) { self::startSession(); }
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        session_name((string) Config::get('DEVINA_CMS_SESSION_NAME', 'devina_cms'));
        session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
        session_start();
    }
    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if (!$user || $user['status'] !== 'active' || !password_verify($password, (string)$user['password_hash'])) { usleep(250000); return false; }
        session_regenerate_id(true); $_SESSION['devina_cms_user_id'] = (int)$user['id']; return true;
    }
    public function user(): ?array { $id=(int)($_SESSION['devina_cms_user_id']??0); return $id>0?$this->users->find($id):null; }
    public function check(): bool { return $this->user() !== null; }
    public function logout(): void { unset($_SESSION['devina_cms_user_id']); session_regenerate_id(true); }
}
