<?php

declare(strict_types=1);
require dirname(__DIR__).'/bootstrap.php';
use DevinaCms\Cms;use DevinaCms\Config;use DevinaCms\Http\Json;
$cms=new Cms();
if(strtoupper($_SERVER['REQUEST_METHOD']??'GET')!=='GET')Json::send(['error'=>'method_not_allowed'],405);
$path=parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/';$base=Config::basePath();if($base!==''&&str_starts_with($path,$base))$path=substr($path,strlen($base))?:'/';$path='/'.ltrim($path,'/');
if($path==='/'||$path==='/health')Json::send(['name'=>'Devina CMS','version'=>'0.1.0-dev','status'=>'ok','api'=>Config::basePath().'/api/v1']);
if($path==='/api/v1/contents'){try{Json::send(['data'=>$cms->contents->published(isset($_GET['type'])&&$_GET['type']!==''?(string)$_GET['type']:null,(int)($_GET['limit']??20),(int)($_GET['offset']??0))]);}catch(Throwable $e){Json::send(['error'=>'invalid_request','message'=>$e->getMessage()],400);}}
if(preg_match('#^/api/v1/content/(page|article|event)/([a-z0-9-]+)$#',$path,$m)){if(!$item=$cms->contents->findPublishedBySlug($m[1],$m[2]))Json::send(['error'=>'not_found'],404);Json::send(['data'=>$item]);}
if(preg_match('#^/api/v1/navigation/([a-zA-Z0-9_-]+)$#',$path,$m))Json::send(['data'=>$cms->navigation->all($m[1],true)]);
if(preg_match('#^/api/v1/media/(\d+)$#',$path,$m)){if(!$item=$cms->media->find((int)$m[1]))Json::send(['error'=>'not_found'],404);$item['url']=Config::basePath().'/media.php?id='.(int)$item['id'];unset($item['storage_name']);Json::send(['data'=>$item]);}
Json::send(['error'=>'not_found'],404);
