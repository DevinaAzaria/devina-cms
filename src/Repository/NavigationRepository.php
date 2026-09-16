<?php

declare(strict_types=1);
namespace DevinaCms\Repository;
use DevinaCms\Database;
use DevinaCms\Support\Clock;
use InvalidArgumentException;
final class NavigationRepository
{
    public function __construct(private readonly Database $db) {}
    public function create(array $data): int
    {
        $data=$this->normalize($data);$now=Clock::now();$s=$this->db->pdo()->prepare('INSERT INTO cms_navigation_items (location,label,url,parent_id,position,is_visible,created_at,updated_at) VALUES (:location,:label,:url,:parent_id,:position,:is_visible,:created_at,:updated_at)');$s->execute($data+['created_at'=>$now,'updated_at'=>$now]);return (int)$this->db->pdo()->lastInsertId();
    }
    public function update(int $id,array $data): void
    {
        $old=$this->find($id);if(!$old)throw new InvalidArgumentException('Navigation item not found.');$data=$this->normalize($data,$old);$s=$this->db->pdo()->prepare('UPDATE cms_navigation_items SET location=:location,label=:label,url=:url,parent_id=:parent_id,position=:position,is_visible=:is_visible,updated_at=:updated_at WHERE id=:id');$s->execute($data+['updated_at'=>Clock::now(),'id'=>$id]);
    }
    public function delete(int $id): void{$s=$this->db->pdo()->prepare('DELETE FROM cms_navigation_items WHERE id=:id');$s->execute(['id'=>$id]);}
    public function find(int $id): ?array{$s=$this->db->pdo()->prepare('SELECT * FROM cms_navigation_items WHERE id=:id');$s->execute(['id'=>$id]);$r=$s->fetch();return $r?:null;}
    public function all(?string $location=null,bool $publicOnly=false): array
    {
        $w=[];$p=[];if($location!==null){$w[]='location=:location';$p['location']=$location;}if($publicOnly)$w[]='is_visible=1';$sql='SELECT * FROM cms_navigation_items'.($w?' WHERE '.implode(' AND ',$w):'').' ORDER BY location ASC,position ASC,id ASC';$s=$this->db->pdo()->prepare($sql);$s->execute($p);return $s->fetchAll();
    }
    private function normalize(array $d,array $f=[]): array
    {
        $location=trim((string)($d['location']??$f['location']??'main'));$label=trim((string)($d['label']??$f['label']??''));$url=trim((string)($d['url']??$f['url']??''));if($location===''||$label===''||$url==='')throw new InvalidArgumentException('Location, label and URL are required.');return ['location'=>$location,'label'=>$label,'url'=>$url,'parent_id'=>($d['parent_id']??$f['parent_id']??null)?:null,'position'=>(int)($d['position']??$f['position']??0),'is_visible'=>!empty($d['is_visible']??$f['is_visible']??0)?1:0];
    }
}
