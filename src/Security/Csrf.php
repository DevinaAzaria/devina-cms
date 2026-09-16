<?php

declare(strict_types=1);
namespace DevinaCms\Security;
final class Csrf
{
    public static function token(): string
    {
        Auth::startSession();
        if (empty($_SESSION['devina_cms_csrf'])) $_SESSION['devina_cms_csrf'] = bin2hex(random_bytes(32));
        return (string)$_SESSION['devina_cms_csrf'];
    }
    public static function validate(?string $token): bool
    {
        Auth::startSession(); $expected=(string)($_SESSION['devina_cms_csrf']??'');
        return $expected!=='' && $token!==null && hash_equals($expected,$token);
    }
}
