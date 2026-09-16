<?php

declare(strict_types=1);
putenv('DEVINA_CMS_DSN=sqlite::memory:');putenv('DEVINA_CMS_TIMEZONE=UTC');require dirname(__DIR__).'/bootstrap.php';
use DevinaCms\Cms;use DevinaCms\Support\Slug;
$fail=0;$ok=static function(bool $c,string $m)use(&$fail):void{if(!$c){$fail++;fwrite(STDERR,"FAIL: {$m}\n");}else echo "PASS: {$m}\n";};
$cms=new Cms();$cms->install();$ok(Slug::make('Hello, Dunia!')==='hello-dunia','slug normalization');
$id=$cms->users->create('admin@example.com','Admin','very-secure-password','admin');$u=$cms->users->findByEmail('admin@example.com');$ok($id>0&&$u&&password_verify('very-secure-password',$u['password_hash']),'admin password hashing');
$cms->contents->create(['type'=>'article','title'=>'Draft Article','body'=>'draft','status'=>'draft']);$ok(count($cms->contents->published('article'))===0,'draft hidden');
$pub=$cms->contents->create(['type'=>'article','title'=>'Published Article','body'=>'hello','status'=>'published']);$rows=$cms->contents->published('article');$ok(count($rows)===1&&(int)$rows[0]['id']===$pub,'published visible');
$cms->contents->create(['type'=>'article','title'=>'Future Article','body'=>'future','status'=>'published','published_at'=>'+2 days']);$ok(count($cms->contents->published('article'))===1,'future schedule hidden');
$dup=$cms->contents->create(['type'=>'article','title'=>'Published Article','body'=>'second','status'=>'published']);$ok($cms->contents->find($dup)['slug']==='published-article-2','unique slug suffix');
$cms->navigation->create(['location'=>'main','label'=>'Second','url'=>'/second','position'=>20,'is_visible'=>1]);$cms->navigation->create(['location'=>'main','label'=>'First','url'=>'/first','position'=>10,'is_visible'=>1]);$nav=$cms->navigation->all('main',true);$ok(count($nav)===2&&$nav[0]['label']==='First','navigation order');
$mid=$cms->media->create(['filename'=>'sample.png','storage_name'=>'abc.png','mime_type'=>'image/png','size_bytes'=>1234,'alt_text'=>'Sample']);$ok($mid>0&&$cms->media->find($mid)['alt_text']==='Sample','media metadata');
if($fail){fwrite(STDERR,"{$fail} test(s) failed.\n");exit(1);}echo "All tests passed.\n";
