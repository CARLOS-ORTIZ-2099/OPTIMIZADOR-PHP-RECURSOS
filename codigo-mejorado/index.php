<?php
require_once __DIR__ . "/includes/functions.php";
require_once __DIR__ . "/code/NewCode.php";
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/databases/Mongo.php";
require_once __DIR__ . "/databases/Mysql.php";
require_once __DIR__ . "/databases/Postgresql.php";


$mysql = new Mysql();
$postgesql = new PostsGresql();
$mongoDb =  new Mongo();


//debuguear($mysql, true);


$code = new NewCode($mysql);
//debuguear($code);
$response = $code->funct_traerDatos_module();

debuguear($response);
