<?php
// ----------------------------------------------------------------------------
// config/config.php
// ----------------------------------------------------------------------------
// Estas definiciones de constantes son útiles para proporcionar acceso rápido 
// y consistente a directorios importantes dentro de la aplicación PHP. Al usar
// define(), se crean constantes que no pueden ser modificadas o redefinidas 
// después de ser declaradas, asegurando así que estas rutas sean constantes y
// accesibles en todo el código PHP del proyecto.
// ------------------------------------------------------------------------
// 
define('APP_PATH', __DIR__ . '/../app/');
define('CORE_PATH', __DIR__ . '/../core/');
define('CONFIG_PATH', __DIR__ . '/../config/');
define('TEST_PATH', __DIR__ . '/../test/');
define('LOG_PATH', __DIR__ . '/../logs/');
define('VIEW_PATH', __DIR__ . '/../app/views/');
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

// Cargar variables de entorno desde el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Definir ROOT_PATH
define('ROOT_PATH', __DIR__ . '/..');

// Definir BASE_URL desde el archivo .env
define('BASE_URL', $_ENV['BASE_URL'] ?? '');

// Otras constantes
define('UPLOAD_PATH', ROOT_PATH . '/uploads');

?>
