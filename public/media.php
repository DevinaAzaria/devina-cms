<?php

declare(strict_types=1);
require dirname(__DIR__).'/bootstrap.php';
use DevinaCms\Cms;use DevinaCms\Config;
$id=(int)($_GET['id']??0);if($id<1){http_response_code(404);exit;}$cms=new Cms();$m=$cms->media->find($id);if(!$m){http_response_code(404);exit;}$file=rtrim(Config::uploadPath(),'/\\').DIRECTORY_SEPARATOR.basename((string)$m['storage_name']);if(!is_file($file)){http_response_code(404);exit;}header('Content-Type: '.$m['mime_type']);header('Content-Length: '.filesize($file));header('X-Content-Type-Options: nosniff');header('Content-Disposition: inline; filename="'.rawurlencode((string)$m['filename']).'"');readfile($file);
