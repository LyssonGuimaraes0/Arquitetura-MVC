<?php 
//Requeste
require_once '../router/router.php';
require_once '../vendor/autoload.php';

//Configurações de Datas do Servidor
date_default_timezone_set('America/Sao_Paulo');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


?>