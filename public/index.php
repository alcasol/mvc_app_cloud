<?php
// ------------------------------------------------------------------------
// public/index.php
// ------------------------------------------------------------------------
// Este archivo es el punto de entrada principal de la aplicación web.
// Aquí se inicia la carga de la aplicación y se manejan las solicitudes
// de los usuarios. También cargo las variables de entorno
// ------------------------------------------------------------------------
//

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta según sea necesario
use Dotenv\Dotenv;
use Core\Router;

// Carga las variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Cargar las rutas definidas
$routes = require_once ROOT_PATH . '/config/routes.php';

// Obtener la URL solicitada
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Crear una instancia del enrutador
$router = new Router();

// Registrar todas las rutas definidas
foreach ($routes as $route => $params) {
    $router->{$params['method']}(ltrim($route, '/'), $params['handler']);
}

// Manejar la solicitud actual usando el enrutador
$router->handle($url, $_SERVER['REQUEST_METHOD']);

// configurar los encabezados HTTP necesarios para permitir solicitudes 
// CORS (Cross-Origin Resource Sharing) desde cualquier origen.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejar solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}
?>
