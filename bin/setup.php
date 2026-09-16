<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';
use DevinaCms\Cms;

if (PHP_SAPI !== 'cli') { fwrite(STDERR,"CLI only.\n"); exit(1); }
$options=getopt('', ['email:','name::','password::']);
$email=trim((string)($options['email']??getenv('DEVINA_CMS_ADMIN_EMAIL')?:''));
$name=trim((string)($options['name']??getenv('DEVINA_CMS_ADMIN_NAME')?:'Administrator'));
$password=(string)($options['password']??getenv('DEVINA_CMS_ADMIN_PASSWORD')?:'');
$cms=new Cms(); $cms->install(); echo "Database schema ready.\n";
if($cms->users->count()>0){echo "Admin/editor account already exists.\n";exit(0);}
if($email===''||$password===''){fwrite(STDERR,"First setup requires --email and DEVINA_CMS_ADMIN_PASSWORD (recommended) or --password.\n");exit(1);}
try{$id=$cms->users->create($email,$name,$password,'admin');echo "Admin account created with ID {$id}.\n";}catch(Throwable $e){fwrite(STDERR,'Setup failed: '.$e->getMessage()."\n");exit(1);}
