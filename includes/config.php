<?php
/*
|--------------------------------------------------------------------------
| Sistema de Registro de Productos V1
|--------------------------------------------------------------------------
| Author: Markus Yarleque
| Project Name: RegisPro
| Version: v1
| Official page: http://github.com/markusyarleque
| Repository: http://github.com/markusyarleque/regispro
|--------------------------------------------------------------------------
|
*/

//Definición de la raíz del proyecto
define('SITE_ROOT_RAIZ', realpath(dirname(__FILE__) . '/../'));

// Cargar el archivo .env
loadEnv(SITE_ROOT_RAIZ . '/.env');

//Definición de variables globales del archivo .env
$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');
$version = getenv('VERSION');

//Seteo de las variables
define('DB_HOST', $dbHost);
define('DB_USER', $dbUser);
define('DB_PASS', $dbPassword);
define('DB_NAME', $dbName);
define('VERSION', $version);

//Definición de zona horaria del proyecto
date_default_timezone_set('America/Lima');
