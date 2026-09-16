<?php

declare(strict_types=1);

namespace DevinaCms\Repository;

use DevinaCms\Database;
use DevinaCms\Support\Clock;
use DevinaCms\Support\Slug;
use InvalidArgumentException;

final class ContentRepository
{
    private const TYPES = ['page','article','event'];
    private const STATUSES = ['draft','published'];

    public function __construct(private readonly Database $db) {}

    public function create(array $data): int
    {
        $data=$this->normalize($data); $data['slug']=$this->uniqueSlug($data['type'],$data['slug']); $now=Clock::now();
        $stmt=$this->db->pdo()->prepare('INSERT INTO cms_contents (type,title,slug,excerpt,body,status,published_at,starts_at,ends_at,location,seo_title,seo_description,cover_media_id,created_at,updated_at) VALUES (:type,:title,:slug,:excerpt,:body,:status,:published_at,:starts_at,:ends_at,:location,:seo_title,:seo_description,:cover_media_id,:created_at,:updated_at)');
        $stmt->execute($data+['created_at'=>$now,'updated_at'=>$now]); return (int)$this->db->pdo()->lastInsertId();
    }

    public function update(int $id,array $data): void
    {
        $existing=$this->find($id); if(!$existing) throw new InvalidArgumentException('Content not found.');
        $data=$this->normalize($data,$existing); $data['slug']=$this->uniqueSlug($data['type'],$data['slug'],$id);
        $stmt=$this->db->pdo()->prepare('UPDATE cms_contents SET type=:type,title=:title,slug=:slug,excerpt=:excerpt,body=:body,status=:status,published_at=:published_at,starts_at=:starts_at,ends_at=:ends_at,location=:location,seo_title=:seo_title,seo_description=:seo_description,cover_media_id=:cover_media_id,updated_at=:updated_at WHERE id=:id');
        $stmt->execute($data+['updated_at'=>Clock::now(),'id'=>$id]);
    }

    public function delete(int $id): void { $s=$this->db->pdo()->prepare('DELETE FROM cms_contents WHERE id=:id'); $s->execute(['id'=>$id]); }
    public function find(int $id): ?array { $s=$this->db->pdo()->prepare('SELECT * FROM cms_contents WHERE id=:id'); $s->execute(['id'=>$id]); $r=$s->fetch(); return $r?:null; }

    public function all(?string $type=null): array
    {
        if($type!==null&&!in_array($type,self::TYPES,true)) throw new InvalidArgumentException('Invalid content type.');
        if($type===null) return $this->db->pdo()->query('SELECT * FROM cms_contents ORDER BY updated_at DESC,id DESC')->fetchAll();
        $s=$this->db->pdo()->prepare('SELECT * FROM cms_contents WHERE type=:type ORDER BY updated_at DESC,id DESC'); $s->execute(['type'=>$type]); return $s->fetchAll();
    }

    public function published(?string $type=null,int $limit=50,int $offset=0): array
    {
        if($type!==null&&!in_array($type,self::TYPES,true)) throw new InvalidArgumentException('Invalid content type.');
        $limit=max(1,min(100,$limit)); $offset=max(0,$offset); $params=['now'=>Clock::now()];
        $where="status='published' AND (published_at IS NULL OR published_at<=:now)";
        if($type!==null){$where.=' AND type=:type';$params['type']=$type;}
        $s=$this->db->pdo()->prepare("SELECT * FROM cms_contents WHERE {$where} ORDER BY COALESCE(published_at,created_at) DESC,id DESC LIMIT {$limit} OFFSET {$offset}"); $s->execute($params); return $s->fetchAll();
    }

    public function findPublishedBySlug(string $type,string $slug): ?array
    {
        if(!in_array($type,self::TYPES,true)) return null;
        $s=$this->db->pdo()->prepare("SELECT * FROM cms_contents WHERE type=:type AND slug=:slug AND status='published' AND (published_at IS NULL OR published_at<=:now) LIMIT 1");
        $s->execute(['type'=>$type,'slug'=>$slug,'now'=>Clock::now()]); $r=$s->fetch(); return $r?:null;
    }

    private function normalize(array $data,array $fallback=[]): array
    {
        $type=(string)($data['type']??$fallback['type']??'page'); $title=trim((string)($data['title']??$fallback['title']??'')); $status=(string)($data['status']??$fallback['status']??'draft');
        if(!in_array($type,self::TYPES,true)) throw new InvalidArgumentException('Invalid content type.');
        if($title==='') throw new InvalidArgumentException('Title is required.');
        if(!in_array($status,self::STATUSES,true)) throw new InvalidArgumentException('Invalid status.');
        $slug=Slug::make((string)($data['slug']??$fallback['slug']??$title)); $published=$this->nullableDate($data['published_at']??$fallback['published_at']??null);
        if($status==='published'&&$published===null)$published=Clock::now();
        return ['type'=>$type,'title'=>$title,'slug'=>$slug,'excerpt'=>$this->nullableText($data['excerpt']??$fallback['excerpt']??null),'body'=>(string)($data['body']??$fallback['body']??''),'status'=>$status,'published_at'=>$published,'starts_at'=>$this->nullableDate($data['starts_at']??$fallback['starts_at']??null),'ends_at'=>$this->nullableDate($data['ends_at']??$fallback['ends_at']??null),'location'=>$this->nullableText($data['location']??$fallback['location']??null),'seo_title'=>$this->nullableText($data['seo_title']??$fallback['seo_title']??null),'seo_description'=>$this->nullableText($data['seo_description']??$fallback['seo_description']??null),'cover_media_id'=>($data['cover_media_id']??$fallback['cover_media_id']??null)?:null];
    }

    private function uniqueSlug(string $type,string $slug,?int $ignoreId=null): string
    {
        $base=$slug;$candidate=$base;$i=2;
        while(true){$sql='SELECT id FROM cms_contents WHERE type=:type AND slug=:slug';$params=['type'=>$type,'slug'=>$candidate];if($ignoreId!==null){$sql.=' AND id<>:id';$params['id']=$ignoreId;}$s=$this->db->pdo()->prepare($sql.' LIMIT 1');$s->execute($params);if(!$s->fetch())return $candidate;$candidate=$base.'-'.$i++;}
    }

    private function nullableText(mixed $v): ?string { if($v===null)return null;$v=trim((string)$v);return $v===''?null:$v; }
    private function nullableDate(mixed $v): ?string { if($v===null||trim((string)$v)==='')return null;$ts=strtotime((string)$v);if($ts===false)throw new InvalidArgumentException('Invalid date/time value.');return date('Y-m-d H:i:s',$ts); }
}
