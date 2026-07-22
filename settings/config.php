<?php 
//Requeste
require_once '../router/router.php';
require_once '../vendor/autoload.php';

//Configurações de Datas do Servidor
date_default_timezone_set('America/Sao_Paulo');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// raiz do projeto 
define('BASE_PATH', dirname(__DIR__));

// pastas principais
define('APP_PATH', BASE_PATH . '/app');

// subpastas
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('MODEL_PATH', APP_PATH . '/model');
define('VIEW_PATH', APP_PATH . '/view');
define('COMPONENTS_PATH', VIEW_PATH . '/components');
define('HELPER_PATH', APP_PATH . '/helpers');

//Caminho URL
define('BASE_URL', $_ENV['RAIZ_URL']);
/* define('SCRIPT_URL', BASE_URL . "/public" .  '/assets/js'); */




?>