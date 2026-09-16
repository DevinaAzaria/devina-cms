<?php

declare(strict_types=1);
namespace DevinaCms\Repository;
use DevinaCms\Database;
use DevinaCms\Support\Clock;
final class MediaRepository
{
    public function __construct(private readonly Database $db) {}
    public function create(array $d): int
    {
        $s=$this->db->pdo()->prepare('INSERT INTO cms_media (filename,storage_name,mime_type,size_bytes,alt_text,title,created_at) VALUES (:filename,:storage_name,:mime_type,:size_bytes,:alt_text,:title,:created_at)');$s->execute(['filename'=>(string)$d['filename'],'storage_name'=>(string)$d['storage_name'],'mime_type'=>(string)$d['mime_type'],'size_bytes'=>(int)$d['size_bytes'],'alt_text'=>($d['alt_text']??'')!==''?(string)$d['alt_text']:null,'title'=>($d['title']??'')!==''?(string)$d['title']:null,'created_at'=>Clock::now()]);return (int)$this->db->pdo()->lastInsertId();
    }
    public function find(int $id): ?array{$s=$this->db->pdo()->prepare('SELECT * FROM cms_media WHERE id=:id');$s->execute(['id'=>$id]);$r=$s->fetch();return $r?:null;}
    public function all(): array{return $this->db->pdo()->query('SELECT * FROM cms_media ORDER BY id DESC')->fetchAll();}
    public function delete(int $id): void{$s=$this->db->pdo()->prepare('DELETE FROM cms_media WHERE id=:id');$s->execute(['id'=>$id]);}
}
