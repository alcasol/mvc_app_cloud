<?php
// ------------------------------------------------------------------------
// config/database.php
// ------------------------------------------------------------------------
// Retorna un array asociativo que contiene los detalles de la configuración
// necesaria para conectar tu aplicación PHP a la base de datos MySQL.
// ------------------------------------------------------------------------
//

require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta según sea necesario
use Dotenv\Dotenv;

// Carga las variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'host' => $_ENV['DB_HOST'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'dbname' => $_ENV['DB_NAME'],
];
?>
