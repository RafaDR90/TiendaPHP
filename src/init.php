<?php
use routes\routes;
session_start();

require_once "../vendor/autoload.php";
require_once "../config/config.php";
require_once '../src/lib/router.php';
$dotenv=Dotenv\Dotenv::createImmutable(dirname(__DIR__,1)); //para acceder al archivo .env
$dotenv->safeLoad();

// Obtiene las rutas de la aplicación
//require_once "../src/routes/routes.php"; //cambiar esto por lo de abajo
Routes::getRoutes();