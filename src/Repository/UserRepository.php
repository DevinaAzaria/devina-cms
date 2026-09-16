<?php

declare(strict_types=1);
namespace DevinaCms\Repository;
use DevinaCms\Database;
use DevinaCms\Support\Clock;
use InvalidArgumentException;
final class UserRepository
{
    public function __construct(private readonly Database $db) {}
    public function create(string $email,string $displayName,string $password,string $role='admin'): int
    {
        $email=strtolower(trim($email));$displayName=trim($displayName);if(!filter_var($email,FILTER_VALIDATE_EMAIL))throw new InvalidArgumentException('A valid email is required.');if($displayName===''||strlen($password)<10)throw new InvalidArgumentException('Display name is required and password must be at least 10 characters.');if(!in_array($role,['admin','editor'],true))throw new InvalidArgumentException('Invalid role.');$now=Clock::now();$s=$this->db->pdo()->prepare("INSERT INTO cms_users (email,display_name,password_hash,role,status,created_at,updated_at) VALUES (:email,:display_name,:password_hash,:role,'active',:created_at,:updated_at)");$s->execute(['email'=>$email,'display_name'=>$displayName,'password_hash'=>password_hash($password,PASSWORD_DEFAULT),'role'=>$role,'created_at'=>$now,'updated_at'=>$now]);return (int)$this->db->pdo()->lastInsertId();
    }
    public function findByEmail(string $email): ?array{$s=$this->db->pdo()->prepare('SELECT * FROM cms_users WHERE email=:email LIMIT 1');$s->execute(['email'=>strtolower(trim($email))]);$r=$s->fetch();return $r?:null;}
    public function find(int $id): ?array{$s=$this->db->pdo()->prepare('SELECT id,email,display_name,role,status,created_at,updated_at FROM cms_users WHERE id=:id');$s->execute(['id'=>$id]);$r=$s->fetch();return $r?:null;}
    public function count(): int{return (int)$this->db->pdo()->query('SELECT COUNT(*) FROM cms_users')->fetchColumn();}
}
