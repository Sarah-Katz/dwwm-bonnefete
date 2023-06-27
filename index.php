<?php require_once 'vendor/autoload.php';

session_start();

require_once './Router.php';

use App\Router;

// Récupération des variables d'environnement pour la base de données
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);
define("LOCALPATH", $_ENV['LOCALPATH']);

// Lancement du Router
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$router = new Router($requestUri, $requestMethod);
$router->route();
